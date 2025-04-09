<script setup>
import { Autoplay } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/vue'

const props = defineProps(['data'])

const swiperConfig = {
  spaceBetween: 30,
  speed: 12000,
  autoplay: {
    delay: 0,
    disableOnInteraction: false
  },
  modules: [Autoplay],

  loop: true,

  breakpoints: {
    1600: {
      slidesPerView: 4
    },
    1200: {
      slidesPerView: 3
    },
    1024: {
      slidesPerView: 2
    },
    480: {
      slidesPerView: 2
    }
  },
  cssEase: 'linear'
}
</script>

<template>
  <div class="tp-integration-area tp-integration-mlr pb-80">
    <div class="container">
      <div class="row align-items-end tp-integration-section-space">
        <div class="col-xl-6 col-lg-8 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
          <div class="tp-integration-section-box">
            <h5 class="tp-integration-subtitle">{{ data.top_title }}</h5>
            <h3 class="tp-section-title-3" v-html="sanitizeHtml(data.title)"></h3>
          </div>
        </div>
        <div
          v-if="$page.url === '/'"
          class="col-xl-6 col-lg-4 wow tpfadeRight"
          data-wow-duration=".9s"
          data-wow-delay=".7s"
        >
          <div class="tp-integration-btn text-lg-end text-start">
            <Link
              class="tp-btn-blue-lg tp-btn-hover alt-color-black"
              :href="sanitizeHtml(data.btn_link)"
            >
              <span>{{ data.btn_text }}</span>
            </Link>
          </div>
        </div>
      </div>
    </div>
    <div class="tp-integration-slider-wrapper pt-50 pb-50">
      <Swiper v-bind="swiperConfig" class="tp-integration-slider-active my-4">
        <SwiperSlide
          v-for="integration in data.row_one"
          :key="integration.id"
          class="tp-integration-slider-main"
        >
          <div class="tp-integration-slider-item">
            <img :src="sanitizeHtml(integration.preview)" alt="preview" />
          </div>
        </SwiperSlide>
      </Swiper>
      <Swiper v-bind="swiperConfig" class="tp-integration-slider-active my-4" dir="rtl">
        <SwiperSlide
          v-for="integration in data.row_two"
          :key="integration.id"
          class="tp-integration-slider-main"
        >
          <div class="tp-integration-slider-item">
            <img :src="sanitizeHtml(integration.preview)" alt="preview" />
          </div>
        </SwiperSlide>
      </Swiper>
    </div>
  </div>
</template>
