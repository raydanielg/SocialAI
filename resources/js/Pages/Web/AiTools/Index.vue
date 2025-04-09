<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import sharedComposable from '@/Composables/sharedComposable'
const { textExcerpt } = sharedComposable()
defineOptions({ layout: DefaultLayout })
defineProps(['tools'])
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
        <div class="col-xl-8 col-lg-7">
          <div class="breadcrumb__content">
            <h3 class="breadcrumb__title tp-char-animation">
              {{ trans('AI Tools') }}
            </h3>
            <div class="breadcrumb__list tp-title-anim">
              <span class="child-one"
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ trans('AI Tools') }}</span>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-5 col-lg-4 text-md-end text-center">
          <div class="breadcrumb__img p-relative z-index text-start">
            <img class="z-index-3" src="/assets/img/ai-tool-logo.png" alt="" />
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
  <div class="tp-team-area tp-team-inner pt-100 pb-75">
    <div class="container">
      <div class="tp-team-section-wrapper tp-team-inner-section mb-70">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="tp-team-section-box text-center">
              <h5 class="inner-section-subtitle pb-10">
                {{ trans('Artificial Intelligence Tools') }}
              </h5>
              <h3 class="tp-section-title mb-0 text-black">
                {{ trans('Our AI Tools') }}
              </h3>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div
          v-for="tool in tools"
          :key="tool.id"
          class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-70 tp-border-after-1 team-inner-border-right"
        >
          <div class="tp-team-item tp-team-inner-title-color z-index text-center">
            <div class="tp-team-img">
              <img :src="tool.preview" alt="" />
            </div>
            <div class="tp-team-content">
              <h4 class="tp-team-title-sm">
                {{ tool.title }}
              </h4>
              <span>{{ textExcerpt(tool.description, 30) }}</span>
            </div>
            <Link href="/user/ai-tools" class="btn btn-outline-primary">{{
              trans('open tool')
            }}</Link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-team-area-end -->
</template>
