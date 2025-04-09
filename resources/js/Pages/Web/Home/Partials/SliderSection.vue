<script setup>
const { hero } = defineProps(['hero'])
import { useCharAnimation } from '@/Composables/useCharAnimation'
import { gsap } from 'gsap'
import { ref } from 'vue'
import { onMounted } from 'vue'

const hero_text_anim = ref(null)
const heroTextAnimChildren = ref([])

const animateHeroText = () => {
  if (hero_text_anim.value) {
    const elements = Array.from(document.querySelectorAll('.child-1'))
    heroTextAnimChildren.value = elements
    if (heroTextAnimChildren.value.length > 0) {
      const tl = gsap.timeline({ default: { ease: 'SlowMo.easeOut' } })
      tl.to(heroTextAnimChildren.value, {
        y: '0px',
        duration: 1,
        opacity: 1,
        stagger: 0.3,
        delay: 0.5
      })
    }
  }
}

onMounted(() => {
  useCharAnimation()
  animateHeroText()
})
</script>

<template>
  <div class="tp-hero-area tp-hero-pt pt-170 pb-70 p-relative">
    <div class="tp-hero-left-shape">
      <img src="/assets/img/hero/hero-left-shape-3-1.png" alt="" />
    </div>
    <div class="tp-hero-gradient-bg">
      <img src="/assets/img/hero/hero-gradient-3.jpg" alt="" />
    </div>
    <div class="container">
      <div class="row justify-content-center z-index-3">
        <div class="col-xl-11">
          <div class="tp-hero-title-box text-center">
            <h2 ref="hero_text_anim" class="tp-hero-title-3 hero-text-anim pb-5">
              <i
                ><i ref="heroTextAnimChildren" class="child-1" v-html="sanitizeHtml(hero.title)"></i
              ></i>
            </h2>
            <p class="tp-char-animation-2">
              {{ hero.subtitle }}
            </p>
          </div>
          <div
            class="tp-hero-btn-3 wow tpfadeUp text-center"
            data-wow-duration=".9s"
            data-wow-delay=".7s"
          >
            <Link
              class="tp-btn-blue-lg tp-btn-hover alt-color-black"
              :href="sanitizeHtml(hero.btn_one_link)"
            >
              <span>{{ hero.btn_one_text }}</span>
              <b></b>
            </Link>
            <Link
              class="tp-btn-border tp-btn-hover alt-color-black"
              :href="sanitizeHtml(hero.btn_two_link)"
            >
              <span>{{ hero.btn_two_text }}</span>
              <b></b>
            </Link>
          </div>
          <div
            class="tp-hero-browser-wrapper d-flex align-items-center justify-content-center wow tpfadeUp"
            data-wow-duration=".9s"
            data-wow-delay=".9s"
          >
            <div v-for="item in hero.icons" :key="item" class="tp-hero-browser-item">
              <a :href="sanitizeUrl(item.link)">
                <img :src="sanitizeHtml(item.icon)" alt="" />
              </a>
              <p class="d-none d-sm-block text-dark">
                {{ item.title }}
              </p>
            </div>
          </div>
          <div class="tp-hero-3-wrapper p-relative">
            <div class="tp-hero-3-border-wrap d-none d-md-block">
              <span class="redius-shape-1"></span>
              <span class="redius-shape-2"></span>
              <span class="redius-shape-3"></span>
            </div>
            <div class="tp-hero-3-main-thumb z-index-5">
              <img
                :src="sanitizeHtml(hero.bottom_img) ?? '/assets/img/hero/hero-img-3-1.png'"
                alt=""
              />
            </div>
            <div class="tp-hero-3-shape-5 d-none d-lg-block wow frist-img animated">
              <img :src="sanitizeHtml(hero.bottom_bg_overflow)" alt="" />
            </div>
            <div class="tp-hero-3-shape-6 d-none d-lg-block">
              <span>
                <svg
                  width="64"
                  height="202"
                  viewBox="0 0 64 202"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    class="line-2"
                    d="M63.0029 7.94799C45.0715 -0.936415 14.5884 -8.38783 36.1059 32.8816C63.0029 84.4681 71.2089 85.3283 36.1059 75.8707C1.00293 66.4131 15.5915 92.2063 36.1059 118C56.6205 143.794 57.0764 169.587 28.3558 152.391C-0.364664 135.195 1.00293 144.653 28.3558 179.904C55.7087 215.155 22.4293 195.38 1.00293 196.24"
                    stroke="#202124"
                    stroke-width="2"
                  />
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
