<script setup>
defineProps({
  data: {
    type: Object,
    default: {}
  },
  teams: {
    type: Array,
    default: []
  }
})
</script>
<template>
  <div class="tp-team-area grey-bg pt-120 pb-95">
    <div class="container">
      <div class="tp-team-section-wrapper tp-team-inner-section mb-70">
        <div class="row align-items-end">
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="tp-team-section-box text-sm-start text-center">
              <h5 class="inner-section-subtitle pb-10">{{ trans('Our Team') }}</h5>
              <h3 class="tp-section-title mb-0 text-black">{{ trans('Meet Our Expert Team') }}</h3>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="tp-team-top-content text-md-end text-center">
              <Link class="tp-btn-inner tp-btn-hover alt-color-orange" href="/team">
                <span>{{ trans('View All') }}</span>
                <b></b>
              </Link>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div
          v-for="team in teams"
          :key="team.id"
          class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-50 tp-team-border-right tp-border-after-1 team-inner-border-right"
        >
          <div class="tp-team-item tp-team-inner-title-color z-index text-center">
            <div class="tp-team-img">
              <img :src="sanitizeHtml(team.preview?.value)" alt="" />
            </div>
            <div class="tp-team-content">
              <h4 class="tp-team-title-sm">
                <a href="#">{{ team.title }}</a>
              </h4>
              <span>{{ team.slug }}</span>
            </div>
            <div class="tp-team-social">
              <a
                class="icon-color-1"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.facebook)"
              >
                <i class="fab fa-facebook-f"></i>
                <span></span>
              </a>
              <a
                class="icon-color-2"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.instagram)"
              >
                <i class="fab fa-instagram"></i>
                <span></span>
              </a>
              <a
                class="icon-color-3"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.twitter)"
              >
                <i class="fab fa-twitter"></i>
                <span></span>
              </a>
              <a
                class="icon-color-4"
                :href="sanitizeHtml(JSON.parse(team.excerpt?.value)?.linkedin)"
              >
                <i class="fab fa-linkedin-in"></i>
                <span></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
