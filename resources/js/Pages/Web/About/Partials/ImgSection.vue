<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  }
})
</script>

<template>
  <div class="about-img-area mb-100 z-index-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div
            class="about-img about-img-height p-relative"
            :style="{ backgroundImage: `url(${sanitizeHtml(data.image)})` }"
          >
            <div class="about-img-content">
              <h4
                class="about-img-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="sanitizeHtml(data.title)"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
