<template>
  <div class="relative">
    <div
      ref="editableDiv"
      contenteditable="true"
      class="input-content rounded border border-gray-300 p-3 text-dark-300 focus:border-purple-500 focus:outline-none dark:border-dark-600"
      spellcheck="false"
      @input="handleInput"
      @keydown="handleKeydown"
      v-html="processedContent"
    ></div>
    <div
      v-if="!props.modelValue"
      class="pointer-events-none absolute left-3 top-3.5 text-sm text-gray-400"
    >
      Type your text here... Use [text] to highlight content
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, nextTick } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue'])
const editableDiv = ref(null)
const isUpdating = ref(false)
const lastCaretPosition = ref(null)

const processedContent = computed(() => {
  return props.modelValue.replace(/\[([^\]]+)\]/g, '<span class="highlighted-text">[$1]</span>')
})

const getCaretPosition = () => {
  const selection = window.getSelection()
  if (!selection.rangeCount) return null

  const range = selection.getRangeAt(0)
  const preCaretRange = range.cloneRange()
  preCaretRange.selectNodeContents(editableDiv.value)
  preCaretRange.setEnd(range.endContainer, range.endOffset)
  return preCaretRange.toString().length
}

const setCaretPosition = (position) => {
  const selection = window.getSelection()
  const range = document.createRange()
  let currentPos = 0
  let found = false

  function traverseNodes(node) {
    if (found) return
    if (node.nodeType === Node.TEXT_NODE) {
      const nodeLength = node.textContent.length
      if (currentPos + nodeLength >= position) {
        range.setStart(node, position - currentPos)
        range.setEnd(node, position - currentPos)
        found = true
        return
      }
      currentPos += nodeLength
    } else {
      for (const childNode of node.childNodes) {
        traverseNodes(childNode)
      }
    }
  }

  traverseNodes(editableDiv.value)

  if (found) {
    selection.removeAllRanges()
    selection.addRange(range)
  }
}

const handleInput = () => {
  if (isUpdating.value) return
  lastCaretPosition.value = getCaretPosition()
  const text = editableDiv.value.innerText
  emit('update:modelValue', text)
}

const findBracketedTextAtPosition = (text, position) => {
  const pattern = /\[[^\]]+\]/g
  let match

  while ((match = pattern.exec(text)) !== null) {
    const start = match.index
    const end = start + match[0].length

    if (position > start && position <= end) {
      return {
        text: match[0],
        start,
        end
      }
    }
  }

  return null
}

const handleKeydown = (e) => {
  if (e.key === 'Backspace') {
    const position = getCaretPosition()
    const text = editableDiv.value.innerText
    const bracketedText = findBracketedTextAtPosition(text, position)

    if (bracketedText) {
      e.preventDefault()
      const newText = text.slice(0, bracketedText.start) + text.slice(bracketedText.end)
      emit('update:modelValue', newText)
      lastCaretPosition.value = bracketedText.start
    } else {
      lastCaretPosition.value = position - 1
    }
  } else if (e.key === 'Delete') {
    lastCaretPosition.value = getCaretPosition()
  }
}

watch(
  () => props.modelValue,
  async () => {
    if (editableDiv.value && !isUpdating.value) {
      isUpdating.value = true

      const previousContent = editableDiv.value.innerHTML
      editableDiv.value.innerHTML = processedContent.value

      await nextTick()

      if (lastCaretPosition.value !== null) {
        setCaretPosition(lastCaretPosition.value)
      }

      isUpdating.value = false
    }
  }
)
</script>

<style>
.input-content {
  white-space: pre-wrap;
  word-break: break-word;
  line-height: 1.5;
}

.highlighted-text {
  color: rgb(168 85 247 / 1);
  cursor: pointer;
}

.input-content:empty::before {
  display: none;
}
</style>
