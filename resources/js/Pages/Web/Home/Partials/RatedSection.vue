<script setup>
const props = defineProps(['rated'])

const data = props.rated ?? {}
</script>
<template>
  <div class="tp-rated-area fix p-relative">
    <div class="tp-rated-bg pt-120" :style="`background-image: url(${sanitizeHtml(data.bg_img)});`">
      <div class="tp-rated-shape-1 d-none d-lg-block">
        <img :src="sanitizeHtml(data.bg_top_right_image)" alt="" />
      </div>
      <div class="tp-rated-shape-2 d-none d-sm-block">
        <img :src="sanitizeHtml(data.bg_top_left_image)" alt="" />
      </div>
      <div class="z-index-6 container">
        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="tp-rated-title-box mb-60 text-center">
              <div class="tp-rated-icon tp-title-anim">
                <span>
                  <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6007 2.16169L20.2414 7.48279C20.6015 8.20839 21.5617 8.93399 22.3619 9.05493L27.1432 9.86114C30.204 10.3852 30.9242 12.6023 28.7236 14.8194L25.0027 18.5684C24.3825 19.1932 24.0224 20.4227 24.2224 21.3096L25.2828 25.9655C26.123 29.6339 24.1825 31.0649 20.9616 29.1501L16.4804 26.4694C15.6602 25.9857 14.3398 25.9857 13.5196 26.4694L9.0384 29.1501C5.81755 31.0649 3.87702 29.6339 4.71725 25.9655L5.77759 21.3096C5.97764 20.4429 5.61751 19.2134 4.99735 18.5684L1.27639 14.8194C-0.92419 12.6023 -0.204043 10.365 2.85677 9.86114L7.63806 9.05493C8.43828 8.91384 9.39853 8.20839 9.75862 7.48279L12.3993 2.16169C13.8197 -0.720565 16.1803 -0.720565 17.6007 2.16169Z"
                      fill="url(#tp-1)"
                      fill-opacity="0.3"
                    />
                    <defs>
                      <linearGradient
                        id="tp-1"
                        x1="15"
                        y1="0"
                        x2="15"
                        y2="30"
                        gradientUnits="userSpaceOnUse"
                      >
                        <stop offset="0" stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </span>
                <span>
                  <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6007 2.16169L20.2414 7.48279C20.6015 8.20839 21.5617 8.93399 22.3619 9.05493L27.1432 9.86114C30.204 10.3852 30.9242 12.6023 28.7236 14.8194L25.0027 18.5684C24.3825 19.1932 24.0224 20.4227 24.2224 21.3096L25.2828 25.9655C26.123 29.6339 24.1825 31.0649 20.9616 29.1501L16.4804 26.4694C15.6602 25.9857 14.3398 25.9857 13.5196 26.4694L9.0384 29.1501C5.81755 31.0649 3.87702 29.6339 4.71725 25.9655L5.77759 21.3096C5.97764 20.4429 5.61751 19.2134 4.99735 18.5684L1.27639 14.8194C-0.92419 12.6023 -0.204043 10.365 2.85677 9.86114L7.63806 9.05493C8.43828 8.91384 9.39853 8.20839 9.75862 7.48279L12.3993 2.16169C13.8197 -0.720565 16.1803 -0.720565 17.6007 2.16169Z"
                      fill="url(#tp-2)"
                      fill-opacity="0.3"
                    />
                    <defs>
                      <linearGradient
                        id="tp-2"
                        x1="15"
                        y1="0"
                        x2="15"
                        y2="30"
                        gradientUnits="userSpaceOnUse"
                      >
                        <stop offset="0" stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </span>
                <span>
                  <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6007 2.16169L20.2414 7.48279C20.6015 8.20839 21.5617 8.93399 22.3619 9.05493L27.1432 9.86114C30.204 10.3852 30.9242 12.6023 28.7236 14.8194L25.0027 18.5684C24.3825 19.1932 24.0224 20.4227 24.2224 21.3096L25.2828 25.9655C26.123 29.6339 24.1825 31.0649 20.9616 29.1501L16.4804 26.4694C15.6602 25.9857 14.3398 25.9857 13.5196 26.4694L9.0384 29.1501C5.81755 31.0649 3.87702 29.6339 4.71725 25.9655L5.77759 21.3096C5.97764 20.4429 5.61751 19.2134 4.99735 18.5684L1.27639 14.8194C-0.92419 12.6023 -0.204043 10.365 2.85677 9.86114L7.63806 9.05493C8.43828 8.91384 9.39853 8.20839 9.75862 7.48279L12.3993 2.16169C13.8197 -0.720565 16.1803 -0.720565 17.6007 2.16169Z"
                      fill="url(#tp-3)"
                      fill-opacity="0.3"
                    />
                    <defs>
                      <linearGradient
                        id="tp-3"
                        x1="15"
                        y1="0"
                        x2="15"
                        y2="30"
                        gradientUnits="userSpaceOnUse"
                      >
                        <stop offset="0" stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </span>
                <span>
                  <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6007 2.16169L20.2414 7.48279C20.6015 8.20839 21.5617 8.93399 22.3619 9.05493L27.1432 9.86114C30.204 10.3852 30.9242 12.6023 28.7236 14.8194L25.0027 18.5684C24.3825 19.1932 24.0224 20.4227 24.2224 21.3096L25.2828 25.9655C26.123 29.6339 24.1825 31.0649 20.9616 29.1501L16.4804 26.4694C15.6602 25.9857 14.3398 25.9857 13.5196 26.4694L9.0384 29.1501C5.81755 31.0649 3.87702 29.6339 4.71725 25.9655L5.77759 21.3096C5.97764 20.4429 5.61751 19.2134 4.99735 18.5684L1.27639 14.8194C-0.92419 12.6023 -0.204043 10.365 2.85677 9.86114L7.63806 9.05493C8.43828 8.91384 9.39853 8.20839 9.75862 7.48279L12.3993 2.16169C13.8197 -0.720565 16.1803 -0.720565 17.6007 2.16169Z"
                      fill="url(#tp-4)"
                      fill-opacity="0.3"
                    />
                    <defs>
                      <linearGradient
                        id="tp-4"
                        x1="15"
                        y1="0"
                        x2="15"
                        y2="30"
                        gradientUnits="userSpaceOnUse"
                      >
                        <stop offset="0" stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </span>
                <span>
                  <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.6007 2.16169L20.2414 7.48279C20.6015 8.20839 21.5617 8.93399 22.3619 9.05493L27.1432 9.86114C30.204 10.3852 30.9242 12.6023 28.7236 14.8194L25.0027 18.5684C24.3825 19.1932 24.0224 20.4227 24.2224 21.3096L25.2828 25.9655C26.123 29.6339 24.1825 31.0649 20.9616 29.1501L16.4804 26.4694C15.6602 25.9857 14.3398 25.9857 13.5196 26.4694L9.0384 29.1501C5.81755 31.0649 3.87702 29.6339 4.71725 25.9655L5.77759 21.3096C5.97764 20.4429 5.61751 19.2134 4.99735 18.5684L1.27639 14.8194C-0.92419 12.6023 -0.204043 10.365 2.85677 9.86114L7.63806 9.05493C8.43828 8.91384 9.39853 8.20839 9.75862 7.48279L12.3993 2.16169C13.8197 -0.720565 16.1803 -0.720565 17.6007 2.16169Z"
                      fill="url(#tp-5)"
                      fill-opacity="0.3"
                    />
                    <defs>
                      <linearGradient
                        id="tp-5"
                        x1="15"
                        y1="0"
                        x2="15"
                        y2="30"
                        gradientUnits="userSpaceOnUse"
                      >
                        <stop offset="0" stop-color="white" />
                        <stop offset="1" stop-color="white" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                  </svg>
                </span>
              </div>
              <h5
                class="tp-section-title-3 pb-40 text-white"
                v-html="sanitizeHtml(rated.title)"
              ></h5>
              <a
                class="tp-btn-blue-lg tp-btn-hover alt-color-white"
                :href="sanitizeHtml(rated.btn_link)"
              >
                <span class="text-color-black">{{ rated.btn_text }}</span>
                <b></b>
              </a>
            </div>
          </div>
        </div>
        <div class="author-rated-wrapper">
          <div class="row">
            <div
              v-for="(review, index) in rated.reviews"
              :key="index"
              class="col-xl-4 col-lg-4 col-md-4"
            >
              <div class="author-rated text-center">
                <div class="author-rated-icon">
                  <span v-for="i in parseInt(review.ratting)" :key="i">
                    <i class="fas fa-star"></i>
                  </span>
                  <span v-for="i in 5 - parseInt(review.ratting)" :key="i">
                    <i class="far fa-star"></i>
                  </span>
                </div>
                <p>"{{ review.comment }}"</p>
                <div class="author-rated-logo">
                  <img :src="review.image" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="author-rated-big-img" data-parallax='{"y": 100, "smoothness": 30}'>
          <img :src="rated.bg_bottom_center_image" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>
