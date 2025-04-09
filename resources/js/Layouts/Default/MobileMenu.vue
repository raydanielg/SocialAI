<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const mainMenu = usePage().props.menus.filter((item) => item.position === 'main-menu')[0]
const menuItems = (mainMenu?.data ?? [])?.map((item) => {
  return {
    id: item.id,
    has_dropdown: item.children?.length ? true : false,
    text: item.text,
    href: item.href,
    sub_menus: item.children
  }
})

const navTitle = ref('')
// openMobileMenu
const openMobileMenu = (menu) => {
  if (navTitle.value === menu) {
    navTitle.value = ''
  } else {
    navTitle.value = menu
  }
}

const subTitle = ref('')
// openMobileMenu
const openMobileSubMenu = (menu) => {
  if (subTitle.value === menu) {
    subTitle.value = ''
  } else {
    subTitle.value = menu
  }
}

// closeMobileMenu
const emit = defineEmits(['closeMobileMenu'])

const closeMobileMenu = () => {
  emit('closeMobileMenu')
}
</script>

<template>
  <nav class="mean-nav">
    <ul>
      <li
        v-for="(menu, index) in menuItems"
        :key="index"
        :class="`${menu.has_dropdown ? 'has-dropdowns' : ''}`"
      >
        <Link :href="menu.href" @click="closeMobileMenu">{{ menu.text }}</Link>
        <template v-if="menu.has_dropdown">
          <ul class="submenu" :style="`display: ${navTitle === menu.text ? 'block' : 'none'}`">
            <li v-for="(sub_menu, i) in menu.sub_menus" :key="i">
              <Link @click="closeMobileMenu" :href="sub_menu.href">{{ sub_menu.text }}</Link>

              <template v-if="sub_menu.children?.length > 0">
                <ul
                  class="submenu"
                  :style="`display: ${subTitle === sub_menu.text ? 'block' : 'none'}`"
                >
                  <li v-for="(sub_menu, i) in sub_menu.children" :key="i">
                    <Link @click="closeMobileMenu" :href="sub_menu.href">{{ sub_menu.text }}</Link>
                  </li>
                </ul>
                <a
                  :class="`mean-expand ${subTitle === sub_menu.text ? 'mean-clicked' : ''}`"
                  @click="() => openMobileSubMenu(sub_menu.text)"
                  href="#"
                  ><i class="fal fa-plus"></i
                ></a>
              </template>
            </li>
          </ul>
          <a
            :class="`mean-expand ${navTitle === menu.text ? 'mean-clicked' : ''}`"
            @click="() => openMobileMenu(menu.text)"
            href="#"
            ><i class="fal fa-plus"></i
          ></a>
        </template>
      </li>
    </ul>
  </nav>
</template>
