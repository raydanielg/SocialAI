<script setup>
import { VueDraggable } from 'vue-draggable-plus'
import { computed } from 'vue'
import { menu } from '@/Composables/sidebarMenuComposable'
import toast from '@/Composables/toastComposable'
const props = defineProps({
  modelValue: {
    required: true
  },
  level: {
    type: Number,
    default: 0
  }
})

const emits = defineEmits(['update:modelValue'])

const list = computed({
  get: () => props.modelValue,
  set: (value) => emits('update:modelValue', value)
})
const remove = (id, element) => {
  if (!element.deletable) {
    return toast.danger('You can not delete this item')
  }
  menu.contentId = id
  menu.removeItem()
}

const edit = (id) => {
  menu.contentId = id
  menu.editItem()
}
const maxNestingLevel = 1
const handleMove = (e) => {
  const targetLevel = e.to.dataset.level ? parseInt(e.to.dataset.level) : 0
  if (targetLevel > maxNestingLevel) {
    toast.warning('Cannot move this item to the selected location due to nesting restrictions.')
    return false
  }

  return true
}
const handleEnd = (e) => {
  const draggedItem = e.data

  const hasChildren = draggedItem.children && draggedItem.children.length > 0

  if (hasChildren) {
    const allChildren = Array.from(draggedItem.children)
    const deletedChildren = []
    allChildren.forEach((element) => {
      deletedChildren.push(element)

      menu.contentId = element.id
      menu.removeItem()
    })
    deletedChildren.forEach((element) => {
      menu.contents.push(element)
    })
    toast.warning('Remaining links added at the end')
  }

  const ensureChildrenKey = (items) => {
    return items.map((item) => {
      if (!item.children) {
        item.children = []
      } else {
        item.children = ensureChildrenKey(item.children)
      }
      return item
    })
  }
  const removeSecondLevelChildrenKey = (items) => {
    return items.map((item) => {
      if (item.children) {
        item.children = item.children.map((child) => {
          if (child.children) {
            delete child.children
          }
          return child
        })
      }
      return item
    })
  }

  menu.contents = ensureChildrenKey(menu.contents)
  menu.contents = removeSecondLevelChildrenKey(menu.contents)
  return true
}
</script>

<template>
  <VueDraggable
    class="drag-area"
    tag="ul"
    v-model="list"
    group="g1"
    @move="handleMove"
    @end="handleEnd"
    :data-level="level"
  >
    <li v-for="el in modelValue" :key="el.id">
      <div class="flex items-center justify-between rounded border p-2 dark:border-gray-600">
        <p class="cursor-move">
          <Icon class="mb-px inline text-lg" icon="tdesign:drag-move"></Icon>
          {{ el.text }}
        </p>
        <div>
          <button class="btn p-1.5" @click="edit(el.id)">
            <Icon class="text-lg" icon="fe:pencil"></Icon>
          </button>
          <button class="btn p-1.5" @click="remove(el.id, el)">
            <Icon class="text-lg" icon="fe:trash"></Icon>
          </button>
        </div>
      </div>

      <NestedDraggableSidebar v-model="el.children" :level="level + 1" />
    </li>
  </VueDraggable>
</template>
