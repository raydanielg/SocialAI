<script setup>
import { router, useForm } from "@inertiajs/vue3"
import { onMounted, ref, watch } from "vue"
import SpinnerBtn from "./SpinnerBtn.vue"

const props = defineProps({
  action: {
    type: String,
    required: false,
    default: "",
  },
  options: {
    type: [Array, Object],
    required: false,
    default: [
      {
        value: "id",
        label: "id",
        selected: true,
      },
    ],
  },
})

const getQueryParams = () => {
  const obj = {}
  const para = new URLSearchParams(window.location.search)

  for (const [key, value] of para) {
    if (obj.hasOwnProperty(key)) {
      if (Array.isArray(obj[key])) {
        obj[key].push(value)
      } else {
        obj[key] = [obj[key], value]
      }
    } else {
      obj[key] = value
    }
  }

  return obj
}

const filterForm = useForm({
  search: getQueryParams()?.search ?? "",
  type:
    getQueryParams()?.type ??
    props.options?.find((item) => item.selected)?.value ??
    props.options?.[0]?.value ??
    "",
})

const handleSubmit = () => {
  filterForm.get(props.action)
}

const clearFilter = () => {
  router.get(location.pathname)
}

const selectableOptions = ref([])

const handleOnSelect = () => {
  filterForm.search = ""

  if (props.options && filterForm.type) {
    let getOptions = props.options?.find((item) => item.value == filterForm.type) ?? []

    selectableOptions.value = getOptions.options ?? []

    filterForm.search =
      getOptions.options?.find((item) => item.selected == true)?.value ??
      selectableOptions.value[0]?.value ??
      ""
  } else {
    selectableOptions.value = []
  }
}

watch(() => filterForm.type, handleOnSelect)

// define pre selected items on mounted
onMounted(() => {
  let selectedItem = props.options?.find((item) => item.value == filterForm.type) ?? {}

  let isDropdown =
    selectedItem.hasOwnProperty("options") && Array.isArray(selectedItem.options)

  if (isDropdown) {
    selectableOptions.value = selectedItem.options
    // if has no pre selected value then select first item
    if (!filterForm.search) {
      filterForm.search = selectableOptions.value[0]?.value ?? ""
    }
  }
})
</script>

<template>
  <div class="flex items-stretch justify-end gap-x-2">
    <div class="dropdown" data-placement="bottom-end">
      <div class="dropdown-toggle">
        <button
          type="button"
          class="font-medium bg-white shadow-sm btn dark:bg-slate-800 hover:dark:bg-slate-700 border border-slate-700"
        >
          <Icon icon="fe:filter" />
          <span>{{ trans("Filter") }}</span>
          <Icon icon="bx:chevron-down" />
        </button>
      </div>

      <div class="dropdown-content w-72 !overflow-visible">
        {{ props.action ?? "nai" }}
        <form @submit.prevent="handleSubmit">
          <ul class="p-4 space-y-4 dropdown-list">
            <!-- show if select has not any options -->
            <li v-if="selectableOptions.length" class="dropdown-list-item">
              <label class="mb-1 capitalize">{{ filterForm.type }}</label>
              <select class="select" v-model="filterForm.search">
                <option
                  v-for="option in selectableOptions"
                  :key="option.value"
                  :value="option.value"
                >
                  {{ option.label }}
                </option>
              </select>
            </li>

            <li v-else class="dropdown-list-item">
              <label class="mb-1">{{ trans("Search Keyword") }}</label>
              <input
                type="text"
                v-model="filterForm.search"
                class="input"
                placeholder="enter search keyword"
              />
            </li>

            <li class="dropdown-list-item">
              <label class="mb-1">{{ trans("Search Type") }}</label>
              <select class="select" v-model="filterForm.type">
                <option
                  v-for="option in options"
                  :key="option.value"
                  :value="option.value"
                  :selected="option.selected"
                >
                  {{ option.label }}
                </option>
              </select>
            </li>

            <li class="dropdown-list-item">
              <SpinnerBtn
                type="submit"
                :processing="filterForm.processing"
                :btn-text="trans('Search')"
                class="w-full btn btn-primary"
              />
            </li>
          </ul>
        </form>
      </div>
    </div>
    <button
      v-show="getQueryParams().search"
      @click="clearFilter"
      class="flex items-center bg-gray-300 border dark:bg-gray-700 btn hover:dark:bg-slate-800 hover:dark:border-slate-700 dark:border-gray-600"
      title="clear filter"
    >
      <i class="bx bx-x"></i>
    </button>
  </div>
</template>
