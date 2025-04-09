<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation } from 'swiper/modules'
const props = defineProps(['testimonials'])

const data = {
  bg_img: '/assets/img/testimonial/testi-bg-3-1.png'
}

const swiperConfig = {
  spaceBetween: 50, // Spacing between slides (default in Swiper)
  modules: [Navigation],
  navigation: {
    nextEl: '.slick-next', // Selector for next arrow element
    prevEl: '.slick-prev' // Selector for previous arrow element
  },
  loop: true,
  breakpoints: {
    1200: {
      slidesPerView: 3 // Adjust slidesToShow for different screen sizes
    },
    995: {
      slidesPerView: 3
    },
    120: {
      slidesPerView: 1
    }
  }
}
</script>

<template>
  <div class="tp-testimonial-area tp-testimonial-3-mlr pb-110">
    <div class="tp-testimonial-3-bg pt-110 fix" :style="`background-image: url(${sanitizeHtml(data.bg_img)});`">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div
              class="tp-testimonial-3-section-box d-flex justify-content-between align-items-end mb-60"
            >
              <h3 class="tp-section-title-3 text-white">
                <span>{{ trans('Kind Words') }}</span> <br />
                {{ trans('from our Customers') }}
              </h3>
              <div class="tp-test-arrow d-flex pb-10">
                <button type="button" class="slick-prev slick-arrow">
                  <i class="fal fa-angle-left"></i></button
                ><button type="button" class="slick-next slick-arrow">
                  <i class="fal fa-angle-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tp-testimonial-3-slider-wrapper">
        <div class="container-fluid g-0">
          <div class="row g-0">
            <div class="col-12">
              <Swiper v-bind="swiperConfig" class="tp-testimonial-3-slider-active mb-105">
                <SwiperSlide
                  v-for="item in testimonials"
                  class="tp-testimonial-wrapper"
                  :key="item.id"
                >
                  <div
                    class="tp-testimonial-3-item d-flex justify-content-between align-items-center"
                  >
                    <div class="tp-testimonial-3-content-box">
                      <div class="tp-testimonial-3-review">
                        <span v-for="star in parseInt(item.lang)" :key="star"
                          ><i class="fas fa-star"></i
                        ></span>
                      </div>
                      <p>
                        {{ item.excerpt?.value }}
                      </p>
                      <div class="tp-testimonial-3-author-info d-flex align-items-center">
                        <div class="tp-testimonial-3-sm-thumb d-md-none">
                          <img :src="sanitizeHtml(item.preview?.value)" alt="" />
                        </div>
                        <div>
                          <h5>{{ item.title }}</h5>
                          <span>{{ item.slug }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="tp-testimonial-3-thumb d-none d-md-block">
                      <img :src="sanitizeHtml(item.preview?.value)" alt="" />
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
