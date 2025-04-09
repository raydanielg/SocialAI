<script setup>
import { useDesignStore } from '@/Store/Admin/designStore'
import Multiselect from '@vueform/multiselect'
const store = useDesignStore()

const changeFontWeight = () => {
  let fontWeight
  if (store.textStyles.fontWeight === 'normal') {
    fontWeight = 'bold'
  } else {
    fontWeight = 'normal'
  }
  console.log(fontWeight)
  store.$patch({
    textStyles: {
      fontWeight: fontWeight
    }
  })
  store.changeSelectedTextStyle()
}
const changeFontStyle = () => {
  let fontStyle
  if (store.textStyles.fontStyle === 'normal') {
    fontStyle = 'italic'
  } else {
    fontStyle = 'normal'
  }

  store.$patch({
    textStyles: {
      fontStyle: fontStyle
    }
  })
  store.changeSelectedTextStyle()
}
const changeFontAlign = (align) => {
  store.$patch({
    textStyles: {
      textAlign: align
    }
  })
  store.changeSelectedTextStyle()
}
</script>
<template>
  <div class="mt-6 space-y-6">
    <div class="mb-2 mt-2">
      <label class="label mb-1">{{ trans('Font Family') }}</label>
      <Multiselect
        @select="store.changeSelectedTextStyle()"
        class="multiselect-dark"
        v-model="store.textStyles.fontFamily"
        mode="single"
        :options="store.fontLists"
        :searchable="true"
        placeholder="Select Fonts"
      >
        <template v-slot:singlelabel="{ value }">
          <div class="multiselect-single-label">
            <span :style="{ fontFamily: `${value.label}` }">{{ value.label }}</span>
          </div>
        </template>

        <template v-slot:option="{ option }">
          <span :style="{ fontFamily: `${option.label}` }">{{ option.label }}</span>
        </template>
      </Multiselect>
    </div>
    <div class="flex items-center gap-2">
      <span class="text-lg">Size</span>
      <input
        v-model="store.textStyles.fontSize"
        @input="store.changeSelectedTextStyle"
        type="text"
        class="input w-20"
      />
      <button
        class="btn py-1"
        :class="{
          'btn-dark': store.textStyles.fontWeight === 'normal',
          'btn-primary': store.textStyles.fontWeight === 'bold'
        }"
        @click="changeFontWeight"
      >
        <i class="bx bx-bold text-lg"></i>
      </button>
      <button
        @click="
          () => {
            store.textStyles.underline = !store.textStyles.underline
            store.changeSelectedTextStyle()
          }
        "
        class="btn py-1"
        :class="{
          'btn-dark': !store.textStyles.underline,
          'btn-primary': store.textStyles.underline
        }"
      >
        <i class="bx bx-underline text-lg"></i>
      </button>
      <button
        class="btn py-1"
        :class="{
          'btn-dark': store.textStyles.fontStyle === 'normal',
          'btn-primary': store.textStyles.fontStyle === 'italic'
        }"
        @click="changeFontStyle"
      >
        <i class="bx bx-italic text-lg"></i>
      </button>
    </div>
    <div class="flex items-center gap-2">
      <span class="text-lg">Text Alignment </span>

      <button
        class="btn py-1"
        :class="store.textStyles.textAlign === 'left' ? 'btn-primary' : 'btn-dark'"
        @click="changeFontAlign('left')"
      >
        <i class="bx bx-align-left text-lg"></i>
      </button>
      <button
        @click="changeFontAlign('center')"
        class="btn py-1"
        :class="store.textStyles.textAlign === 'center' ? 'btn-primary' : 'btn-dark'"
      >
        <i class="bx bx-align-middle text-lg"></i>
      </button>
      <button
        class="btn py-1"
        :class="store.textStyles.textAlign === 'right' ? 'btn-primary' : 'btn-dark'"
        @click="changeFontAlign('right')"
      >
        <i class="bx bx-align-right text-lg"></i>
      </button>
    </div>
    <div class="flex items-center justify-between gap-2">
      <span class="text-lg">Text Color </span>

      <div class="flex items-center gap-3">
        <div class="h-10 w-10 overflow-hidden rounded-full">
          <input
            v-model="store.textStyles.fill"
            @input="store.changeSelectedTextStyle"
            class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
            type="color"
            name="file"
          />
        </div>
        <p class="w-16">
          {{ store.textStyles.fill }}
        </p>
      </div>
    </div>
    <div class="flex items-center justify-between gap-2">
      <span class="text-lg">Text BG Color </span>

      <div class="flex items-center gap-3">
        <div class="h-10 w-10 overflow-hidden rounded-full">
          <input
            v-model="store.textStyles.backgroundColor"
            @input="store.changeSelectedTextStyle"
            class="h-14 w-12 -translate-x-1 -translate-y-2 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
            type="color"
            name="file"
          />
        </div>
        <p class="w-16">
          {{ store.textStyles.fill }}
        </p>
      </div>
    </div>
  </div>
</template>
