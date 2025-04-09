<script setup>
import { ref, onMounted, onUnmounted } from "vue"

const isOpen = ref(false)

const selectContainer = ref(null)
const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const outsideClick = (event) => {
  if (isOpen.value && !selectContainer.value.contains(event.target)) {
    isOpen.value = false
  }
}
onMounted(() => {
  document.addEventListener("click", outsideClick)
})

onUnmounted(() => {
  document.removeEventListener("click", outsideClick)
})
</script>

<template>
  <div class="border nice-select w-100" :class="{ open: isOpen }">
    <div class="current me-2" @click.stop="toggleDropdown">
      {{ $page.props.languages[$page.props.locale] }}
    </div>

    <ul class="list w-100" ref="selectContainer">
      <li
        class="option"
        :class="{
          'selected focus': key === $page.props.locale,
        }"
        v-for="(lang, key) in $page.props.languages"
        :key="key"
      >
        <Link
          as="button"
          :href="route('set-locale', key)"
          method="patch"
          class="dropdown-btn w-100 text-start"
        >
          {{ trans(lang) }}
        </Link>
      </li>
    </ul>
  </div>
</template>
