<script setup>
import { onMounted } from 'vue'

import moment from 'moment'
import { Scrollbar } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/vue'

import RecentProjects from '@/Components/Web/RecentProjects.vue'
import TestimonialArea from '@/Components/Web/TestimonialArea.vue'
import sharedComposable from '@/Composables/sharedComposable'
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'

const { socialShare } = sharedComposable()

defineOptions({ layout: DefaultLayout })
defineProps(['project', 'recentItems'])
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
            <div class="breadcrumb__content z-index-3 mb-60">
              <div
                class="breadcrumb__text wow tpfadeIn"
                data-wow-duration=".9s"
                data-wow-delay=".6s"
              >
                <span>{{ project.category?.title }}</span>
              </div>
              <h3 class="breadcrumb__title">{{ project.title }}</h3>
            </div>
          </div>
        </div>
        <div class="row g-0 z-index-3">
          <div class="col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40">
            <div class="breadcrumb__client-info space-left-1">
              <span>{{ trans('CLIENT') }}</span>
              <p>
                {{ project.client }}
              </p>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40">
            <div class="breadcrumb__client-info space-left-2">
              <span>{{ trans('Services') }}</span>
              <p>
                {{ project.category?.title }}
              </p>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40">
            <div class="breadcrumb__client-info space-left-3">
              <span>{{ trans('Project Date') }}</span>
              <p>{{ moment(project.release_at).format('MMM DD, YYYY') }} <br /></p>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 pd-border-right mb-40" v-if="project.preview_link">
            <div class="breadcrumb__client-info space-left-4">
              <span>{{ trans('Live Preview') }}</span>
              <div class="breadcrumb__live-btn">
                <a class="tp-btn-inner-border" :href="sanitizeHtml(project.preview_link)"
                  >{{ trans('See live') }} <i class="fal fa-arrow-up"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!-- project-img-area-start -->
  <div class="pd-thumb-area">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="pd-thumb">
            <img :src="sanitizeHtml(project.banner_preview)" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- project-img-area-end -->

  <!-- project-details-area-start -->
  <div class="pd-details-area pt-100 pb-100">
    <div class="container">
      <div class="row g-0">
        <div class="col-xl-2 col-lg-2 social-box-pin">
          <div class="pd-details-social-box text-lg-center p-relative text-start">
            <div class="pd-details-social-title">
              <span>{{ trans('Share This') }} <br />{{ trans('Story') }}</span>
            </div>
            <div class="pd-details-social">
              <a :href="socialShare('facebook')"><i class="fab fa-facebook-f"></i></a>
              <a :href="socialShare('twitter')"><i class="fab fa-twitter"></i></a>
              <a :href="socialShare('linkedin')"><i class="fab fa-linkedin"></i></a>
              <a :href="socialShare('instagram')"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
        </div>
        <div class="col-xl-10 col-lg-10">
          <div class="pd-details-wrapper">
            <div class="pd-details-info">
              <h4 class="pd-details-title">{{ trans('Description') }}</h4>
              <p>
                {{ project.description }}
              </p>
            </div>
            <div class="pd-details-overview">
              <h4 class="pd-details-title">{{ trans('Overview') }}</h4>

              <p v-html="sanitizeHtml(project.overview)"></p>
            </div>
            <div class="pd-details-solution">
              <div class="row">
                <div class="col-md-3">
                  <div class="pd-solution-title-box">
                    <h4 class="pd-details-title">{{ trans('Solution & Result') }}</h4>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="pd-solution-paragraph">
                    <p>
                      {{ project.output }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- project-details-area-end -->
  <RecentProjects :projects="recentItems" />
</template>
