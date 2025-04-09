<script setup>
import DefaultLayout from "@/Layouts/Default/DefaultLayout.vue"

import SliderSection from "@/Pages/Web/Home/Partials/SliderSection.vue"
import CounterSection from "@/Pages/Web/Home/Partials/CounterSection.vue"
import ServiceSection from "@/Pages/Web/Home/Partials/ServiceSection.vue"
import RatedSection from "@/Pages/Web/Home/Partials/RatedSection.vue"
import CardSection from "@/Pages/Web/Home/Partials/CardSection.vue"
import SalesSection from "@/Pages/Web/Home/Partials/SalesSection.vue"
import TestimonialSection from "@/Pages/Web/Home/Partials/TestimonialSection.vue"
import IntegrationSection from "@/Pages/Web/Home/Partials/IntegrationSection.vue"
import BlogSection from "@/Pages/Web/Home/Partials/BlogSection.vue"
defineOptions({ layout: DefaultLayout })
defineProps([
  "home",
  "services",
  "featuredService",
  "blogs",
  "testimonials",
  "integrations",
])
</script>
<template>
  <!-- tp-slider-area-start -->
  <SliderSection :hero="home.hero" />
  <!-- tp-slider-area-end -->

  <!-- tp-counter-area-start -->
  <CounterSection :counter="home.counter" />
  <!-- tp-counter-area-end -->

  <!-- tp-service-area-start -->
  <ServiceSection
    :data="home.service ?? {}"
    :services="services"
    :featuredService="featuredService"
  />
  <!-- tp-service-area-end -->

  <!-- tp-rated-area-start -->
  <RatedSection :rated="home.rated" />
  <!-- tp-rated-area-end -->

  <!-- tp-card-area-start -->
  <CardSection />
  <!-- tp-card-area-end -->

  <!-- tp-sales-area-start -->
  <SalesSection />
  <!-- tp-sales-area-end -->

  <!-- tp-testimonial-area-start -->
  <TestimonialSection :testimonials="testimonials" testimonialData="home.testimonial" />
  <!-- tp-testimonial-area-end -->

  <!-- tp-integration-area-start -->
  <IntegrationSection :data="home.integration ?? {}" :integrations_featured="integrations" />
  <!-- tp-integration-area-end -->

  <!-- tp-blog-area-start -->
  <BlogSection :blogs="blogs" />
  <!-- tp-blog-area-end -->
</template>
