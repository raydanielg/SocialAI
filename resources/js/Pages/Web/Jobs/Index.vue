<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'

import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import JobArea from '@/Pages/Web/About/Partials/JobArea.vue'

defineOptions({ layout: DefaultLayout })
const props = defineProps(['jobs', 'career_page'])

const career_header = props.career_page.career_header ?? {}
const career_platform = props.career_page.career_platform ?? {}

const active = ref(2)

const handleToggle = (index) => {
  active.value = index
}

const handleAll = () => {
  active.value = 'all'
}

const mediaSize = () => {
  if (window.matchMedia('(max-width: 768px)').matches) {
    active.value = 'all'
  } else {
    active.value = 2
  }
}

onMounted(() => {
  mediaSize()
  window.addEventListener('resize', mediaSize, false)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', mediaSize, false)
})
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-height-3 p-relative blue-bg-2 fix">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="breadcrumb__content-wrap">
        <div class="row justify-content-center">
          <div class="col-xl-12">
            <div class="breadcrumb__content z-index-3 mb-60 text-center">
              <h3 class="breadcrumb__title" v-html="sanitizeHtml(career_header.title)"></h3>
              <div class="breadcrumb__text">
                <p>{{ career_header.sub_title }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!-- carrer-banner-area-start -->
  <div class="carrer-banner-area carrer-banner-space">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-3 col-lg-3 col-md-6">
          <div class="carrer-banner-img-item">
            <img :src="sanitizeHtml(career_header.image1)" alt="Career" />
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
          <div class="carrer-banner-img-item parallax-main">
            <img
              class="parallax-img"
              :src="sanitizeHtml(career_header.image2)"
              alt="Career"
              data-parallax='{"y": 300, "smoothness": 10}'
            />
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
          <div class="carrer-banner-img-item mb-20">
            <img :src="sanitizeHtml(career_header.image3)" alt="Career" />
          </div>
          <div class="carrer-banner-img-item">
            <img :src="sanitizeHtml(career_header.image4)" alt="Career" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- carrer-banner-area-end -->

  <!-- tp-platform-area-start -->
  <div class="tp-platform-area tp-platform-inner p-relative z-index pt-80">
    <div class="container">
      <div class="row align-items-end mb-60">
        <div class="col-xl-7 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".3s">
          <div class="tp-platform-section-box">
            <h5 class="inner-section-subtitle pb-10">{{ career_platform?.top_title }}</h5>
            <h3 class="tp-section-title">{{ career_platform?.title }}</h3>
          </div>
        </div>
        <div class="col-xl-5 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".5s">
          <div class="tp-platform-text">
            <p>
              {{ career_platform?.sub_title }}
            </p>
          </div>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-xl-2 col-lg-2 d-none d-xl-block">
          <div class="tp-platform-img-box">
            <img :src="career_platform?.image1" alt="platform left image" />
          </div>
        </div>
        <div class="col-xl-10 col-lg-12">
          <div class="job-we-offer">
            <div
              v-for="(item, i) in career_platform?.items ?? []"
              :key="i"
              :class="`col-custom ${active === 'all' ? 'active' : i === active ? 'active' : ''}`"
              @click=";`${active !== 'all' ? handleToggle(i) : handleAll()}`"
            >
              <div class="tp-panel-item">
                <div class="tp-panel-content">
                  <span>{{ i + 1 }}.</span>
                  <h4 class="tp-panel-title child-one">{{ item.title }}</h4>
                </div>
              </div>
              <div class="tp-panel-item-2">
                <div class="tp-panel-content-2">
                  <span>{{ i + 1 }}.</span>
                  <h4 class="tp-panel-title-2">{{ item.title }}</h4>
                  <p>{{ item.body }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-platform-area-end -->

  <!-- tp-job-area-start -->
  <JobArea :jobs="jobs" :data="career_page.career_jobs" />
  <!-- tp-job-area-end -->
</template>
