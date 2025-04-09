<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>
<template>
  <div class="tp-about__area tp-about__pt-pb pb-160">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".2s">
          <div class="tp-about__img-wrapper text-lg-end p-relative text-center">
            <div class="tp-about__bg-shape">
              <img :src="sanitizeHtml(data.bg_image)" />
            </div>
            <div class="tp-about__main-img z-index">
              <img :src="sanitizeHtml(data.image2)" />
            </div>
            <div class="tp-about__sub-img-1 d-none d-sm-block z-index-3">
              <img :src="sanitizeHtml(data.image3)" />
            </div>
            <div class="tp-about__sub-img-2 d-none d-sm-block">
              <img :src="sanitizeHtml(data.image1)" />
            </div>
            <div class="tp-about__sub-img-3 d-none d-sm-block z-index-3">
              <img :src="sanitizeHtml(data.left_bottom)" />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".6s">
          <div class="tp-about__right">
            <div class="tp-about__section-box">
              <h4 class="tp-section-subtitle">{{ data.top_title }}</h4>
              <h3 class="tp-section-title mb-15">{{ data.title }}</h3>
              <p v-html="sanitizeHtml(data.sub_title)"></p>
            </div>
            <div class="tp-about__list">
              <ul>
                <li v-for="item in data.features?.split('|') ?? []" :key="item">
                  <i class="fal fa-check"></i>{{ item }}
                </li>
              </ul>
            </div>
            <div class="tp-about__btn">
              <a
                class="tp-btn tp-btn-inner tp-btn-hover alt-color-black"
                :href="sanitizeHtml(data.btn_link)"
              >
                <span>{{ data.btn_text }}</span>
                <b></b>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
