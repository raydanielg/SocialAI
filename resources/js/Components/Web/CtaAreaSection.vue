<script setup>
import { computed } from "vue";

import { usePage } from "@inertiajs/vue3";

const data = usePage().props.primaryData?.footer_cta ?? {}

const hideSection = computed(() => {
  let url = usePage().url
  return url.includes('/services/') || url.includes('/blogs/')
})

</script>

<template>
  <div class="tp-cta-area p-relative" v-if="!hideSection">
    <div class="tp-cta-grey-bg grey-bg-2"></div>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="tp-cta-bg" :style="{ backgroundImage: `url(${sanitizeHtml(data.img1)})` }">
            <div class="text-center tp-cta-content">
              <h3 class="text-white tp-section-title-lg">{{ data.title }}</h3>
              <p v-html="sanitizeHtml(data.sub_title)"></p>
              <a class="tp-btn-green" :href="sanitizeHtml(data.btn_link)"> {{ data.btn_text }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
