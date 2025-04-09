<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'

const store = useDesignStore()
</script>

<template>
  <h3>Image</h3>
  <div class="mt-4">
    <label class="label mb-1">Upload Image</label>
    <input @input="store.uploadImage" accept="image/*" type="file" class="input" />
  </div>
</template>
