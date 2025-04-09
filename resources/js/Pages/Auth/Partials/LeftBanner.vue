<script setup>
defineProps(['data'])
</script>

<template>
  <div
    class="signin-banner-left-box signin-banner-bg p-relative"
    :style="{
      backgroundImage: `url(${sanitizeHtml(sanitizeHtml(data.bg_image ?? '/assets/images/login/login-bg-shape.png'))})`
    }"
  >
    <div class="signin-banner-bottom-shape">
      <img :src="data.image5" alt="" />
    </div>
    <div class="signin-banner-left-wrap">
      <div class="signin-banner-title-box mb-100">
        <h4
          class="signin-banner-title tp-char-animation"
          v-html="sanitizeHtml(data.banner_text)"
        ></h4>
      </div>
      <div class="signin-banner-img-box position-relative">
        <div class="signin-banner-img signin-img-1 d-none d-md-block z-index-3">
          <img :src="data.image2" alt="" />
        </div>
        <div class="signin-banner-img signin-img-2 d-none d-md-block">
          <img :src="data.image1" alt="" />
        </div>
        <div class="signin-banner-img signin-img-3 d-none d-md-block z-index-5">
          <img :src="data.image3" alt="" />
        </div>
        <div class="signin-banner-img signin-img-4 d-none d-sm-block">
          <img :src="data.image4" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>
