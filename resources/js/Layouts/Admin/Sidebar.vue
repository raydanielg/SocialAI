<script setup>
import { onMounted } from 'vue'
import sharedComposable from '@root/Composables/sharedComposable.js'
import SimpleBar from 'simplebar'
import { usePage } from '@inertiajs/vue3'

const { sanitizeUrl } = sharedComposable()
const page = usePage()

const isRouteNameValid = (url = '#') => {
  try {
    url = route(url)
  } catch (error) {}
  return sanitizeUrl(canParse(url) ? new URL(url).pathname : url)
}

function canParse(url) {
  try {
    new URL(url)
    return true
  } catch (e) {
    return false
  }
}

const sidebarMenu = page.props.sidebar_menu
onMounted(() => {
  const wrapper = document.querySelector('.wrapper')
  const sidebar = document.querySelector('.sidebar')
  const content = document.querySelector('.sidebar-content')
  const menuItems = document.querySelectorAll('.sidebar-menu')

  const init = () => {
    initMenuItems()
    initWrapper()
    initOverlay()
    handleWindowResize()
    initSidebarHover()
    initScrollBar()
  }

  const initMenuItems = () => {
    if (menuItems.length) {
      menuItems.forEach((menuItem) => {
        const parent = menuItem.parentElement
        const submenu = parent.querySelector('.sidebar-submenu')
        const arrow = menuItem.querySelector('.sidebar-menu-arrow')

        if (submenu) {
          menuItem.addEventListener('click', (e) => {
            e.preventDefault()
            toggleHeight(submenu, submenu.scrollHeight)
            arrow.classList.toggle('rotate')
          })
        }

        if (submenu && menuItem.classList.contains('active')) {
          toggleHeight(submenu, submenu.scrollHeight)
          arrow.classList.toggle('rotate')
        }
      })
    }
  }

  const toggleHeight = (element, height) => {
    if (element.style.height === '0px' || element.style.height === '') {
      element.style.height = `${height}px`
    } else {
      element.style.height = '0px'
    }
  }

  const initWrapper = () => {
    if (sidebar) {
      if (sidebar.classList.contains('collapsed')) {
        wrapper.classList.add('expanded')
      } else {
        wrapper.classList.remove('expanded')
      }
    }
  }

  const initOverlay = () => {
    const overlay = document.createElement('div')
    overlay.classList.add('sidebar-overlay')
    document.body.appendChild(overlay)

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('expanded')
      overlay.classList.remove('active')
    })
  }

  const handleWindowResize = () => {
    if (sidebar) {
      window.addEventListener('resize', () => {
        if (window.innerWidth < 1024) {
          sidebar.classList.remove('collapsed')
          wrapper.classList.remove('expanded')
        } else {
          sidebar.classList.remove('expanded')
        }
      })
    }
  }

  const initSidebarHover = () => {
    if (sidebar) {
      sidebar.addEventListener('mouseenter', () => {
        if (window.innerWidth > 1024) {
          sidebar.classList.add('hovered')
        }
      })

      sidebar.addEventListener('mouseleave', () => {
        if (window.innerWidth > 1024) {
          sidebar.classList.remove('hovered')
        }
      })
    }
  }

  const initScrollBar = () => {
    if (sidebar) {
      new SimpleBar(content)

      const activeMenu = document.querySelector('.sidebar-menu.active')
      const activeSubmenu = document.querySelector('.sidebar-submenu-item.active')
      if (activeSubmenu) {
        activeSubmenu.scrollIntoView({ block: 'center', behavior: 'smooth' })
      } else if (activeMenu) {
        activeMenu.scrollIntoView({ block: 'center', behavior: 'smooth' })
      }
    }
  }

  init()
})

const canAccess = ({ permission }) => {
  return true
}

var counter = 0

const isActive = (menu) => {
  let isMenuActive = false
  let hasChildActive = false
  try {
    if (menu.href) {
      let menuUrl = isRouteNameValid(menu.href)
      isMenuActive = page.url.includes(menuUrl)
    }

    if (menu.type && menu.type === 'dropdown') {
      menu.children.map((sub) => {
        let subMenuUrl = isRouteNameValid(sub.href)
        if (page.url.includes(subMenuUrl)) {
          hasChildActive = true
        }
      })
    }
  } catch (error) {}
  return isMenuActive || hasChildActive
}

const isActiveModule = (moduleName) => {
  return page.props?.activeModule == moduleName
}
</script>

<template>
  <aside class="sidebar">
    <a href="/">
      <div class="sidebar-header">
        <div class="sidebar-logo-icon">
          <img
            v-lazy="$page.props.primaryData.deep_logo"
            alt="logo"
            class="block h-[30px] dark:hidden"
          />
          <img
            v-lazy="$page.props.primaryData.logo"
            alt="logo"
            class="hidden h-[30px] dark:block"
          />
        </div>
      </div>
    </a>

    <!-- Sidebar Menu Starts -->
    <ul class="sidebar-content relative">
      <div>
        <!-- dropdown menu item -->
        <template v-for="groupeMenu in sidebarMenu" :key="groupeMenu.id">
          <div v-if="groupeMenu.heading" class="sidebar-menu-header">
            {{ trans(groupeMenu.heading) }}
          </div>
          <li v-for="menu in groupeMenu.links" :key="menu.id">
            <template v-if="menu.children?.length > 0">
              <a
                href="javascript:void(0);"
                class="sidebar-menu"
                :class="{ active: isActive(menu) }"
              >
                <span class="sidebar-menu-icon">
                  <Icon :icon="menu.icon ?? 'home'" />
                </span>
                <span class="sidebar-menu-text">{{ menu.text ?? '' }}</span>
                <span class="sidebar-menu-arrow">
                  <Icon icon="bx:chevron-right" />
                </span>
              </a>
              <ul class="sidebar-submenu">
                <template v-for="subItem in menu.children" :key="subItem.text">
                  <li v-if="canAccess(subItem)">
                    <template v-if="isActiveModule(menu?.module)">
                      <Link
                        :href="isRouteNameValid(subItem.href)"
                        class="sidebar-submenu-item"
                        :class="{ active: isActive(subItem) }"
                      >
                        {{ trans(subItem.text) }}
                      </Link>
                    </template>
                    <template v-else>
                      <a
                        :href="isRouteNameValid(subItem.href)"
                        class="sidebar-submenu-item"
                        :class="{ active: isActive(subItem) }"
                      >
                        {{ trans(subItem.text) }}
                      </a>
                    </template>
                  </li>
                </template>
              </ul>
            </template>
            <template v-else>
              <Link
                v-if="isActiveModule(groupeMenu?.module)"
                :href="isRouteNameValid(menu.href) ?? '#'"
                class="sidebar-menu"
                :class="{ active: isActive(menu) }"
              >
                <span class="sidebar-menu-icon">
                  <Icon :icon="menu.icon ?? 'home'" />
                </span>
                <span class="sidebar-menu-text">
                  {{ trans(menu.text) }}
                </span>
              </Link>
              <a
                v-else
                :href="isRouteNameValid(menu.href) ?? '#'"
                class="sidebar-menu"
                :class="{ active: isActive(menu) }"
              >
                <span class="sidebar-menu-icon">
                  <Icon :icon="menu.icon ?? 'home'" />
                </span>
                <span class="sidebar-menu-text">{{ trans(menu.text) }} </span>
              </a>
            </template>
          </li>
        </template>
      </div>
    </ul>
    <!-- Sidebar Menu Ends -->
  </aside>
</template>