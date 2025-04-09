<script setup>
defineProps({
  forTable: {
    type: [Boolean, String],
    default: false,
  },
});
</script>

<template>
  <tbody v-if="forTable">
    <tr>
      <td colspan="10">
        <div class="flex flex-col items-center justify-center mt-5 mb-8">
          <img src="/assets/images/no-data.svg" class="h-16 my-3" alt="" />
          <p class="text-gray-500">{{ trans("No data found") }}</p>
        </div>
      </td>
    </tr>
  </tbody>

  <div v-else class="flex flex-col items-center justify-center mt-5 mb-8">
    <img src="/assets/images/no-data.svg" class="h-16 my-3" alt="" />
    <p class="text-gray-500">{{ trans("No data found") }}</p>
  </div>
</template>
