<script setup>
import { usePage } from '@inertiajs/vue3'
import { computed, onMounted, ref } from 'vue'
import sharedComposable from '@/Composables/sharedComposable'
import NavMenu from '@/Layouts/Default/NavMenu.vue'
import MobileMenu from '@/Layouts/Default/MobileMenu.vue'
const { authUser, currentRouteGroup } = sharedComposable()

const props = defineProps({
  theme: {
    type: String,
    default: 'light'
  }
})

const isDark = computed(() => {
  true
})

const socialMedia = usePage().props.primaryData['socials']

const openMenu = ref(false)
const toggleMenu = () => {
  openMenu.value = !openMenu.value
}
</script>

<template>
  <header>
    <!-- tp-header-area-start -->
    <div class="header-signin-area header-bottom__transparent header-signin-ptb z-index-5">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-6">
            <div class="header-signin-logo">
              <a v-if="currentRouteGroup('Auth', false)" href="/">
                <img :src="$page.props.primaryData.logo" alt="" />
              </a>
              <a v-else href="/"><img :src="$page.props.primaryData.deep_logo" alt="" /></a>
            </div>
          </div>
          <div class="col-6">
            <div class="header-signin-bar tp-menu-bar text-end">
              <button @click="toggleMenu">
                <i>
                  <span></span>
                  <span></span>
                  <span></span>
                </i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-bottom__area header-bottom__transparent header-bottom__bdr z-index-5 d-none">
      <div class="container">
        <div class="row g-0 align-items-center">
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-6">
            <div class="header-bottom__logo">
              <a href="/"
                ><img
                  :src="isDark ? $page.props.primaryData.deep_logo : $page.props.primaryData.logo"
                  alt=""
              /></a>
            </div>
          </div>
          <div class="col-xxl-7 col-xl-7 col-lg-7 d-none d-lg-block">
            <div
              class="header-bottom__main-menu header-bottom__main-menu-4 header-bottom__main-menu-inner"
            >
              <nav class="mobile-menu">
                <NavMenu />
              </nav>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-8 col-6">
            <div class="header-bottom__right d-flex align-items-center justify-content-end">
              <div class="header-bottom__action header-bottom__action-4">
                <template v-if="authUser">
                  <a
                    class="d-none d-lg-inline-block header-bottom__action-2 border-none"
                    :href="authUser.role == 'admin' ? '/admin/dashboard' : '/user/dashboard'"
                  >
                    <span>{{ trans('Dashboard') }}</span>
                  </a>
                </template>

                <template v-if="!authUser">
                  <Link
                    class="d-none d-lg-inline-block header-bottom__action-2 border-none"
                    href="/login"
                  >
                    <span>{{ trans('Login') }}</span>
                  </Link>
                </template>
              </div>
              <div class="header-bottom__btn d-flex align-items-center">
                <Link
                  :class="
                    isDark
                      ? 'tp-btn-blue-sm d-none d-md-inline-block tp-btn-hover alt-color-black'
                      : 'tp-btn-white tp-btn-hover alt-color-black d-none d-md-inline-block'
                  "
                  href="/register"
                >
                  <span :class="isDark ? 'text-white' : ''">{{ trans('Get Free') }}</span>
                  <b></b>
                </Link>
                <a class="header-bottom__bar tp-menu-bar d-lg-none" href="#"
                  ><i class="fal fa-bars"></i
                ></a>
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
