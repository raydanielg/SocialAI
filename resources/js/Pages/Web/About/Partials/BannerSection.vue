<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>
<template>
  <div class="about-banner-area p-relative">
    <div class="about-shape-1 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="about-shape-2 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="about-banner p-relative z-index fix">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="about-banner-content z-index-5">
              <h4
                class="about-banner-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="sanitizeHtml(data.title)"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
