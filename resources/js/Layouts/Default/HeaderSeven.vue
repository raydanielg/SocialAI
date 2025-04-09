<script setup>
import Navbar from './NavMenu.vue';

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
              <NuxtLink to="/"><img src="/assets/img/logo/logo-white.png" alt="image-here"></NuxtLink>
            </div>
          </div>
          <div class="col-6">
            <div class="header-signin-bar text-end tp-menu-bar">
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
              <NuxtLink to="/"><img src="/assets/img/logo/logo-white.png" alt="image-here"></NuxtLink>
            </div>
          </div>
          <div class="col-xxl-7 col-xl-7 col-lg-7 d-none d-lg-block">
            <div class="header-bottom__main-menu header-bottom__main-menu-4 header-bottom__main-menu-inner">
              <nav id="mobile-menu-2">
                <Navbar />
              </nav>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-8 col-6">
            <div class="header-bottom__right d-flex align-items-center justify-content-end">
              <div class="header-bottom__action header-bottom__action-4">
                <NuxtLink class="d-none d-lg-inline-block header-bottom__action-2 border-none" to="/register">
                  <span>Log In</span>
                </NuxtLink>
              </div>
              <div class="header-bottom__btn d-flex align-items-center">
                <a class="tp-btn-yellow d-none d-md-inline-block inner-color" href="#">Get in Touch</a>
                <a class="header-bottom__bar tp-menu-bar d-lg-none" href="#"><i class="fal fa-bars"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- tp-header-area-end -->
  </header>
  <CommonOffcanvus :toggleMenu="toggleMenu" :openMenu="openMenu" /> 
</template>
