<script setup>
import DefaultLayout from "@/Layouts/Default/DefaultLayout.vue";
import AboutSection from "@/Pages/Web/About/Partials/AboutSection.vue";
import BannerSection from "@/Pages/Web/About/Partials/BannerSection.vue";
import BrandSection from "@/Pages/Web/About/Partials/BrandSection.vue";
import CompanySection from "@/Pages/Web/About/Partials/CompanySection.vue";
import ImgSection from "@/Pages/Web/About/Partials/ImgSection.vue";
import JobArea from "@/Pages/Web/About/Partials/JobArea.vue";
import JourneySection from "@/Pages/Web/About/Partials/JourneySection.vue";
import TeamSection from "@/Pages/Web/About/Partials/TeamSection.vue";

defineOptions({ layout: DefaultLayout });
defineProps(["about", "jobs", "brands", "teams"]);
</script>

<template>
  <!-- tp-breadcrumb-area-start -->
  <BannerSection :data="about.header" />
  <!-- tp-breadcrumb-area-end -->

  <!-- tp-breadcrumb-header-area-start -->
  <ImgSection :data="about.header" />
  <!-- tp-breadcrumb-header-area-end -->

  <!--ab-brand-area-start -->
  <BrandSection :brands="brands" :data="about.partners" />
  <!--ab-brand-area-end -->

  <!--ab-company-area-start -->
  <CompanySection :data="about.company" />
  <!--ab-company-area-end -->

  <!-- tp-about-area-start -->
  <AboutSection :data="about.cta_s1" />
  <!-- tp-about-area-end -->

  <!-- tp-team-area-start -->
  <TeamSection :teams="teams" />
  <!-- tp-team-area-end -->

  <!-- tp-journey-area-start -->
  <JourneySection :data="about.timeline" />
  <!-- tp-journey-area-end -->

  <!-- tp-job-area-start -->
  <JobArea :jobs="jobs" :data="about.career_jobs" forPage="about" />
  <!-- tp-job-area-end -->

</template>
