<script setup>
import { usePage } from '@inertiajs/vue3'
const cta_s1 = usePage().props.primaryData?.cta_s1 ?? { cta_s1: {} }
</script>

<template>
  <div class="tp-card-area tp-card-space pb-125 pt-140">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
          <div class="tp-card-thumb-wrapper p-relative">
            <div class="tp-card-main-img">
              <img :src="sanitizeHtml(cta_s1.bg_img) ?? '/assets/img/card/card-bg.png'" alt="" />
            </div>
            <div class="tp-card-img-1">
              <img
                :src="sanitizeHtml(cta_s1.bg_top_left_image) ?? '/assets/img/card/card-shape-1.png'"
                alt=""
              />
            </div>
            <div
              class="tp-card-img-3 d-none d-sm-block"
              data-parallax='{"x": 50, "smoothness": 30}'
            >
              <img
                :src="sanitizeHtml(cta_s1.bg_top_right_image) ?? '/assets/img/card/card-img-2.png'"
                alt=""
              />
            </div>
            <div
              class="tp-card-img-4 d-none d-sm-block"
              data-parallax='{"x": -50, "smoothness": 30}'
            >
              <img
                :src="sanitizeHtml(cta_s1.bg_top_right_image2) ?? '/assets/img/card/card-img-3.png'"
                alt=""
              />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".7s">
          <div class="tp-card-title-box">
            <h3 class="tp-section-title-3 pb-15" v-html="sanitizeHtml(cta_s1.title)"></h3>
            <p class="">
              {{ cta_s1.sub_title }}
            </p>
            <Link
              class="tp-btn-blue-lg tp-btn-hover alt-color-black"
              :href="sanitizeHtml(cta_s1.btn_link)"
            >
              <span>{{ cta_s1.btn_text }}</span>
              <b></b>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
