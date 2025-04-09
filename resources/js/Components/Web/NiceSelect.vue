<script setup>
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
const props = defineProps({
  options: [Array, Object],
  modelValue: [String, Number],
  label: String,
  valueBy: {
    type: [String, Number]
  },
  placeholder: {
    type: String,
    default: 'Select Value'
  }
})
const isOpen = ref(false)
const selectedOption = ref(null)
const emit = defineEmits(['update:modelValue', 'change'])

const selectedOptionText = ref(props.placeholder)
const selectContainer = ref(null)
const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}
const findSelectOptionText = computed(() => {
  if (props.valueBy) {
    return props.options?.find((op) => op[props.valueBy] === props.modelValue)
  } else {
    return props.options?.find((op) => op === props.modelValue)
  }
})

const selectOption = (option) => {
  isOpen.value = false
  selectedOption.value = props.valueBy ? option[props.valueBy] : option
  selectedOptionText.value = props.label ? option[props.label] : option
  emit('update:modelValue', selectedOption.value)
  emit('change')
}
const displaySelectedOptionText = computed(() => {
  if (findSelectOptionText.value) {
    return findSelectOptionText.value[props.label] || findSelectOptionText.value
  } else {
    return selectedOptionText.value
  }
})
watch(
  () => props.modelValue,
  (newVal) => {
    if (newVal == '' || newVal == null) {
      selectedOptionText.value = props.placeholder
    }
  }
)
const outsideClick = (event) => {
  if (isOpen.value && !selectContainer.value.contains(event.target)) {
    isOpen.value = false
  }
}
onMounted(() => {
  document.addEventListener('click', outsideClick)
})

onUnmounted(() => {
  document.removeEventListener('click', outsideClick)
})
</script>

<template>
  <div class="nice-select" :class="{ open: isOpen }">
    <div class="current me-2" @click.stop="toggleDropdown">
      {{ displaySelectedOptionText }}
    </div>

    <ul class="list" ref="selectContainer">
      <li
        class="option"
        :class="{
          'selected focus':
            selectedOption && (option[valueBy] == selectedOption || option === selectedOption)
        }"
        v-for="(option, index) in options"
        :key="index"
        @click="selectOption(option)"
      >
        {{ label ? option[label] : option }}
      </li>
      <li v-if="options?.length < 1" class="option">{{ trans('empty') }}</li>
    </ul>
  </div>
</template>
