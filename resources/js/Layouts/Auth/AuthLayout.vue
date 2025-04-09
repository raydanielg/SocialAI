<script setup>
import Header from '@/Layouts/Auth/Header.vue'
import SeoMeta from '@/Components/Web/SeoMeta.vue'
import ToastrContainer from '@/Components/ToastrContainer.vue'
</script>
<template>
  <SeoMeta />
  <ToastrContainer />
  <Header />
  <main>
    <slot />
  </main>
</template>
