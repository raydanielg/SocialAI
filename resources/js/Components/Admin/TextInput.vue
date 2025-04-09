<script setup>
import { onMounted, ref } from "vue"

defineProps({
  label: {
    type: String,
    default: "Text Input",
  },
  modelValue: {
    type: String,
    required: true,
  },
})

defineEmits(["update:modelValue"])

const input = ref(null)

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus()
  }
})

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
  <div>
    <label class="label mb-1"> {{ label }}</label>
    <input
      class="input"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
    />
  </div>
</template>
