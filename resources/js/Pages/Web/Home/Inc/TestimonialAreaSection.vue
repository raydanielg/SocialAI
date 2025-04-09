<script setup>
import 'swiper/css'
import 'swiper/css/pagination'

import { Pagination } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/vue'

import sharedComposable from '@/Composables/sharedComposable'

const { textExcerpt } = sharedComposable()

const props = defineProps({
  data: {
    type: Object,
    default: {}
  },
  testimonials: {
    type: Array,
    default: []
  }
})
</script>

<template>
  <div
    class="tp-testimonial-2-area pt-110 pb-120"
    :style="`background-image:url(${sanitizeHtml(data.bg_image ?? '/assets/img/testimonial/testi-bg-2-1.png')})`"
  >
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8">
          <div class="tp-testimonial-2-section-box mb-15 text-center">
            <h3 class="tp-section-title-lg text-white">{{ data.title }}</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="tp-testimonial-2-section">
            <div class="">
              <Swiper
                :pagination="true"
                :modules="[Pagination]"
                :space-between="30"
                :breakpoints="{
                  1200: {
                    slidesPerView: 3
                  },
                  768: {
                    slidesPerView: 2
                  },
                  480: {
                    slidesPerView: 1
                  }
                }"
              >
                <SwiperSlide
                  v-for="(testimonial, index) in testimonials"
                  :key="index"
                  class="tp-testimonial-2-item p-relative wow tpfadeUp"
                  data-wow-duration=".9s"
                  :data-wow-delay="`${0.3 + index * 0.2}s`"
                >
                  <div class="tp-testimonial-2-border-shape">
                    <img :src="sanitizeHtml(testimonial.body_img)" alt="" />
                  </div>
                  <div class="tp-testimonial-2-star">
                    <span v-for="i in testimonial.rating" :key="i">
                      <svg
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M8 0L10.472 5.26604L16 6.11567L12 10.2124L12.944 16L8 13.266L3.056 16L4 10.2124L0 6.11567L5.528 5.26604L8 0Z"
                          fill="#FFCF55"
                        />
                      </svg>
                    </span>
                  </div>
                  <div class="tp-testimonial-2-content">
                    <p>{{ textExcerpt(testimonial.description, 120) }}</p>
                  </div>
                  <div class="tp-testimonial-2-author d-flex align-items-center">
                    <div class="tp-testimonial-2-img">
                      <img :src="sanitizeHtml(testimonial.image)" class="rounded-circle" alt="" />
                    </div>
                    <div class="tp-testimonial-2-author-info">
                      <h5>{{ testimonial.name }}</h5>
                      <span>{{ testimonial.designation }}</span>
                    </div>
                  </div>
                </SwiperSlide>
              </Swiper>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
