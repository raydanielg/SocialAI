<script setup>
import Header from '@/Layouts/Default/Header.vue'
import Footer from '@/Layouts/Default/Footer.vue'

import SeoMeta from '@/Components/Web/SeoMeta.vue'
import ScrollToTopBtn from '@/Layouts/Default/ScrollToTopBtn.vue'
import ToastrContainer from '@/Components/ToastrContainer.vue'
import { onMounted } from 'vue'

if (typeof window !== 'undefined') {
  import('bootstrap/dist/js/bootstrap')
}

onMounted(async () => {
  const wow = await import('wow.js')
  new wow.default().init()
})

</script>

<template>
  <SeoMeta />
  <ToastrContainer />
  <ScrollToTopBtn />
  <Header />
  <div id="smooth-wrapper">
    <div id="smooth-content">
      <main class="fix">
        <slot />
      </main>
      <Footer />
    </div>
  </div>
</template>
