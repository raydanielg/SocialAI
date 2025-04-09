<script lang="ts" setup>
import sharedComposable from '@/Composables/sharedComposable.js'

const { sanitizeHtml } = sharedComposable()
const props = defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>

<template>
  <div class="tp-account-area pb-120">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6 col-lg-6">
          <div
            class="tp-account-thumb-wrapper p-relative wow tpfadeLeft text-center"
            data-wow-duration=".9s"
            data-wow-delay=".5s"
          >
            <div class="tp-account-bg">
              <img :src="sanitizeHtml(data.img1)" alt="" />
            </div>
            <div class="tp-account-main-img">
              <img :src="sanitizeHtml(data.img2)" alt="" />
            </div>
            <div class="tp-account-author">
              <img :src="sanitizeHtml(data.img3)" alt="" />
            </div>
            <div class="tp-account-shape-1">
              <img :src="sanitizeHtml(data.img4)" alt="" />
            </div>
            <div class="tp-account-shape-2">
              <img :src="sanitizeHtml(data.img5)" alt="" />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="tp-account-step-wrapper">
            <div class="tp-account-section-box mb-40">
              <h4 class="tp-section-subtitle-2">{{ data.title }}</h4>
              <h3 class="tp-section-title-lg">{{ data.sub_title }}</h3>
            </div>
            <div class="tp-account-step mb-50">
              <div
                v-for="(item, index) in data.steps?.split(',')"
                :key="index"
                class="tp-account-item d-flex align-items-center"
              >
                <span>{{ index + 1 }}</span>
                <p>{{ item }}</p>
              </div>
            </div>
            <div class="tp-account-btn-box">
              <a class="tp-btn-green mb-15" :href="sanitizeHtml(data.btn_link)">
                {{ data.btn_text }}</a
              >
              <p>{{ data.bottom_text }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
