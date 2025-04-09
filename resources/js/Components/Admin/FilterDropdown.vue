<script setup>
import {
  computed,
  ref,
} from "vue";

import SpinnerBtn from "@/Components/SpinnerBtn.vue";
import {
  router,
  useForm,
} from "@inertiajs/vue3";

const props = defineProps({
  action: {
    type: String,
    required: false,
    default: ''
  },
  appends: {
    type: Object,
    required: false,
    default: {}
  },
  options: {
    type: [Array, Object],
    required: false,
    default: [
      {
        value: 'id',
        label: 'id',
        selected: true
      }
    ]
  },
  formOptions: {
    type: Object,
    default: {}
  }
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
  search: getQueryParams()?.search ?? '',
  type:
    getQueryParams()?.type ??
    props.options?.find((item) => item.selected)?.value ??
    props.options?.[0]?.value ??
    ''
})

const handleSubmit = () => {
  let url = props.action
  let queryString = '?' + new URLSearchParams(props.appends).toString()
  filterForm.get(url + queryString, props.formOptions)
}

const clearFilter = () => {
  router.get(location.pathname, props.formOptions)
}

const isOptionExist = computed(() => {
  if (props.options && filterForm.type) {
    return props.options.find((item) => item.value == filterForm.type)
  }
  return false
})

const showClearText = ref(false)
</script>

<template>
  <div class="flex items-stretch justify-end gap-x-2">
    <div class="dropdown" data-placement="bottom-end">
      <div class="dropdown-toggle">
        <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
          <Icon class="text-xl text-slate-400" icon="material-symbols:filter-alt-outline-sharp" />
          <span>{{ trans('Search') }}</span>
          <Icon class="text-xl text-slate-400" icon="tdesign:chevron-down" />
        </button>
      </div>

      <div class="dropdown-content w-72 !overflow-visible">
        <form @submit.prevent="handleSubmit">
          <ul class="dropdown-list space-y-4 p-4">
            <!-- show if select has not any options -->
            <li v-if="isOptionExist && isOptionExist.options" class="dropdown-list-item">
              <label class="mb-1 capitalize">{{ isOptionExist.label }}</label>

              <select class="select" v-model="filterForm.search">
                <option value="" disabled selected>
                  {{ trans('Select') }}
                </option>
                <option v-for="option in isOptionExist.options" :key="option.value" :value="option.value">
                  {{ option.label }}
                </option>
              </select>
            </li>

            <li v-else class="dropdown-list-item">
              <label class="mb-1">{{ trans('Search Keyword') }}</label>
              <input type="text" v-model="filterForm.search" class="input" placeholder="enter search keyword" />
            </li>

            <li class="dropdown-list-item">
              <label class="mb-1">{{ trans('Search Type') }}</label>
              <select class="select" @change="filterForm.reset('search')" v-model="filterForm.type">
                <option v-for="option in options" :key="option.value" :value="option.value" :selected="option.selected">
                  {{ option.label }}
                </option>
              </select>
            </li>

            <li class="dropdown-list-item">
              <SpinnerBtn :disabled="filterForm.search.length === 0" type="submit" :processing="filterForm.processing"
                :btn-text="trans('Search')" class="btn btn-primary w-full" icon="bx bx-search" />
            </li>
          </ul>
        </form>
      </div>
    </div>
    <button v-show="getQueryParams().search" @click="clearFilter" @mouseover="showClearText = true"
      @mouseout="showClearText = false"
      class="btn flex items-center border bg-gray-300 dark:border-dark-700 dark:bg-dark-800" title="clear filter">
      <i class="bx bx-x"></i>
      <span v-show="showClearText">{{ trans('Clear') }}</span>
    </button>
  </div>
</template>
