<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Scrollbar } from 'swiper/modules'
import trans from '@/Composables/transComposable'
const bg_img = '/assets/img/testimonial/testi-bg-5-1.jpg'
const props = defineProps(['testimonials'])
</script>

<template>
  <!-- tp-testimonial-area-start -->
  <div
    class="tp-testimonial-area pt-100 pb-100 fix"
    :style="{ backgroundImage: `url(${sanitizeHtml(bg_img)})`, backgroundSize: 'cover' }"
  >
    <div class="container">
      <div class="row align-items-end tp-testimonial-five-section-space">
        <div class="col-md-8">
          <div class="tp-testimonial-five-section-box">
            <span class="tp-section-subtitle-5">{{ trans('CLIENTS & PROJECTS') }}</span>
            <h3 class="tp-section-title-5">
              {{ trans('About Customer') }} <span>{{ trans('Stories') }}</span>
            </h3>
          </div>
        </div>
        <div class="col-md-4">
          <div
            class="tp-testimonial-five-arrow d-flex align-items-center justify-content-start justify-content-md-end"
          >
            <div class="test-next">
              <button><i class="far fa-arrow-left"></i></button>
            </div>
            <div class="test-prev">
              <button><i class="far fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-12">
          <div class="tp-testimonial-five-slider-section">
            <Swiper
              :space-between="30"
              :loop="true"
              centeredSlides="true"
              :modules="[Navigation, Scrollbar]"
              :scrollbar="{
                el: '.tp-scrollbar',
                clickable: true
              }"
              :navigation="{
                nextEl: '.test-next',
                prevEl: '.test-prev'
              }"
              :breakpoints="{
                '992': {
                  slidesPerView: 2
                },
                '768': {
                  slidesPerView: 1
                }
              }"
              class="mb-50 container"
            >
              <SwiperSlide v-for="(item, i) in testimonials" :key="i" class="swiper-slide">
                <div class="tp-testimonial-five-item">
                  <div
                    class="tp-testimonial-five-wrapper d-flex justify-content-between align-items-center"
                  >
                    <div class="tp-testimonial-five-top-info d-flex align-items-center">
                      <div class="tp-testimonial-five-avata">
                        <img :src="item.preview?.value ?? ''" alt="image-here" />
                      </div>
                      <div class="tp-testimonial-five-author-info">
                        <h4>{{ item.title }}</h4>
                        <span>{{ item.slug }}</span>
                      </div>
                    </div>
                   
                  </div>
                  <div class="tp-testimonial-five-content">
                    <p>{{ item.excerpt?.value ?? '' }}</p>
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
  <!-- tp-testimonial-area-end -->
</template>
