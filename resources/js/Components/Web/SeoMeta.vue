<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const meta = computed(() => {
  const metaData = usePage().props?.seoMeta ?? {};
  return {
    site_name: metaData?.title || metaData?.site_name || "",
    current_url: metaData?.current_url ?? window.location.href,
    tags: metaData?.tags || "",
    description: metaData?.description || "",
    preview: metaData?.preview || "",
  };
});
</script>

<template>
  <Head>
    <title>{{ meta.site_name }}</title>
    <meta name="description" itemprop="description" :content="meta.description" />
    <meta name="keywords" :content="meta.tags" />
    <meta property="og:description" :content="meta.description" />
    <meta property="og:title" :content="meta.site_name" />
    <meta property="og:url" :content="meta.current_url" />

    <meta property="og:site_name" :content="meta.site_name" />
    <meta property="og:image" :content="meta.preview" />
    <meta property="og:image:url" :content="meta.preview" />

    <meta name="twitter:card" :content="meta.description" />
    <meta name="twitter:title" :content="meta.site_name" />
  </Head>
</template>
