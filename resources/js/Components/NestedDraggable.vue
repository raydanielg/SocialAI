<template>
  <VueDraggable class="drag-area" tag="ul" v-model="list" group="g1">
    <li v-for="el in modelValue" :key="el.id">
      <div class="flex items-center justify-between rounded border p-2 dark:border-gray-600">
        <p class="flex cursor-move items-center gap-2">
          <Icon icon="bx:move" class="text-lg" />
          <span>{{ el.text }}</span>
        </p>
        <div class="flex gap-4">
          <button @click="edit(el.id)">
            <Icon icon="bx:pencil" class="text-lg hover:text-blue-400" />
          </button>
          <button @click="remove(el.id)">
            <Icon icon="bx:trash" class="text-lg hover:text-red-400" />
          </button>
        </div>
      </div>
      <NestedDraggable v-model="el.children" />
    </li>
  </VueDraggable>
</template>

<script setup>
import { VueDraggable } from 'vue-draggable-plus'
import { computed } from 'vue'
import { menu } from '@/Composables/menuComposable'

const props = defineProps({
  modelValue: {
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const list = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const remove = (id) => {
  menu.contentId = id
  menu.removeItem()
}

const edit = (id) => {
  menu.contentId = id
  menu.editItem()
}
</script>
