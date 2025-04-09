<script setup>
import { usePage } from '@inertiajs/vue3'
import SubMenu from '@/Layouts/Default/SubMenu.vue'
const mainMenu = usePage().props.menus.filter(
  item => item.position === 'main-menu'
)[0]
</script>

<template>
  <nav id="mobile-menu" v-if="mainMenu">
    <ul>
      <li v-for="item in mainMenu.data ?? []" :key="item.id">
        <Link
          v-if="item.href"
          :href="item.href"
          :target="item.target"
          role="button"
        >
          {{ item.text }}
        </Link>

        <Link v-else href="#"> {{ item.text }} </Link>

        <template v-if="item.children?.length > 0">
          <SubMenu :children="item.children" class="first-level" />
        </template>
      </li>
    </ul>
  </nav>
</template>
