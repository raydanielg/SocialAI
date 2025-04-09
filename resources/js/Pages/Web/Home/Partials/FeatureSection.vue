<script setup>
import { usePage } from '@inertiajs/vue3'
const { cta_s3 } = usePage().props.homeData ?? { cta_s3: {} }
</script>

<template>
  <div class="tp-browser-details-area pt-110 pb-30 p-relative" v-if="cta_s3">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-9 col-lg-9">
          <div
            class="tp-browser-section-box d-flex justify-content-between align-items-center mb-30"
          >
            <h3 class="tp-section-title-3" v-html="sanitizeHtml(cta_s3.title)"></h3>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3">
          <div class="tp-browser-btn text-lg-end mb-40 text-start">
            <Link class="tp-btn-blue-lg tp-btn-hover" :href="sanitizeHtml(cta_s3.btn_link)">
              <span>{{ cta_s3.btn_text }}</span>
            </Link>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="tp-hero-browser-wrapper footer-browser-item d-flex align-items-center">
            <div v-for="icon in cta_s3.icons" :key="icon" class="tp-hero-browser-item">
              <Link :href="sanitizeHtml(icon.link)">
                <img :src="sanitizeHtml(icon.icon)" alt="" />
              </Link>
              <p class="d-none d-sm-block">{{ icon.title }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
