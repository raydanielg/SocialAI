<script setup>
defineProps(['data', 'services', 'featuredService'])
</script>

<template>
  <div class="tp-service-area pb-90 z-index">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div
            class="tp-service-section-wrapper d-flex justify-content-between align-items-end mb-60"
          >
            <h3
              class="tp-section-title-3 wow tpfadeLeft"
              data-wow-duration=".9s"
              data-wow-delay=".3s"
              v-html="sanitizeHtml(data.title)"
            ></h3>
            <Link
              class="tp-btn-blue-lg tp-btn-hover alt-color-black wow tpfadeRight mb-10"
              data-wow-duration=".9s"
              data-wow-delay=".5s"
              :href="sanitizeHtml(data.btn_link)"
            >
              <span>{{ data.btn_text }}</span>
              <b></b>
            </Link>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-8 wow tpfadeLeft" data-wow-duration=".9s" data-wow-delay=".5s">
          <div
            class="tp-service-3-item mb-30 p-relative z-index"
            :style="`background-image: url(${sanitizeHtml(data.bg_img)})`"
          >
            <div class="tp-service-3-icon">
              <img :src="featuredService.icon" :alt="featuredService.title" />
            </div>
            <div class="tp-service-3-content">
              <span>{{ featuredService.category?.title }}</span>
              <h4 class="tp-service-3-title-sm">
                <Link :href="`/services/${sanitizeHtml(featuredService.slug)}`">{{ featuredService.title }}</Link>
              </h4>
            </div>
            <div class="tp-service-3-btn">
              <Link class="tp-btn-white-solid" :href="`/services/${sanitizeHtml(featuredService.slug)}`"
                >{{ trans('Learn More') }} <i class="far fa-arrow-right"></i
              ></Link>
            </div>
            <div class="tp-service-3-shape">
              <img :src="sanitizeHtml(data.bg_bottom_right_image)" alt="" />
            </div>
          </div>
        </div>

        <div
          v-for="service in services"
          :key="service.id"
          class="col-xl-4 col-lg-6 col-md-6 wow tpfadeRight"
          data-wow-duration=".9s"
          data-wow-delay=".6s"
          style="
            visibility: visible;
            animation-duration: 0.9s;
            animation-delay: 0.6s;
            animation-name: tpfadeRight;
          "
        >
          <div class="tp-service-sm-item mb-30 d-flex flex-column justify-content-between">
            <div class="tp-service-sm-icon">
              <img :src="service.icon" :alt="service.title" />
            </div>
            <div class="tp-service-sm-content">
              <span>{{ service.category?.title }}</span>
              <h3 class="tp-service-sm-title">
                <Link :href="`/services/${sanitizeHtml(service.slug)}`">{{ service.title }}</Link>
              </h3>
              <div class="tp-service-sm-link">
                <Link :href="`/services/${sanitizeHtml(service.slug)}`">
                  {{ trans('Learn more') }} <i class="far fa-arrow-right"></i>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
