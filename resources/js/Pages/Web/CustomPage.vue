<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'

defineOptions({ layout: DefaultLayout })
defineProps(['page'])
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
              {{ page.title }}
            </h3>
            <div class="breadcrumb__list tp-title-anim">
              <span class="child-one"
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ page.title }}</span>
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

  <div class="container pb-4 pt-60">
    <div v-html="sanitizeHtml(page.description?.value)"></div>
  </div>
</template>
