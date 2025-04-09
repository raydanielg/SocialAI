<script setup>
import { usePage } from '@inertiajs/vue3'
const cta_s2 = usePage().props.primaryData?.cta_s2 ?? {}
</script>

<template>
  <div class="tp-sales-area tp-sales-space">
    <div class="container">
      <div class="row align-items-center">
        <div
          class="col-xl-6 col-lg-6 order-md-1 wow tpfadeLeft order-1"
          data-wow-duration=".9s"
          data-wow-delay=".5s"
        >
          <div class="tp-sales-section-box pb-20">
            <h3 class="tp-section-title-3 pb-15" v-html="sanitizeHtml(cta_s2.title)"></h3>
            <p class="tp-title-anim">
              {{ cta_s2.sub_title }}
            </p>
          </div>
          <div class="tp-sales-feature">
            <ul>
              <li class="yellow-1">
                <span
                  ><i class="far fa-check"></i>
                  <em>{{ cta_s2.list_items?.split(', ')[0] }}</em></span
                >
              </li>
              <li class="purple-2">
                <span
                  ><i class="far fa-check"></i>
                  <em>{{ cta_s2.list_items?.split(', ')[1] }}</em></span
                >
              </li>
              <li class="green-3">
                <span
                  ><i class="far fa-check"></i>
                  <em>{{ cta_s2.list_items?.split(', ')[2] }}</em></span
                >
              </li>
            </ul>
          </div>
        </div>
        <div
          class="col-xl-6 col-lg-6 order-0 order-md-2 wow tpfadeRight"
          data-wow-duration=".9s"
          data-wow-delay=".7s"
        >
          <div class="tp-sales-img-wrapper p-relative text-end">
            <div class="tp-sales-main-thumb">
              <img :src="sanitizeHtml(cta_s2.bg_img)" alt="bg-image" />
            </div>

            <div class="tp-sales-sub-img-2 d-none d-sm-block">
              <img :src="sanitizeHtml(cta_s2.bottom_bg_img)" alt="bg-image" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
