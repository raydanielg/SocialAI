<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'

defineOptions({ layout: DefaultLayout })
defineProps(['teams'])
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-height p-relative blue-bg-2">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="breadcrumb__content">
            <h3 class="breadcrumb__title tp-char-animation">
              {{ trans('Team Member') }}
            </h3>
            <div class="breadcrumb__list tp-title-anim">
              <span class="child-one"
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ trans('Team Member') }}</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-md-end d-none d-md-block text-center">
          <div class="breadcrumb__img p-relative z-index text-start">
            <img class="z-index-3" src="/assets/img/breadcrumb/breadcrumb-3.png" alt="" />
            <div
              class="breadcrumb__sub-img wow tpfadeUp"
              data-wow-duration=".9s"
              data-wow-delay=".4s"
            >
              <img src="/assets/img/breadcrumb/breadcrumb-sub-1.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!-- tp-team-area-start -->
  <div class="tp-team-area tp-team-inner pt-100 pb-90">
    <div class="container">
      <div class="tp-team-section-wrapper tp-team-inner-section mb-70">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="tp-team-section-box text-center">
              <h5 class="inner-section-subtitle pb-10">{{ trans('Talented Team') }}</h5>
              <h3 class="tp-section-title mb-0 text-black">
                {{ trans('Meet our Team Members') }}
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div
          v-for="team in teams"
          :key="team.id"
          class="col-xl-3 col-lg-4 col-md-6 col-sm-6 tp-border-after-1 team-inner-border-right"
        >
          <div class="tp-team-item tp-team-inner-title-color z-index text-center">
            <div class="tp-team-img">
              <img :src="sanitizeHtml(team.preview?.value)" alt="" />
            </div>
            <div class="tp-team-content">
              <h4 class="tp-team-title-sm">
                {{ team.title }}
              </h4>
              <span>{{ team.slug }}</span>
            </div>

            <div class="tp-team-social">
              <a
                class="icon-color-1"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.facebook)"
              >
                <i class="fab fa-facebook-f"></i>
                <span></span>
              </a>
              <a
                class="icon-color-2"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.instagram)"
              >
                <i class="fab fa-instagram"></i>
                <span></span>
              </a>
              <a
                class="icon-color-3"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.twitter)"
              >
                <i class="fab fa-twitter"></i>
                <span></span>
              </a>
              <a
                class="icon-color-4"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.linkedin)"
              >
                <i class="fab fa-linkedin-in"></i>
                <span></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-team-area-end -->
</template>
