<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>

<template>
  <div class="tp-payment-method__area tp-payment-method__space">
    <div class="container-fluid g-0">
      <div class="row g-0 justify-content-center">
        <div class="col-xl-7">
          <div class="tp-payment-method__title-box mb-20 text-center">
            <h3 class="tp-section-title-lg pb-10" v-html="sanitizeHtml(data.title)"></h3>
            <p v-html="sanitizeHtml(data.subtitle)"></p>
          </div>
        </div>
      </div>
      <div class="row g-0">
        <div class="col-12">
          <div class="tp-payment-method__wrapper p-relative text-center">
            <div class="tp-payment-method__main-circle p-relative z-index">
              <div class="tp-payment-method__main-img z-index-3">
                <img :src="sanitizeHtml(data.img_main)" alt="" />
              </div>
              <div class="tp-payment-method__line-1">
                <div class="tp-payment-method__circle circle-1"></div>
                <span><img :src="sanitizeHtml(data.img_1)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-2 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-2"></div>
                <span><img :src="sanitizeHtml(data.img_2)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-3">
                <div class="tp-payment-method__circle circle-3"></div>
                <span><img :src="sanitizeHtml(data.img_3)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-4 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-4"></div>
                <span><img :src="sanitizeHtml(data.img_4)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-5">
                <div class="tp-payment-method__circle circle-5"></div>
                <span><img :src="sanitizeHtml(data.img_5)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-6 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-6"></div>
                <span><img :src="sanitizeHtml(data.img_6)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-7">
                <div class="tp-payment-method__circle circle-7"></div>
                <span><img :src="sanitizeHtml(data.img_7)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-8 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-8"></div>
                <span><img :src="sanitizeHtml(data.img_8)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-9">
                <div class="tp-payment-method__circle circle-9"></div>
                <span><img :src="sanitizeHtml(data.img_9)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-10 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-10"></div>
                <span><img :src="sanitizeHtml(data.img_10)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-11">
                <div class="tp-payment-method__circle circle-11"></div>
                <span><img :src="sanitizeHtml(data.img_11)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-12 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-12"></div>
                <span><img :src="sanitizeHtml(data.img_12)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-13">
                <div class="tp-payment-method__circle circle-13"></div>
                <span><img :src="sanitizeHtml(data.img_13)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-14 d-none d-lg-block">
                <div class="tp-payment-method__circle circle-14"></div>
                <span><img :src="sanitizeHtml(data.img_14)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-15">
                <div class="tp-payment-method__circle circle-15"></div>
                <span><img :src="sanitizeHtml(data.img_15)" alt="" /></span>
              </div>
              <div class="tp-payment-method__line-16">
                <div class="tp-payment-method__circle circle-16"></div>
                <span><img :src="sanitizeHtml(data.img_16)" alt="" /></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
