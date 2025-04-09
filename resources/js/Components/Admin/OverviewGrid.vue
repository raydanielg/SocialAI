<script setup>
const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
  grid: {
    type: [Number, String],
    default: 4
  }
})

const gridClass = () => `lg:grid-cols-${props.grid}`
</script>

<template>
  <section v-if="items.length" :class="gridClass()" class="mb-4 grid grid-cols-1 gap-4">
    <div class="card" v-for="item in items" :key="item">
      <div class="card-body flex items-center gap-4">
        <div
          v-if="item.icon ?? item.iconClass"
          class="rounded-full p-3 text-xl"
          :class="[item.style ?? 'bg-primary-500/20 text-primary-600']"
        >
          <Icon :icon="item.icon ?? item.iconClass" />
        </div>
        <div class="flex flex-1 flex-col gap-1">
          <p class="text-sm tracking-wide text-slate-500">
            {{ item.title }}
          </p>
          <div class="flex flex-wrap items-baseline justify-between gap-2">
            <h4>{{ item.value }}</h4>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>