<script setup>
defineProps({
  links: [Object, Array],
  preserveState: false
})
</script>

<template>
  <div v-if="links.length > 3">
    <div class="paginate-container mt-3">
      <template v-for="(link, key) in links">
        <div
          v-if="link.url === null"
          :key="key"
          class="paginate-link paginate-link-null border border-gray-200 dark:border-gray-600"
          v-html="link.label"
        ></div>
        <Link
          v-else
          :preserve-state="preserveState"
          :key="`link-${key}`"
          class="paginate-link paginate-link-active border border-gray-300 dark:border-gray-700"
          :class="{ 'paginate-link-active-bg': link.active }"
          :href="link.url"
        >
          <span v-html="link.label"></span>
        </Link>
      </template>
    </div>
  </div>
</template>
