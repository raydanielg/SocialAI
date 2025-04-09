<script setup>
import { router } from '@inertiajs/vue3'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'
import FilterDropdown from '@/Components/Admin/FilterDropdown.vue'
defineOptions({ layout: UserLayout })
const props = defineProps(['brands'])
const { deleteRow } = sharedComposable()

const filterOptions = [
  {
    label: 'Name',
    value: 'name'
  }
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <div class="mb-8 mt-4 flex items-center justify-between">
      <PageHeader title="Brands" />
      <div class="w-80">
        <FilterDropdown :options="filterOptions" />
      </div>
    </div>

    <!-- cards -->
    <div class="grid w-full grid-cols-1 gap-8 pb-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
      <CreatePostCard
        classes="h-88 min-w-[16rem]"
        text="Create Brand"
        @action="() => router.get(route('user.brand.create'))"
      />
      <template v-for="brand in brands.data" :key="brand.id">
        <div
          class="relative flex h-88 min-w-[16rem] flex-col overflow-hidden rounded-2xl border border-gray-50 shadow-md dark:border-gray-600 dark:bg-[#0f172a7e]"
        >
          <div class="dropdown absolute right-2 top-2" data-placement="bottom-end">
            <div class="dropdown-toggle p-1">
              <button
                type="button"
                class="h-8 w-8 rounded-full bg-white font-medium shadow-sm dark:bg-slate-800"
              >
                <i class="bx bx-dots-vertical-rounded text-xl"></i>
              </button>
            </div>

            <div class="dropdown-content w-32 !overflow-visible p-1">
              <Link :href="route('user.brand.show', brand.uuid)" class="dropdown-link">
                <Icon icon="fe:edit" />
                <span class="text-sm">{{ trans('Edit') }}</span>
              </Link>
            </div>
          </div>
          <Link :href="route('user.brand.show', brand.uuid)">
            <img class="h-72 w-full object-cover" :src="brand.logo" alt="placeholder" />
          </Link>

          <Link
            :href="route('user.brand.show', brand.uuid)"
            class="flex items-center justify-between px-4 pt-5"
          >
            <p class="font-semibold">{{ brand.name }}</p>
          </Link>
        </div>
      </template>
    </div>
  </main>
</template>
