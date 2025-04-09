<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm, router } from '@inertiajs/vue3'
import trans from '@/Composables/transComposable'
import sharedComposable from '@/Composables/sharedComposable'
import drawer from '@/Plugins/Admin/drawer'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'
import { onMounted } from 'vue'
import { vDraggable } from 'vue-draggable-plus'
defineOptions({ layout: AdminLayout })

onMounted(() => {
  drawer.init()
})

const props = defineProps(['menus', 'segments', 'buttons'])
const { deleteRow, trim } = sharedComposable()

const form = useForm({
  heading: null,
  location: ''
})

const edit = useForm({
  heading: null,
  location: ''
})

const openEditDrawer = (menu, location) => {
  edit.heading = menu.heading
  edit.location = location
  edit.id = menu.id
  drawer.of('#editMenuDrawer').show()
}

function storeMenu() {
  router.post(route('admin.sidebar-menu.store'), form, {
    onSuccess: () => {
      form.reset()
      drawer.of('#addNewMenuDrawer').hide()
    }
  })
}

function updateMenu(menu, order = null, location = null) {
  if (order && menu) {
    edit.heading = menu.heading
    edit.location = location
    edit.id = menu.id
  }
  router.patch(route('admin.sidebar-menu.update', edit.id), edit, {
    onSuccess: () => {
      setTimeout(() => window.location.reload(), 1000)
      drawer.of('#editMenuDrawer').hide()
    }
  })
}
const handleEnd = (location) => {
  setTimeout(() => {
    const findMenu = props.menus[location]

    if (findMenu) {
      const updatedMenu = findMenu.map((item, index) => {
        return {
          id: item.id,
          order: index + 1
        }
      })
      router.patch(
        route('admin.sidebar-menu.arrange', location),
        { items: updatedMenu },
        {
          onSuccess: () => {
            setTimeout(() => window.location.reload(), 1000)
          }
        }
      )
    }
  }, 500)
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Menu')" :buttons="buttons" />

    <div class="grid gap-6 lg:grid-cols-2">
      <div v-for="(menu, key) in menus" :key="key">
        <p class="mb-1 font-semibold capitalize">{{ trim(key) }}</p>
        <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
            <thead>
              <tr>
                <th>{{ trans('SN') }}</th>
                <th>{{ trans('Group Heading') }}</th>
                <th class="!text-right">{{ trans('Action') }}</th>
              </tr>
            </thead>

            <tbody v-draggable="menu" @end="handleEnd(key)">
              <tr v-for="item in menu" :key="item.id">
                <td class="cursor-move">
                  {{ item.order }}
                </td>
                <td class="cursor-move">
                  {{ item.heading }}
                </td>

                <td>
                  <div class="flex justify-end">
                    <div class="dropdown" data-placement="bottom-start">
                      <div class="dropdown-toggle">
                        <Icon class="w-30 text-lg" icon="bi:three-dots-vertical" />
                      </div>
                      <div class="dropdown-content w-40">
                        <ul class="dropdown-list">
                          <li class="dropdown-list-item">
                            <Link
                              :href="route('admin.sidebar-menu.show', [item.id, key])"
                              class="dropdown-link"
                            >
                              <Icon class="h-6 text-slate-400" icon="fe:list-bullet" />
                              <span>{{ trans('Manage') }}</span>
                            </Link>
                          </li>

                          <li class="dropdown-list-item">
                            <button @click="openEditDrawer(item, key)" class="dropdown-link">
                              <Icon
                                class="h-6 text-slate-400"
                                icon="material-symbols:edit-outline"
                              />
                              <span>{{ trans('Edit') }}</span>
                            </button>
                          </li>

                          <li class="dropdown-list-item">
                            <button
                              class="dropdown-link"
                              @click="
                                deleteRow(route('admin.sidebar-menu.destroy', [item.id, key]))
                              "
                            >
                              <Icon class="h-6 text-slate-400" icon="fe:trash" />
                              <span>{{ trans('Delete') }}</span>
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <div id="addNewMenuDrawer" class="drawer drawer-right">
    <form @submit.prevent="storeMenu()">
      <div class="drawer-header">
        <h5>{{ trans('Add New Menu') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <i data-feather="x" width="1.5rem" height="1.5rem"></i>
        </button>
      </div>
      <div class="drawer-body">
        <div>
          <label class="label label-required mb-1">{{ trans('Group Headings') }}</label>
          <input
            type="text"
            v-model="form.heading"
            name="heading"
            class="input"
            required
            placeholder="Example"
          />
        </div>
        <div>
          <label class="label label-required mb-1">{{ trans('Select Menu Location') }}</label>
          <select class="input capitalize" name="location" v-model="form.location">
            <option value="">{{ trans('Select Menu Location') }}</option>
            <option :value="location" v-for="location in Object.keys(menus)" :key="location">
              {{ trim(location) }}
            </option>
          </select>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn btn-primary w-full"
            :processing="form.processing"
            :btn-text="trans('Create')"
          />
        </div>
      </div>
    </form>
  </div>

  <div id="editMenuDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateMenu">
      <div class="drawer-header">
        <h5>{{ trans('Edit Menu') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <i data-feather="x" width="1.5rem" height="1.5rem"></i>
        </button>
      </div>
      <div class="drawer-body space-y-3">
        <div>
          <label class="label label-required">{{ trans('Menu Name') }}</label>
          <input
            v-model="edit.heading"
            type="text"
            name="heading"
            class="input"
            required
            placeholder="Heading"
          />
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-between gap-2">
          <button type="button" class="btn btn-secondary w-full" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn btn-primary w-full"
            :processing="edit.processing"
            :btn-text="trans('Save Changes')"
          />
        </div>
      </div>
    </form>
  </div>
</template>
