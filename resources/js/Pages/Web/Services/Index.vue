<script setup>
import FaqArea from "@/Components/FaqArea.vue";
import TestimonialArea from "@/Components/Web/TestimonialArea.vue";
import DefaultLayout from "@/Layouts/Default/DefaultLayout.vue";
import CardSection from "@/Pages/Web/Home/Partials/CardSection.vue";
import SalesSection from "@/Pages/Web/Home/Partials/SalesSection.vue";
import ServiceSection from "@/Pages/Web/Home/Partials/ServiceSection.vue";

defineOptions({ layout: DefaultLayout })
defineProps([
  "services",
  "featuredService",
  "faqs",
  "testimonials",
  "service_page",
  "home_page",
])
</script>

<template>
  <!-- tp-breadcrumb-area-start -->
  <div class="about-banner-area p-relative">
    <div class="about-shape-1 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="about-shape-2 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="about-banner p-relative z-index fix">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="about-banner-content">
              <h4
                class="about-banner-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
              >
                <span>{{ trans("Our Top") }}</span> <br />
                <span>{{ trans("Services") }}</span>
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-area-end -->

  <!-- tp-breadcrumb-header-area-start -->
  <div class="about-img-area mb-100 z-index-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div
            class="about-img about-img-height p-relative"
            :style="`background-image: url(${sanitizeHtml(service_page.hero?.banner_img)});`"
          >
            <div class="about-img-content">
              <h4 class="about-img-title" data-parallax='{"y": 1000, "smoothness": 10}'>
                <span>{{ service_page.hero.title1 }}</span> <br />
                <span>{{ service_page.hero.title2 }}</span>
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-header-area-end -->

  <!-- tp-service-area-strat -->
  <ServiceSection
    :services="services.data"
    :featuredService="featuredService ?? false"
    :data="service_page.service"
  />
  <!-- tp-service-area-end -->

  <!-- tp-card-area-start -->
  <CardSection />
  <!-- tp-card-area-end -->

  <!-- tp-sales-area-start -->
  <SalesSection />

  <!-- tp-testimonial-area-start -->
  <TestimonialArea
    :testimonials="testimonials"
    with-bg="1"
    :data="home_page.testimonial"
  />
  <!-- tp-testimonial-area-end -->

  <!-- tp-faq-area-start -->
  <FaqArea :faqs="faqs" :data="home_page.faq" />
  <!-- tp-faq-area-end -->
</template>
