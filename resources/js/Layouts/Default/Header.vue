<script setup>
import { computed, onMounted, ref } from "vue"

import sharedComposable from "@/Composables/sharedComposable"
import { usePage } from "@inertiajs/vue3"

import MobileMenu from "./MobileMenu.vue"
import NavMenu from "./NavMenu.vue"

const { authUser } = sharedComposable()

const props = defineProps({
  theme: {
    type: String,
    default: "light",
  },
})

const isDark = computed(() => {
  if (props.theme === "dark") {
    return true
  }
  let darkThemeActiveWhenVisitUrls = ["/", "/projects"]

  return darkThemeActiveWhenVisitUrls.includes(usePage().url)
})

const socialMedia = usePage().props.primaryData["socials"] ?? {}

const openMenu = ref(false)
const toggleMenu = () => {
  openMenu.value = !openMenu.value
}
</script>

<template>
  <header class="tp-header-height">
    <!-- tp-header-area-start -->
    <div id="header-sticky"
      class="header-bottom__area header__space header-sticky-bg-2 header-bottom__transparent z-index-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-4 col-6">
            <div class="header-bottom__logo">
              <a href="/"><img :src="isDark
                  ? $page.props.primaryData.deep_logo
                  : $page.props.primaryData.logo
                " alt="" /></a>
            </div>
          </div>

          <div class="col-xxl-6 col-xl-6 col-lg-6 d-none d-lg-block">
            <div class="header-bottom__main-menu header-bottom__main-menu-inner" :class="isDark
                ? 'header-bottom__main-menu-3'
                : 'header-bottom__main-menu-4'
              ">
              <NavMenu />
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-8 col-6">
            <div class="header-bottom__right d-flex align-items-center justify-content-end">
              <div class="header-bottom__action" :class="isDark ? '' : 'header-bottom__action-4'">
                <template v-if="authUser">
                  <a class="d-none d-lg-inline-block header-bottom__action-2 border-none" :href="authUser.role == 'admin'
                      ? '/admin/dashboard'
                      : '/user/dashboard'
                    ">
                    <Icon icon="iconoir:home-simple" class="fs-5" />
                    <span>{{ trans("Dashboard") }}</span>
                  </a>
                </template>

                <template v-if="!authUser">
                  <Link class="d-none d-lg-inline-block header-bottom__action-2 border-none" href="/login">
                  <Icon icon="iconoir:lock" class="fs-5" />
                  <span>{{ trans("Login") }}</span>
                  </Link>
                </template>
              </div>

              <div class="header-bottom__btn d-flex align-items-center">
                <Link v-if="!authUser" :class="isDark
                    ? 'tp-btn-blue-sm d-none d-md-inline-block tp-btn-hover alt-color-black'
                    : 'tp-btn-white tp-btn-hover alt-color-black d-none d-md-inline-block'
                  " href="/register">
                <span class="white-text">{{ trans("Get Free") }}</span>
                <b></b>
                </Link>
                <a @click="toggleMenu" class="header-bottom__bar tp-menu-bar d-lg-none" href="#"><i
                    class="fal fa-bars"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- tp-header-area-end -->
  </header>

  <!-- tp-offcanvus-area-start -->
  <div class="tpoffcanvas-area">
    <div :class="`tpoffcanvas ${openMenu ? 'opened' : ''}`">
      <div class="tpoffcanvas__close-btn" @click="toggleMenu">
        <button class="close-btn">
          <Icon class="fs-4" icon="ep:close" />
        </button>
      </div>
      <div class="tpoffcanvas__logo text-center">
        <a href="/">
          <img :src="$page.props.primaryData?.logo" alt="" />
        </a>
      </div>
      <div class="mobile-menu mean-container">
        <MobileMenu />
      </div>

      <div class="tpoffcanvas__social">
        <div class="social-icon text-center">
          <a :href="sanitizeHtml(socialMedia.twitter)"><i class="fab fa-twitter"></i></a>
          <a :href="sanitizeHtml(socialMedia.instagram)"><i class="fab fa-instagram"></i></a>
          <a :href="sanitizeHtml(socialMedia.facebook)"><i class="fab fa-facebook-square"></i></a>
          <a :href="sanitizeHtml(socialMedia.linkedin)"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
    </div>
    <!-- body-overlay -->
    <div :class="`body-overlay ${openMenu ? 'apply' : ''}`" @click="toggleMenu"></div>
    <!-- body-overlay -->
  </div>
  <!-- tp-offcanvus-area-end -->
</template>
