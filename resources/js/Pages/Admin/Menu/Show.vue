<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import NestedDraggable from '@/Components/NestedDraggable.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { onMounted } from 'vue'
import axios from 'axios'
import { menu } from '@/Composables/menuComposable'
import trans from '@/Composables/transComposable'
import notify from '@/Composables/toastComposable'

defineOptions({ layout: AdminLayout })
const props = defineProps(['info', 'contents', 'segments', 'buttons'])

onMounted(() => {
  menu.contents = props.contents
})

const updateData = () => {
  axios
    .patch(route('admin.menu.data.update', props.info.id), {
      data: menu.contents
    })
    .then((res) => {
      if (res.status == 200) {
        notify.success(trans('Menu item has been updated successfully'))
      }
    })
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Manage Menu')" :buttons="buttons" />

    <div class="grid grid-cols-1 place-items-start gap-6 lg:grid-cols-12">
      <div class="card col-span-1 lg:col-span-9">
        <div class="card-body">
          <div class="mb-8 flex items-center justify-between">
            <h4>{{ trans('Menu Items') }}</h4>

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
              <NestedDraggable v-model="menu.contents" />
            </template>
          </div>
        </div>
      </div>

      <div class="col-span-1 w-full lg:col-span-3">
        <div class="card-body card">
          <h4 class="mb-5">{{ trans('Create Menu Items') }}</h4>

          <form class="space-y-6">
            <div>
              <label for="text" class="label label-required">{{ trans('Text') }}</label>
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
              <label for="href" class="label label-required">{{ trans('URL') }}</label>
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
              <label for="target" class="label label-required">{{ trans('Target') }}</label>
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
              <Icon icon="mdi:content-save" />
              {{ trans('Update') }}
            </button>
            <button
              type="button"
              id="btnAdd"
              @click.prevent="menu.addNewItem"
              class="btn btn-success flex-1"
              :disabled="menu.isEdit"
            >
              <Icon icon="mdi:plus" />
              {{ trans('Add') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
