<script setup>
import { router, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import { useModalStore } from '@/Store/modalStore'
import { useDesignStore } from '@/Store/Admin/designStore'
import Modal from '@/Components/Modal.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'

defineOptions({ layout: AdminLayout })
const modal = useModalStore()
const store = useDesignStore()
const props = defineProps(['designs', 'segments'])
const { deleteRow } = sharedComposable()
const submit = () => {
  modal.$reset()
  router.get(route('admin.design.create'))
}
</script>

<template>
  <Modal
    @action="submit"
    :action-processing="store.form.processing"
    :state="modal.getState('createDesign')"
    :header-state="true"
    header-title="Create Design"
    :action-btn-state="true"
  >
    <div class="my-3">
      <label class="label mb-1">Title</label>
      <input type="text" v-model="store.form.title" class="input" />
    </div>
  </Modal>

  <main class="container flex-grow p-4 sm:p-6">
    <div class="mt-4 flex items-center justify-between">
      <PageHeader title="Designs" :buttons="[]" />
    </div>
    <div>
      <!-- card -->
      <div class="bg-transparent">
        <!-- cards -->
        <div
          class="grid w-full grid-cols-1 gap-6 pb-8 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5"
        >
          <CreatePostCard
            classes="h-80 min-w-[14rem]"
            text="Create Design"
            @action="modal.open('createDesign')"
          />
          <template v-for="design in designs.data" :key="design.id">
            <div
              class="relative flex h-80 min-w-[14rem] flex-col overflow-hidden rounded-2xl border border-gray-50 shadow-md dark:border-gray-600 dark:bg-[#0f172a7e]"
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
                  <Link :href="route('admin.design.edit', design.id)" class="dropdown-link">
                    <Icon icon="fe:edit" />
                    <span class="text-sm">{{ trans('Edit') }}</span>
                  </Link>
                  <button
                    class="dropdown-link"
                    @click="deleteRow(route('admin.design.destroy', design.id))"
                  >
                    <Icon icon="fe:trash" />
                    <span class="text-sm">{{ trans('Delete') }}</span>
                  </button>
                </div>
              </div>

              <img class="h-64 w-full object-cover" :src="design.placeholder" alt="placeholder" />

              <div class="flex items-center justify-between px-4 pt-5">
                <p class="font-semibold">{{ design.title }}</p>
                <div class="badge dark:bg-secondary-800">
                  <i class="bx bx-file-blank mr-px text-base"></i>
                  <span class="text-xs">{{ design.status }}</span>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </main>
</template>
