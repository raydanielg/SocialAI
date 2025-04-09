<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  },
  brands: {
    type: Array,
    default: []
  }
})
</script>

<template>
  <div class="ab-brand-area">
    <div class="container">
      <div class="ab-brand-border-bottom pb-90">
        <div class="row">
          <div class="col-12">
            <div class="ab-brand-section-box mb-50 text-center">
              <h4 class="ab-brand-title">{{ data.title }}</h4>
              <p>{{ data.sub_title }}</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div
              class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 justify-content-center"
            >
              <div
                v-for="brand in brands"
                :key="brand.id"
                class="col wow tpfadeUp"
                data-wow-duration=".9s"
                data-wow-delay=".2s"
              >
                <div class="ab-brand-item mb-25">
                  <img :src="sanitizeHtml(brand.preview)" alt="" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
