<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import NestedDraggableSidebar from '@/Components/Admin/NestedDraggableSidebar.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { onMounted } from 'vue'
import axios from 'axios'
import { menu } from '@/Composables/sidebarMenuComposable'
import toast from '@/Composables/toastComposable'

defineOptions({ layout: AdminLayout })
const props = defineProps(['info', 'contents', 'segments', 'buttons', 'location'])

onMounted(() => {
  menu.contents = props.contents
})

const updateData = () => {
  axios
    .patch(route('admin.sidebar-menu.data.update', props.info.id), {
      data: menu.contents,
      location: props.location
    })
    .then((res) => {
      if (res.status == 200) {
        toast.success('Menu item has been updated successfully')
        window.location.reload()
      }
    })
    .catch((err) => {
      toast.danger(err.response.data.error)
    })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Manage Sidebar Menu')" :buttons="buttons" />

    <div class="grid grid-cols-1 place-items-start gap-6 lg:grid-cols-12">
      <div class="card col-span-1 lg:col-span-8">
        <div class="card-body">
          <div class="mb-8 flex items-center justify-between">
            <h4>{{ trans('Sidebar Items') }}</h4>

            <button
              type="button"
              id="form-button"
              class="btn btn-success"
              @click.prevent="updateData"
            >
              {{ trans('Save') }}
            </button>
          </div>
          <div>
            <template v-if="props.contents">
              <NestedDraggableSidebar v-model="menu.contents" />
            </template>
          </div>
        </div>
      </div>

      <div class="col-span-1 w-full lg:col-span-4">
        <div class="card-body card">
          <h4 class="mb-5">{{ trans('Create Sidebar Items') }}</h4>

          <form class="space-y-2">
            <div>
              <label for="text" class="label label-required mb-1">{{ trans('Text') }}</label>
              <input
                type="text"
                class="input"
                name="text"
                id="text"
                placeholder="Text"
                autocomplete="off"
                v-model="menu.newItem.text"
              />
            </div>

            <div>
              <label for="text" class="label label-required mb-1">{{ trans('Icon') }}</label>
              <input
                type="text"
                class="input"
                placeholder="Icon"
                required
                autocomplete="off"
                v-model="menu.newItem.icon"
              />
            </div>
            <div>
              <label for="href" class="label label-required mb-1">{{ trans('URL') }}</label>
              <input
                type="text"
                class="input"
                id="href"
                name="href"
                placeholder="URL"
                required
                autocomplete="off"
                v-model="menu.newItem.href"
              />
            </div>
            <div>
              <label for="text" class="label">{{ trans('Permission') }}</label>
              <input
                type="text"
                class="input"
                placeholder="Permission"
                autocomplete="off"
                v-model="menu.newItem.permission"
              />
            </div>
            <div>
              <label for="target" class="label label-required mb-1">{{ trans('Target') }}</label>
              <select name="target" class="input" v-model="menu.newItem.target">
                <option value="_self">
                  {{ trans('Self') }}
                </option>
                <option value="_blank">
                  {{ trans('Blank') }}
                </option>
                <option value="_top">
                  {{ trans('Top') }}
                </option>
              </select>
            </div>
          </form>
          <div class="menu-add-update mt-6 flex">
            <button
              type="button"
              id="btnUpdate"
              class="btn btn-update btn-warning mr-2 flex-1 text-white"
              @click.prevent="menu.updateItem"
              :disabled="!menu.isEdit"
            >
              <Icon icon="bx:refresh" class="text-lg" />
              {{ trans('Update') }}
            </button>
            <button
              type="button"
              id="btnAdd"
              @click.prevent="menu.addNewItem"
              class="btn btn-success flex-1"
              :disabled="menu.isEdit"
            >
              <Icon icon="bx:plus" class="text-lg" />
              {{ trans('Add') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
