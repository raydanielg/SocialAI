<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps({
  btnType: {
    type: String,
    default: 'text'
  },
  btnText: {
    type: String,
    default: 'Toggle'
  },
  iconName: {
    type: String,
    default: 'bx:dots-horizontal-rounded'
  },
  btnClass: {
    type: String,
    default: 'btn'
  },
  iconClass: {
    type: String,
    default: 'text-2xl'
  },
  position: {
    type: String,
    default: 'right'
  },
  activeClass: {
    type: String,
    default: 'text-primary-500'
  }
})

const dropdown = ref(false)
const dropdownBtn = ref(null)
const dropdownContent = ref(null)
const currentPosition = ref(props.position)

const dropdownPosition = {
  right: 'right-1',
  left: 'left-1'
}

const toggleDropdown = () => {
  dropdown.value = !dropdown.value
  nextTick(() => {
    if (dropdownContent.value) {
      const rect = dropdownBtn.value.getBoundingClientRect()
      const contentWidth = dropdownContent.value.offsetWidth
      const spaceLeft = rect.left
      const spaceRight = window.innerWidth - rect.right
      if (spaceLeft < contentWidth && spaceRight < contentWidth) {
        currentPosition.value = props.position
      } else if (props.position === 'right' && spaceLeft < contentWidth) {
        currentPosition.value = 'left'
      } else if (props.position === 'left' && spaceRight < contentWidth) {
        currentPosition.value = 'right'
      } else {
        currentPosition.value = props.position
      }
    }
  })
}

defineExpose({ toggleDropdown })
const outsideClick = (event) => {
  if (
    dropdown.value &&
    !dropdownContent.value.contains(event.target) &&
    !dropdownBtn.value.contains(event.target) &&
    event.target !== dropdownBtn.value
  ) {
    dropdown.value = false
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
  <div class="relative flex max-w-min flex-col">
    <button
      ref="dropdownBtn"
      type="button"
      @click="toggleDropdown"
      class="max-w-max"
      :class="[dropdown ? activeClass : '', btnClass]"
    >
      <template v-if="btnText && btnType === 'text'"> {{ btnText }}</template>
      <template v-else-if="btnText && btnType === 'icon'">
        <Icon :class="iconClass" :icon="iconName" />
      </template>
      <slot v-else-if="btnType === 'slot'" name="btnContent">{{ btnText }}</slot>
    </button>
    <Transition name="slide-bottom">
      <div
        ref="dropdownContent"
        v-if="dropdown"
        :class="dropdownPosition[currentPosition] || 'right-0'"
        class="absolute right-0 top-full z-[500] mt-1 min-w-max overflow-hidden whitespace-nowrap rounded-md border bg-slate-50 shadow-lg dark:border-secondary-700 dark:bg-dark-800"
      >
        <slot>
          <p v-for="i in 10" :key="i">Dropdown Contents</p>
        </slot>
      </div>
    </Transition>
  </div>
</template>
