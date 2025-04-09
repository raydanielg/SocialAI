<script setup>
import { ref } from "vue"
import { computed } from "vue"
import sharedComposable from "@/Composables/sharedComposable"
const props = defineProps({
  plans: [Object, Array],
  planSettings: [Object, Array],
})
const { formatCurrency, trim } = sharedComposable()
const activeTab = ref("monthly")
const filteredPlans = computed(() => {
  if (activeTab.value === "monthly") {
    return props.plans.filter((p) => p.days === 30)
  }
  if (activeTab.value === "yearly") {
    return props.plans.filter((p) => p.days === 365)
  }
  if (activeTab.value === "lifetime") {
    return props.plans.filter((p) => p.days > 365)
  }
})
</script>

<template>
  <!-- tp-price-area-start -->
  <div class="tp-price__area tp-price__pl-pr p-relative pt-110 pb-80">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-7 wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
          <div class="tp-price__section-box mb-35 text-center">
            <h2 class="tp-section-title">{{ planSettings?.overview }}</h2>
            <p>{{ trans('Choose a plan tailored to your needs') }}</p>
          </div>
        </div>
      </div>
      <div class="row wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".5s">
        <div class="col-12">
          <div class="tp-price__btn-box p-relative mb-50 d-flex justify-content-center">
            <div class="tp-price-offer-badge-wrap d-none d-sm-block">
              <div class="price-shape-line">
                <svg
                  width="80"
                  height="42"
                  viewBox="0 0 80 42"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M78.5938 8.78059C59.0829 45.2801 2.05127 -8.72021 27.0652 32.28C52.079 73.2801 48.5771 -41.2195 0.550438 18.7821"
                    stroke="#FF3C82"
                    stroke-dasharray="3 3"
                  />
                </svg>
              </div>
              <div class="price-offer-badge">
                <span
                  >{{ trans('SAVE') }} <br />
                  {{ planSettings?.percentage }} %</span
                >
              </div>
            </div>
            <nav>
              <div class="nav nav-tab tp-price__btn-bg" id="nav-tab" role="tablist">
                <button
                  @click="activeTab = 'monthly'"
                  class="nav-link active monthly"
                  id="nav-monthly-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#nav-monthly"
                  type="button"
                  role="tab"
                  aria-controls="nav-monthly"
                  aria-selected="true"
                >
                  {{ trans('Monthly') }}
                </button>
                <button
                  @click="activeTab = 'yearly'"
                  class="nav-link yearly"
                  id="nav-yearly-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#nav-yearly"
                  type="button"
                  role="tab"
                  aria-controls="nav-yearly"
                  aria-selected="false"
                >
                  {{ trans('Yearly') }}
                </button>
                <button
                  @click="activeTab = 'lifetime'"
                  class="nav-link lifetime"
                  id="nav-lifetime-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#nav-lifetime"
                  type="button"
                  role="tab"
                  aria-controls="nav-lifetime"
                  aria-selected="false"
                >
                  {{ trans('Lifetime') }}
                </button>
                <span class="test"></span>
              </div>
            </nav>
          </div>
        </div>
      </div>
      <div class="price-tab-content">
        <div class="tab-content" id="nav-tabContent">
          <div
            class="tab-pane fade show active"
            id="nav-home"
            role="tabpanel"
            aria-labelledby="nav-home-tab"
            tabindex="0"
          >
            <div class="row">
              <div
                v-for="(item, i) in filteredPlans"
                :key="i"
                class="col-xl-4 col-lg-4 col-md-6 mb-30"
              >
                <div :class="`tp-price__item p-relative ${i === 1 ? 'active' : ''}`">
                  <div class="tp-price__title-box">
                    <h4 class="tp-price__title-sm">{{ item.title }}</h4>
                    <p>{{ item.description }}</p>
                  </div>
                  <div class="tp-price__feature">
                    <ul>
                      <li v-for="(data, key) in item.data" :key="key">
                        <span>
                          <svg
                            width="16"
                            height="17"
                            viewBox="0 0 16 17"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              class="price-path-1"
                              d="M6.344 9.20708L1.81052 6.82365C1.46119 6.64408 1.05752 6.6604 0.731485 6.87263C0.397684 7.09301 0.203613 7.46032 0.203613 7.86844V12.3659C0.203613 13.1414 0.615042 13.8433 1.27488 14.1943L5.8006 16.5778C5.95586 16.6594 6.12664 16.7002 6.29742 16.7002C6.49925 16.7002 6.70109 16.6431 6.87963 16.5288C7.21343 16.3166 7.4075 15.9411 7.4075 15.533V11.0355C7.41527 10.2519 7.00384 9.5499 6.344 9.20708Z"
                              fill="currentcolor"
                            />
                            <path
                              class="price-path-2"
                              d="M15.3846 6.87587C15.0508 6.66372 14.6471 6.63924 14.3056 6.82691L9.77978 9.20956C9.11993 9.56043 8.7085 10.254 8.7085 11.0373V15.5334C8.7085 15.9413 8.90257 16.3167 9.23637 16.5288C9.41492 16.6431 9.61676 16.7002 9.81859 16.7002C9.98938 16.7002 10.1602 16.6594 10.3154 16.5778L14.8412 14.1952C15.5011 13.8443 15.9125 13.1507 15.9125 12.3674V7.87136C15.9125 7.46337 15.7184 7.09618 15.3846 6.87587Z"
                              fill="currentcolor"
                            />
                            <path
                              class="price-path-3"
                              d="M13.9152 2.96146L8.86226 0.219067C8.33036 -0.0730223 7.68564 -0.0730223 7.15375 0.219067L2.10076 2.96146C1.73005 3.1643 1.50439 3.55375 1.50439 4C1.50439 4.43813 1.73005 4.8357 2.10076 5.03854L7.15375 7.78093C7.4197 7.92698 7.71788 8 8.008 8C8.29813 8 8.59631 7.92698 8.86226 7.78093L13.9152 5.03854C14.286 4.8357 14.5116 4.44625 14.5116 4C14.5116 3.55375 14.286 3.1643 13.9152 2.96146Z"
                              fill="currentcolor"
                            />
                          </svg>
                        </span>
                        {{ data.overview }} :
                        {{
                          data.value == "-1"
                            ? "(Unlimited)"
                            : data.value == "true" || data.value == "false"
                            ? ""
                            : data.value
                        }}
                      </li>
                    </ul>
                  </div>
                  <div class="tp-price__btn tp-btn-price">
                    <span>{{ trans('Price:') }} {{ item.price_format }}</span>
                    <a :href="route('register', { id: item.id })">
                      <i class="fal fa-arrow-right me-1"></i>
                      {{ trans('Purchase Now') }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="nav-profile"
            role="tabpanel"
            aria-labelledby="nav-profile-tab"
            tabindex="0"
          >
            <div class="row">
              <div
                v-for="(item, i) in filteredPlans"
                :key="i"
                class="col-xl-4 col-lg-4 col-md-6 mb-30"
              >
                <div
                  :class="`tp-price__item p-relative ${
                    item.is_featured === 1 ? 'active' : ''
                  }`"
                >
                  <div class="tp-price__title-box">
                    <h4 class="tp-price__title-sm">{{ item.title }}</h4>
                    <p>{{ item.description }}</p>
                  </div>
                  <div class="tp-price__feature">
                    <ul>
                      <li v-for="(data, key) in item.data" :key="key">
                        <span>
                          <svg
                            width="16"
                            height="17"
                            viewBox="0 0 16 17"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              class="price-path-1"
                              d="M6.344 9.20708L1.81052 6.82365C1.46119 6.64408 1.05752 6.6604 0.731485 6.87263C0.397684 7.09301 0.203613 7.46032 0.203613 7.86844V12.3659C0.203613 13.1414 0.615042 13.8433 1.27488 14.1943L5.8006 16.5778C5.95586 16.6594 6.12664 16.7002 6.29742 16.7002C6.49925 16.7002 6.70109 16.6431 6.87963 16.5288C7.21343 16.3166 7.4075 15.9411 7.4075 15.533V11.0355C7.41527 10.2519 7.00384 9.5499 6.344 9.20708Z"
                              fill="currentcolor"
                            />
                            <path
                              class="price-path-2"
                              d="M15.3846 6.87587C15.0508 6.66372 14.6471 6.63924 14.3056 6.82691L9.77978 9.20956C9.11993 9.56043 8.7085 10.254 8.7085 11.0373V15.5334C8.7085 15.9413 8.90257 16.3167 9.23637 16.5288C9.41492 16.6431 9.61676 16.7002 9.81859 16.7002C9.98938 16.7002 10.1602 16.6594 10.3154 16.5778L14.8412 14.1952C15.5011 13.8443 15.9125 13.1507 15.9125 12.3674V7.87136C15.9125 7.46337 15.7184 7.09618 15.3846 6.87587Z"
                              fill="currentcolor"
                            />
                            <path
                              class="price-path-3"
                              d="M13.9152 2.96146L8.86226 0.219067C8.33036 -0.0730223 7.68564 -0.0730223 7.15375 0.219067L2.10076 2.96146C1.73005 3.1643 1.50439 3.55375 1.50439 4C1.50439 4.43813 1.73005 4.8357 2.10076 5.03854L7.15375 7.78093C7.4197 7.92698 7.71788 8 8.008 8C8.29813 8 8.59631 7.92698 8.86226 7.78093L13.9152 5.03854C14.286 4.8357 14.5116 4.44625 14.5116 4C14.5116 3.55375 14.286 3.1643 13.9152 2.96146Z"
                              fill="currentcolor"
                            />
                          </svg>
                        </span>
                        {{ data.overview }} :
                        {{
                          data.value == "-1"
                            ? "(Unlimited)"
                            : data.value == "true" || data.value == "false"
                            ? ""
                            : data.value
                        }}
                      </li>
                    </ul>
                  </div>
                  <div class="tp-price__btn tp-btn-price">
                    <span>{{ trans('Price:') }} {{ item.price_format }}</span>
                    <a :href="route('register', { id: item.id })">
                      <i class="fal fa-arrow-right me-1"></i>
                      {{ trans('Purchase Now') }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-price-area-end -->
</template>
