<script setup>
defineProps({
  dotClass: {
    default: 'dot'
  }
})
</script>

<template>
  <div class="hollow-dots-spinner">
    <div :class="dotClass"></div>
    <div :class="dotClass"></div>
    <div :class="dotClass"></div>
  </div>
</template>
