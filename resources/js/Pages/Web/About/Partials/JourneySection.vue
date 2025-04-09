<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Scrollbar } from 'swiper/modules'
defineProps({
  data: {
    type: Object,
    default: {}
  }
})

const breakpoints = {
  1200: {
    slidesPerView: 5
  },
  992: {
    slidesPerView: 3
  },
  768: {
    slidesPerView: 2
  },
  576: {
    slidesPerView: 2
  },
  0: {
    slidesPerView: 1
  }
}
</script>

<template>
  <!-- tp-journey-area-start -->
  <div class="journey-area p-relative fix">
    <div class="journey-grey-bg grey-bg"></div>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="journey-section-box">
            <h5 class="inner-section-subtitle pb-10">{{ data.top_title }}</h5>
            <h3 class="ab-brand-title mb-0 pb-0">{{ data.title }}</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid g-0">
      <div class="row g-0">
        <div class="col-xl-12">
          <div class="journey-slider-wrapper my-5">
            <Swiper
              :loop="true"
              :slides-per-view="5"
              :space-between="30"
              :modules="[Scrollbar]"
              :scrollbar="{
                el: '.tp-scrollbar',
                clickable: true
              }"
              :breakpoints="breakpoints"
              class="py-5"
            >
              <SwiperSlide v-for="(item, i) in data.features" :key="i" class="swiper-slide">
                <div class="journey-slider-item p-relative">
                  <div class="journey-stroke-text">
                    <h2>{{ i + 1 }}</h2>
                  </div>
                  <div class="journey-slider-meta">
                    <span>{{ item.date }}</span>
                  </div>
                  <div class="journey-slider-content">
                    <h4 class="journey-slider-title" v-html="sanitizeHtml(item.title)"></h4>
                    <p v-html="sanitizeHtml(item.body)"></p>
                  </div>
                </div>
              </SwiperSlide>
            </Swiper>
            <div class="tp-scrollbar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-journey-area-end -->
</template>
