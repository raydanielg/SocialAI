<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>

<template>
  <div id="payment-method" class="tp-payment__area pt-110 pb-110">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-7">
          <div class="tp-payment__title-box mb-55 text-center">
            <h3 class="tp-section-title-lg" v-html="sanitizeHtml(data.title)"></h3>
            <p>{{ data.subtitle }}</p>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-md-6 mb-30">
              <div
                class="tp-payment__item tp-payment__bg-color-2 p-relative z-index wow tpfadeLeft"
                data-wow-duration=".9s"
                data-wow-delay=".3s"
              >
                <div class="tp-payment__shape-4">
                  <img :src="sanitizeHtml(data.card_left_img_one)" alt="" />
                </div>
                <div class="tp-payment__shape-5">
                  <img :src="sanitizeHtml(data.card_left_img_two)" alt="" />
                </div>
                <div class="tp-payment__shape-6">
                  <img :src="sanitizeHtml(data.card_left_img_three)" alt="" />
                </div>
                <div class="tp-payment__shape-7">
                  <img :src="sanitizeHtml(data.card_left_img_four)" alt="" />
                </div>
                <div class="tp-payment__shape-8">
                  <img :src="sanitizeHtml(data.card_left_img_five)" alt="" />
                </div>
                <div class="tp-payment__content">
                  <h3 class="tp-payment__title">{{ data.card_left_title }}</h3>
                  <p v-html="sanitizeHtml(data.card_left_sub_title)"></p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-30">
              <div
                class="tp-payment__item tp-payment__bg-color-3 p-relative z-index wow tpfadeRight"
                data-wow-duration=".9s"
                data-wow-delay=".5s"
              >
                <div class="tp-payment__shape-9">
                  <img :src="sanitizeHtml(data.card_right_img_one)" alt="" />
                </div>
                <div class="tp-payment__shape-11">
                  <img :src="sanitizeHtml(data.card_right_img_two)" alt="" />
                </div>
                <div class="tp-payment__content">
                  <h3 class="tp-payment__title">
                    {{ data.card_right_title }}
                  </h3>
                  <p>{{ data.card_right_sub_title }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mb-30">
          <div
            class="tp-payment__item p-relative z-index wow tpfadeUp"
            data-wow-duration=".9s"
            data-wow-delay=".7s"
          >
            <div class="tp-payment__shape-1">
              <img :src="sanitizeHtml(data.card_bottom_img_one)" alt="" />
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="tp-payment__content tp-payment__content-space">
                  <h3 class="tp-payment__title" v-html="sanitizeHtml(data.card_bottom_title)"></h3>
                  <p v-html="sanitizeHtml(data.card_bottom_sub_title)"></p>
                  <a
                    :href="sanitizeHtml(data.card_bottom_btn_link ?? '#')"
                    v-html="sanitizeHtml(data.card_bottom_btn_text)"
                  ></a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="tp-payment__shape-2">
                  <img :src="sanitizeHtml(data.card_bottom_img_two)" alt="" />
                </div>
                <div class="tp-payment__shape-3 d-none d-sm-block">
                  <img :src="sanitizeHtml(data.card_bottom_img_three)" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
