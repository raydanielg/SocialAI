<script setup>
import { ref } from 'vue'

defineProps({
  data: {
    type: Object,
    default: {}
  },
  faqs: {
    type: Array,
    default: []
  }
})
const activeAccordion = ref(-1)
const defaultAccordion = ref(1)
const setActive = (index) => {
  if (activeAccordion.value === index) return (activeAccordion.value = -1)
  activeAccordion.value = index
}
</script>

<template>
  <div class="tp-faq-area pt-100 pb-90 fix">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6">
          <div class="tp-faq-left-wrapper p-relative">
            <div class="tp-faq-section-box pb-20">
              <h4 class="tp-section-subtitle-2">{{ data.top_title }}</h4>
              <h3 class="tp-section-title-lg" v-html="sanitizeHtml(data.title)"></h3>
              <p v-html="sanitizeHtml(data.sub_title)"></p>
            </div>
            <div class="tp-faq-btn">
              <Link class="tp-btn-green" :href="sanitizeHtml(data.btn_link ?? '#')">
                {{ data.btn_text }}</Link
              >
            </div>
            <div class="tp-faq-img" data-parallax='{"x": -50, "smoothness": 30}'>
              <img :src="sanitizeHtml(data.img_1)" alt="" />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="tp-custom-accordion">
            <div class="accordion" id="accordionExample">
              <div
                v-for="(faq, index) in faqs"
                :key="index"
                class="accordion-items"
                :class="{
                  'tp-faq-active':
                    activeAccordion === index ||
                    (defaultAccordion === index && activeAccordion === -1)
                }"
              >
                <h2 class="accordion-header" :id="'heading' + index">
                  <button
                    @click="setActive(index)"
                    class="accordion-buttons pe-4"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="'#collapse' + index"
                    aria-expanded="true"
                    :aria-controls="'collapse' + index"
                  >
                    {{ faq.title }}
                    <span class="accordion-btn"></span>
                  </button>
                </h2>
                <div
                  :id="'collapse' + index"
                  class="accordion-collapse collapse"
                  :class="{ show: defaultAccordion === index && activeAccordion === -1 }"
                  :aria-labelledby="'heading' + index"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    {{ faq.excerpt?.value ?? '' }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
