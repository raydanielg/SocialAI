<script setup>
import sharedComposable from '@/Composables/sharedComposable'
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'

const { socialShare, textExcerpt } = sharedComposable()

defineOptions({ layout: DefaultLayout })
const props = defineProps(['integration', 'sidebarIntegrations', 'servicePage'])
const { sidebar_card } = props.servicePage ?? {}
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
        <div class="col-md-8">
          <div class="breadcrumb__content">
            <h3 class="breadcrumb__title tp-char-animation">
              {{ textExcerpt(integration.title, 35) }}
            </h3>
            <div class="breadcrumb__list tp-title-anim">
              <span class="child-one">
                <Link href="/">{{ trans('Home') }}</Link>
              </span>
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ trans('Integrations') }}</span>
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ integration.title }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4 text-md-end d-none d-md-block mt-40 text-center">
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

  <!-- service-details-area-start -->
  <div class="sv-details-area pt-100 pb-30">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4">
          <div class="sv-details-widget">
            <div class="sv-details-category mb-30">
              <div class="sv-details-category-title">
                <h4 class="sv-details-title-sm">{{ trans('Integrations') }}</h4>
              </div>
              <div class="sv-details-category-list">
                <ul>
                  <li
                    v-for="item in sidebarIntegrations"
                    :class="{ active: integration.id == item.id }"
                    :key="item.id"
                  >
                    <Link :href="`/integrations/${sanitizeHtml(item.slug)}`"
                      ><span>{{ textExcerpt(item.title, 18) }}</span>
                      <i class="fal fa-angle-right"></i
                    ></Link>
                  </li>
                </ul>
              </div>
            </div>
            <div
              class="tp-service__dashboard mb-30"
              :style="{ 'background-image': `url(${sanitizeHtml(sidebar_card.bg_img)})` }"
            >
              <div class="tp-service__top-content">
                <h3 class="tp-service__title-white" v-html="sanitizeHtml(sidebar_card.title)"></h3>
                <p v-html="sanitizeHtml(sidebar_card.sub_title)"></p>
                <a
                  class="tp-btn-orange tp-btn-hover alt-color-white"
                  :href="sanitizeHtml(sidebar_card.btn_link ?? '#')"
                >
                  <span>{{ sidebar_card.btn_text }}</span>
                  <b></b>
                </a>
              </div>
              <div class="tp-service__dashdboard-sm-img">
                <img
                  class="wow tpfadeRight"
                  data-wow-duration=".9s"
                  data-wow-delay=".3s"
                  :src="sanitizeHtml(sidebar_card.bottom_img)"
                  alt=""
                />
              </div>
            </div>
            <div class="sv-details-social-box mb-30">
              <h4 class="sv-details-title-sm">{{ trans('Share it.') }}</h4>
              <div class="sv-details-social-link">
                <a :href="socialShare('facebook')"><i class="fab fa-facebook-f"></i></a>
                <a :href="socialShare('twitter')"><i class="fab fa-twitter"></i></a>
                <a :href="socialShare('linkedin')"><i class="fab fa-linkedin"></i></a>
                <a :href="socialShare('instagram')"><i class="fab fa-instagram"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 col-lg-8">
          <div class="sv-details-wrapper">
            <div class="sv-details-thumb mb-45">
              <img class="w-100" :src="sanitizeHtml(integration.preview_2)" alt="" />
            </div>

            <div v-html="sanitizeHtml(integration.long_description)"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- service-details-area-end -->
</template>
