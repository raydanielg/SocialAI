<script setup>
import { ref } from "vue";

defineProps(["faqs"]);
const activeAccordion = ref(-1);
const setActive = (index) => {
  if (activeAccordion.value === index) return (activeAccordion.value = -1);
  activeAccordion.value = index;
};
</script>

<template>
  <div class="tp-faq-area pt-100 pb-60">
    <div class="container">
      <div class="row">
        <div
          class="col-xl-6 col-lg-6 wow tpfadeLeft"
          data-wow-duration=".9s"
          data-wow-delay=".3s"
        >
          <div class="tp-faq-left-wrapper p-relative">
            <div
              class="tp-faq-section-box tp-inner-font tp-inner-faq-box pb-20"
            >
              <h4 class="inner-section-subtitle">{{ trans("Support") }}</h4>
              <h3 class="tp-section-title">
                {{ trans("Frequently Asked Questions") }}
              </h3>
              <p>
                {{
                  trans(
                    " Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium.!"
                  )
                }}
              </p>
            </div>
            <div class="tp-faq-btn">
              <Link
                class="tp-btn-inner tp-btn-hover alt-color-black"
                href="/contact-us"
              >
                <span>{{ trans("Get in Touch") }}</span>
                <b></b>
            </Link>
            </div>
            <div class="tp-faq-img">
              <img src="/assets/img/faq/faq-1.png" alt="" />
            </div>
            <div class="tp-faq-border-shape d-none">
              <img src="/assets/img/faq/faq-border-shape.png" alt="" />
            </div>
          </div>
        </div>
        <div
          class="col-xl-6 col-lg-6 wow tpfadeRight"
          data-wow-duration=".9s"
          data-wow-delay=".5s"
        >
          <div class="tp-custom-accordion">
            <div class="accordion tp-inner-font" id="accordionExample">
              <div
                v-for="(faq, index) in faqs"
                :key="index"
                class="accordion-items"
                :class="{
                  'tp-faq-active': activeAccordion === index,
                }"
              >
                <h2 class="accordion-header" :id="`heading${index}`">
                  <button
                    @click="setActive(index)"
                    class="accordion-buttons collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="`#collapseTwo${index}`"
                    aria-expanded="false"
                    :aria-controls="`collapseTwo${index}`"
                  >
                    <div class="cw-90">{{ faq.title }}</div>
                    <span class="accordion-btn ms-2"></span>
                  </button>
                </h2>
                <div
                  :id="`collapseTwo${index}`"
                  class="accordion-collapse collapse"
                  :aria-labelledby="`heading${index}`"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    {{ faq.excerpt?.value }}
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
