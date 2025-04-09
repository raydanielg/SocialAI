<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import IntegrationSection from '@/Pages/Web/Home/Partials/IntegrationSection.vue'

defineOptions({ layout: DefaultLayout })
const props = defineProps(['integrations', 'home', 'integration_page', 'integrations_featured'])

const data = props.integration_page ?? {
  hero: {},
  list: {},
  slider: {}
}
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-ptb-3 p-relative blue-bg-2">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="breadcrumb__content z-index-1">
            <h3 class="breadcrumb__title tp-char-animation">
              {{ data.hero.title }}
            </h3>
            <div class="breadcrumb__list wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".4s">
              <span class="child-one"
                ><a href="#">{{ trans('Home') }}</a></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ trans('Integrations') }}</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-md-end d-none d-md-block text-center">
          <div class="breadcrumb__img p-relative z-index text-start">
            <img class="z-index-3" :src="sanitizeHtml(data.hero.banner_img)" alt="" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!-- tp-feature-area-start -->
  <div class="tp-feature-area pt-100 pb-30">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="tp-feature-five-section-box mb-40 text-center">
            <h3 class="tp-section-title-5 text-black">
              <span v-html="sanitizeHtml(data.list.title)"></span>
            </h3>
            <p>
              {{ data.list.sub_title }}
            </p>
          </div>
        </div>
      </div>
      <div class="row gx-0 tp-feature-five-wrapper-main tp-feature-inner">
        <div
          v-for="(integration, index) in integrations_featured"
          :key="index"
          class="col-xl-3 col-lg-6 col-md-6"
        >
          <div class="tp-feature-five-wrapper">
            <div
              class="tp-feature-five-item z-index text-center"
              :class="`tp-feature-five-item-${index + 1}`"
            >
              <div class="tp-feature-five-icon p-relative">
                <img :src="integration.preview" alt="" />
                <div
                  class="tp-feature-five-shape-color"
                  :style="{ backgroundColor: integration.bg_color ?? '#FFE01B' }"
                ></div>
              </div>
              <div class="tp-feature-five-content">
                <h4 class="tp-feature-five-title-sm">
                  {{ integration.title }}
                </h4>
                <p>
                  {{ integration.short_description }}
                </p>
              </div>
              <div class="tp-feature-five-btn">
                <Link class="tp-btn-purple" :href="route('integrations.show', integration)">{{
                  trans('Learn More')
                }}</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-feature-area-end -->

  <!-- tp-integration-area-start -->
  <IntegrationSection :data="data.slider ?? {}" :integrations_featured="integrations" />
  <!-- tp-integration-area-end -->
</template>
