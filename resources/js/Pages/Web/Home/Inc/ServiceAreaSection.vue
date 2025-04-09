<script setup>
import trans from '@/Composables/transComposable'

const props = defineProps({
  data: {
    type: Object,
    default: {
      title: '',
      subtitle: '',
      cards: [],
      bottom_list_items: []
    }
  }
})
</script>

<template>
  <div class="tp-service-2__area p-relative pt-70 pb-160">
    <div class="tp-service-2__shape">
      <img src="/assets/img/service/sv-bg-2-1.jpg" alt="" />
    </div>
    <div class="z-index-5 container">
      <div class="row align-items-center mb-50">
        <div class="col-xl-6 col-lg-6">
          <div class="tp-service-2__section-box">
            <h3 class="tp-section-title-lg pb-20" v-html="sanitizeHtml(data.title)"></h3>
            <p>{{ data.subtitle }}</p>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 wow tpfadeRight" data-wow-duration=".9s" data-wow-delay=".3s">
          <div
            class="tp-service-2__user-box p-relative d-flex justify-content-lg-start justify-content-lg-end align-items-center flex-wrap"
          >
            <div class="tp-service-2__user-shape">
              <svg
                width="470"
                height="18"
                viewBox="0 0 470 18"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M199.614 1.72387C177.533 2.31462 155.712 3.04101 134.432 3.83514C104.309 4.95854 74.1969 6.12068 44.2665 7.96073C34.8451 8.5418 25.2775 8.90979 15.915 9.63613C10.0378 10.0913 2.24477 10.7401 1.22204 10.8757C0.687102 10.9531 0.453729 11.0695 0.37832 11.1082C-0.151901 11.3794 -0.0551557 11.6407 0.244125 11.8441C0.364308 11.9313 0.668216 12.1444 1.51186 12.1735C57.9321 14.1588 115.625 10.285 172.113 9.87824C270.075 9.18096 371.005 11.9507 468.189 17.9938C469.037 18.0423 469.862 17.8001 469.98 17.4418C470.121 17.0931 469.508 16.7542 468.66 16.7057C371.312 10.6529 270.216 7.87347 172.066 8.58044C119.421 8.95813 65.7369 12.3575 13.0188 11.1953C14.2301 11.0985 15.4178 11.0016 16.5018 10.9144C25.8267 10.1881 35.3541 9.8298 44.7379 9.24873C74.6046 7.40868 104.655 6.24654 134.739 5.13282C172.066 3.73826 211.02 2.53737 250.28 1.97567C264.325 2.06283 278.322 2.15003 292.32 2.25656C322.602 2.48899 353.025 3.16691 383.236 4.07725C392.332 4.3581 401.428 4.64861 410.524 4.9004C413.541 4.98757 421.317 5.23932 422.401 5.21995C423.745 5.20058 424.004 4.73577 424.027 4.65829C424.098 4.48397 424.051 4.24185 423.391 4.03847C423.32 4.00942 422.896 3.91251 421.953 3.8544C367.023 0.426098 308.368 -0.145196 250.327 0.677985C189.104 0.319659 127.646 0.164636 66.5783 0C65.704 0 64.99 0.290577 64.9829 0.648903C64.9782 1.00723 65.6827 1.29782 66.557 1.3075C110.775 1.42371 155.217 1.53986 199.614 1.72387Z"
                  fill="url(#paint0_linear_552_4801)"
                />
                <defs>
                  <linearGradient
                    id="paint0_linear_552_4801"
                    x1="0"
                    y1="9"
                    x2="470"
                    y2="9"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop stop-color="#491EB8" stop-opacity="0" />
                    <stop offset="1" stop-color="#DA2A51" />
                  </linearGradient>
                </defs>
              </svg>
            </div>
            <div v-for="item in data.counter" class="tp-service-2__user" :key="item.title">
              <span v-html="sanitizeHtml(item.title)"></span>
              <p>{{ item.subtitle }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row gx-60">
        <div
          class="col-xl-3 col-lg-3 col-md-6 wow tpfadeUp mb-40"
          data-wow-duration=".9s"
          data-wow-delay=".6s"
          v-for="card in data.cards"
          :key="card.title"
        >
          <div class="tp-service-2__item-wrapper p-relative">
            <div class="tp-service-2__item d-flex justify-content-between flex-column">
              <div class="tp-service-2__icon">
                <img :src="sanitizeHtml(card.icon)" alt="" />
              </div>
              <div class="tp-service-2__text">
                <h4 class="tp-service-2__title-sm">
                  <a :href="sanitizeHtml(card.link)">{{ card.title }}</a>
                </h4>
                <a class="tp-service-2__link" :href="sanitizeHtml(card.link)"
                  >{{ trans('Explore') }}<i class="far fa-arrow-right"></i
                ></a>
              </div>
            </div>
            <div
              class="tp-service-2__bg-shape tp-service-2__color-2"
              :style="{ background: card.color }"
            ></div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xl-10 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".9s">
          <div class="tp-service-2__bottom-wrapper p-relative mt-30">
            <div class="tp-service-2__feature-item">
              <h4 class="tp-service-2__feature-title">
                {{ data.bottom_list_title }}
              </h4>
              <div class="tp-service-2__feature-box d-flex justify-content-between">
                <div class="tp-service-2__feature-list">
                  <ul>
                    <li v-for="item in data.bottom_list_items" :key="item.title">
                      {{ item.title }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
