<template>
  <main class="container p-4 sm:p-6">
    <PageHeader :title="trans('Admin Roles')"  :buttons="buttons" />
    <div class="space-y-6">
      <div class="table-responsive rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th width="10%">{{ trans("Name") }}</th>
              <th width="80%">{{ trans("Permissions") }}</th>
              <th width="10%" class="text-right">
                {{ trans("Action") }}
              </th>
            </tr>
          </thead>
          <tbody v-if="roles.length">
            <tr v-for="role in roles" :key="role.id">
              <td>
                {{ role.name }}
              </td>
              <td>
                <span class="mb-2 mr-1 badge badge-primary" v-for="perm in role.permissions" :key="perm.name">
                  {{ perm.name }}
                </span>
              </td>
              <td>
                <div class="hover">
                  <a href="javascript:void(0)" @click="
                    deleteRow(route('admin.role.destroy', role.id))
                    " class="btn btn-danger">{{ trans("Delete") }}</a>
                </div>
              </td>
            </tr>
          </tbody>
          <NoDataFound v-else :for-table="true" />
        </table>
      </div>
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import sharedComposable from "@/Composables/sharedComposable"
import NoDataFound from "@/Components/Admin/NoDataFound.vue";

const props = defineProps(['segments', 'buttons', 'roles'])

defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()

</script>@/Composables/sharedComposable