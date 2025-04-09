<script setup>
import { Link } from '@inertiajs/vue3'
import sharedComposable from '@root/Composables/sharedComposable.js'

const { sanitizeHtml } = sharedComposable()

const props = defineProps({
  href: {
    type: String,
    required: false
  }
})
</script>

<template>
  <Link :href="sanitizeHtml(props.href ?? '')">
    <slot />
  </Link>
</template>
