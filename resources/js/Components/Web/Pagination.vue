rgb(255, 0, 13)<script setup>
const props = defineProps({
  links: [Object, Array],
  preserveState: false,
  preserveScroll: false,
})
</script>

<template>
  <div v-if="links.length > 3" class="basic-pagination">
    <nav>
      <ul>
        <li v-for="(link, key) in links">
          <a
            v-if="link.url === null"
            :key="key"
            :class="{ current: link.active }"
            v-html="link.label"
          ></a>
          <Link
            v-else
            :preserve-state="preserveState"
            :preserve-scroll="preserveScroll"
            :key="`link-${key}`"
            :class="{ current: link.active }"
            :href="link.url"
          >
            <span class="text-nowrap" v-html="link.label"></span>
          </Link>
        </li>
      </ul>
    </nav>
  </div>
</template>
