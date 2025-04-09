<template>
  <main class="container p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="table-responsive whitespace-nowrap rounded-primary">
        <table class="table">
          <thead>
            <tr>
              <th>{{ trans('Name') }}</th>
              <th>{{ trans('Email') }}</th>
              <th>{{ trans('Status') }}</th>
              <th>{{ trans('Role') }}</th>
              <th class="!text-right">{{ trans('Action') }}</th>
            </tr>
          </thead>
          <tbody v-if="users.length">
            <tr v-for="row in users" :key="row.id">
              <td>
                {{ row.name }}
              </td>
              <td>
                {{ row.email }}
              </td>
              <td>
                <span :class="row.status == 1 ? 'badge badge-success' : 'badge badge-danger'">
                  {{ row.status == 1 ? trans('Active') : trans('Deactive') }}
                </span>
              </td>
              <td>
                <span class="badge badge-primary" v-for="r in row.roles" :key="r">{{
                  r.name
                  }}</span>
              </td>
              <td class="flex justify-end gap-3">
                <Link :href="route('admin.admin.edit', row.id)" class="btn btn-primary btn-sm">
                {{ trans('Edit') }}</Link>
                <button type="button" @click="deleteRow(route('admin.admin.destroy', row.id))"
                  class="btn btn-danger btn-sm">
                  {{ trans('Delete') }}
                </button>
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
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'
const props = defineProps(['users'])
defineOptions({ layout: AdminLayout })
const { deleteRow } = sharedComposable()
</script>
