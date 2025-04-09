<script setup>
import DefaultLayout from "@/Layouts/Default/DefaultLayout.vue";
import ServiceSection from "@/Pages/Web/Home/Partials/ServiceSection.vue";

defineOptions({ layout: DefaultLayout })
defineProps(["services", "service_page", "featuredService"])

const bannerStyle = {
  backgroundColor: "#600EE4",
  "margin-bottom": "60px",
}
</script>

<template>
  <!-- tp-breadcrumb-area-start -->
  <div class="about-banner-area p-relative">
    <div class="p-relative z-index fix" :style="bannerStyle">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="about-banner-content">
              <h4 class="about-banner-title pb-105" data-parallax='{"y": 1000, "smoothness": 10}'>
                <span>{{
                  services.data?.[0]?.category?.title ?? "Service Category"
                  }}</span>
                <br />
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-area-end -->

  <!-- tp-service-area-strat -->
  <ServiceSection :services="services" :data="service_page.service" :hideTitle="true"
    :featuredService="featuredService" />
  <!-- tp-service-area-end -->
</template>
