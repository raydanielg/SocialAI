<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>

<template>
  <div
    class="tp-hero-2__area tp-hero-2__ptb tp-hero-2__plr z-index fix p-relative"
    :style="`background-image: url(${sanitizeHtml(data.bg_image)})`"
  >
    <div class="scroll-bg d-none d-sm-block">
      <img :src="sanitizeHtml(data.scroll_down_img)" alt="" />
    </div>
    <div class="tp-hero-2__mouse-scroll smooth d-none d-sm-block">
      <a class="mouse-scroll-btn" href="#payment-method"></a>
      <span>{{ data.scroll_down_text }}</span>
    </div>
    <div class="tp-hero-2__shape-img-1 d-none d-sm-block">
      <svg
        width="238"
        height="159"
        viewBox="0 0 238 159"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          class="line-2"
          d="M234.344 52.0221C223.737 68.476 166.957 94.3438 103.492 41.3862C75.8453 16.8451 105.128 -10.4919 114.849 24.3323C124.571 59.1564 92.7914 100.54 68.4537 105.873C44.1161 111.206 27.3149 102.11 30.0997 91.4562C34.0369 76.394 74.0714 111.53 2.64231 134.089"
          stroke="white"
          stroke-width="2"
        />
        <path
          class="line-2"
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M2.0625 133.958C2.41561 133.237 3.42407 131.16 3.56794 130.842C3.9652 129.948 4.03834 129.444 4.05489 128.923C4.06249 128.505 4.01353 128.07 4.12522 127.291C4.19178 126.861 3.87842 126.464 3.44849 126.405C3.01856 126.345 2.62947 126.648 2.56291 127.077C2.47204 127.784 2.47586 128.238 2.48453 128.637C2.48792 129.095 2.47134 129.451 2.12998 130.203C1.96731 130.57 0.83986 132.515 0.507014 133.501C0.331505 134.015 0.368942 134.416 0.454587 134.597C0.576866 134.857 0.815639 135.113 1.20469 135.308C1.70511 135.556 2.55838 135.75 3.5093 135.988C4.40364 136.21 5.40968 136.481 6.2686 136.942C6.98849 137.334 7.59496 137.863 7.84287 138.677C7.96607 139.092 8.3949 139.33 8.81178 139.207C9.22866 139.084 9.47003 138.645 9.34683 138.23C8.99025 137 8.10724 136.153 7.01332 135.56C6.04391 135.035 4.91164 134.714 3.88939 134.463C3.27915 134.309 2.71001 134.182 2.27274 134.041C2.20216 134.019 2.13233 133.988 2.0625 133.958Z"
          fill="none"
        />
      </svg>
    </div>
    <div class="container-fluid g-0">
      <div class="row g-0 align-items-end">
        <div class="col-xl-6 col-lg-6">
          <div class="tp-hero-2__title-box">
            <h3 class="tp-hero-2__title tp-char-animation" v-html="sanitizeHtml(data.title)"></h3>
          </div>
          <div class="tp-hero-2__btn">
            <a
              class="tp-btn-green wow tpfadeUp"
              data-wow-duration=".9s"
              data-wow-delay=".5s"
              :href="sanitizeHtml(data.btn_link)"
              v-html="sanitizeHtml(data.btn_text)"
            ></a>
          </div>
          <div class="tp-hero-2__user p-relative">
            <h4 class="tp-char-animation-2" v-html="sanitizeHtml(data.sub_title)"></h4>
            <div class="tp-hero-2__user-img">
              <img :src="sanitizeHtml(data.clients)" alt="" />
            </div>
            <div class="tp-hero-2__shape-1">
              <svg
                width="101"
                height="15"
                viewBox="0 0 101 15"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M0.336934 5.24122C16.3707 0.583948 58.7418 -4.19312 99.9564 13.9568"
                  stroke="white"
                  stroke-width="1.5"
                />
              </svg>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="tp-hero-2__right p-relative text-end">
            <div
              class="tp-hero-2__main-img wow tpfadeRight"
              data-wow-duration=".9s"
              data-wow-delay=".5s"
            >
              <img :src="sanitizeHtml(data.right_image)" alt="" />
            </div>
            <div
              class="tp-hero-2__sub-img-1 d-none d-sm-block"
              data-parallax='{"x": 100, "smoothness": 30}'
            >
              <img :src="sanitizeHtml(data.right_image_overlay)" alt="" />
            </div>
            <div
              class="tp-hero-2__sub-img-2 d-none d-sm-block"
              data-parallax='{"x": -100, "smoothness": 10}'
            >
              <img :src="sanitizeHtml(data.right_image_overlay2)" alt="" />
            </div>
            <div
              class="tp-hero-2__sub-img-3 d-none d-sm-block"
              data-parallax='{"y": -80, "smoothness": 30}'
            >
              <img :src="sanitizeHtml(data.bottom_image_overlay)" alt="" />
            </div>
            <div class="tp-hero-2__sub-img-4">
              <img :src="sanitizeHtml(data.top_image_overlay)" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
