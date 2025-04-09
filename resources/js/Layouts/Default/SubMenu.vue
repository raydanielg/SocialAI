<script setup>
import SubMenu from '@/Layouts/Default/SubMenu.vue'
const props = defineProps({
  children: {
    type: [Array, Object]
  }
})
</script>

<template>
  <ul class="submenu">
    <li
      v-for="child in children"
      :key="child.id"
      :class="{ dropdown: child.children?.length > 0 }"
    >
      <a v-if="child.target == '_top'" :href="child.href ?? '#'">
        {{ child.text }}
      </a>
      <Link v-else :href="child.href ?? '#'" :target="child.target">
        {{ child.text }}
      </Link>
      <template v-if="child.children?.length > 0">
        <SubMenu :children="child.children" class="second-level" />
      </template>
    </li>
  </ul>
</template>
