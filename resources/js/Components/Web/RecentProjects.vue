<script setup>
import { Swiper, SwiperSlide } from "swiper/vue"
import { Navigation, Scrollbar } from "swiper/modules"
import { ref } from "vue"

const props = defineProps({
  projects: {
    type: Array,
    default: [],
  },
})

// Define reactive state
const isDragged = ref(false)
// Define methods
const handleSlideChange = () => {
  isDragged.value = true
}

const handleTransitionEnd = () => {
  isDragged.value = false
}
</script>

<template>
  <!-- tp-project-area-start -->
  <div class="tp-project__area grey-bg pt-50 pb-110 fix">
    <div class="container">
      <div class="row">
        <div class="col-xl-6">
          <div
            class="tp-project__section-box wow tpfadeLeft"
            data-wow-duration=".9s"
            data-wow-delay=".3s"
          >
            <h3 class="tp-section-title">
              {{ trans("Check Some Of Our Recent Work.") }}
            </h3>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid gx-0">
      <div class="row gx-0">
        <div class="col-xl-12">
          <div class="tp-project__slider-section">
            <Swiper
              :slidesPerView="3"
              :space-between="30"
              :loop="true"
              :modules="[Navigation, Scrollbar]"
              :breakpoints="{
                '1200': {
                  slidesPerView: 3,
                },
                '992': {
                  slidesPerView: 1,
                },
                '768': {
                  slidesPerView: 1,
                },
                '576': {
                  slidesPerView: 1,
                },
                '0': {
                  slidesPerView: 1,
                },
              }"
              :scrollbar="{
                el: '.tp-scrollbar',
                clickable: true,
              }"
              :onSliderMove="handleSlideChange"
              :onTransitionEnd="handleTransitionEnd"
              :class="`swiper-container tp-project__slider-active ${
                isDragged ? 'dragged' : ''
              }`"
            >
              <SwiperSlide
                v-for="(project, i) in projects"
                :key="i"
                class="swiper-slide wow tpfadeUp"
                data-wow-duration=".9s"
                data-wow-delay=".5s"
              >
                <div class="tp-project__slider-wrapper">
                  <div class="tp-project__item d-flex align-items-center">
                    <div class="tp-project__thumb">
                      <Link :href="route('projects.show', project.slug)">
                        <img :src="project.preview" alt="image-here" />
                       </Link>
                    </div>
                    <div class="tp-project__content">
                     
                      <div class="tp-project__title-box">
                        <h4 class="tp-project__title-sm">
                          <Link :href="route('projects.show', project.slug)">
                          {{ project.title }}
                          </Link>
                                                  
                        </h4>
                        <p>{{ project.description }}</p>
                      </div>
                      <div class="tp-project__meta d-flex align-items-center">
                        <div class="tp-project__author-info">
                          <span>{{ trans("Client Name") }}</span>
                          <h4>{{ project.client }}</h4>
                        </div>
                        <div class="tp-project__budget">
                          <span>{{ trans("Service") }}</span>
                          <h4>{{ project.category?.title }}</h4>
                        </div>
                        <div class="tp-project__link">
                          <Link :href="route('projects.show', project.slug)">
                            <svg
                              width="14"
                              height="14"
                              viewBox="0 0 14 14"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M1.00098 7H13.001"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M7.00098 1L13.001 7L7.00098 13"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                            </svg>
                          </Link>
                        </div>
                      </div>
                    </div>
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
  <!-- tp-project-area-end -->
</template>
