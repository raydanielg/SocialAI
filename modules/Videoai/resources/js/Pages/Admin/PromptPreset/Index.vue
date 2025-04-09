<script setup>
import moment from 'moment'
import trans from '@root/Composables/transComposable'
import AdminLayout from '@root/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@root/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@root/Composables/sharedComposable'
import NoDataFound from '@root/Components/Admin/NoDataFound.vue'

const { deleteRow, textExcerpt, badgeClass } = sharedComposable()
defineOptions({ layout: AdminLayout })

const props = defineProps(['promptPresets'])
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">
      <div class="card">
        <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
            <thead>
              <tr>
                <th>{{ trans('Title') }}</th>
                <th>{{ trans('User') }}</th>
                <th>{{ trans('Prompt') }}</th>
                <th>{{ trans('Description') }}</th>
                <th>{{ trans('Date') }}</th>
                <th>{{ trans('Status') }}</th>
                <th>
                  <p class="text-right">{{ trans('Action') }}</p>
                </th>
              </tr>
            </thead>
            <tbody v-if="promptPresets.total">
              <tr v-for="template in promptPresets.data" :key="template.id">
                <td>
                  {{ template.title }}
                </td>
                <td>
                  <a
                    v-if="template.user"
                    :href="route('admin.users.show', template.user_id)"
                    class="text-primary-500 hover:underline"
                  >
                    {{ template.user.name }}
                  </a>
                  <span v-else>N/A</span>
                </td>
                <td class="capitalize">
                  {{ textExcerpt(template.prompt, 50) }}
                </td>

                <td>
                  {{ template?.description ? textExcerpt(template.description, 50) : 'N/A' }}
                </td>
                <td>
                  {{ moment(template.created_at).format('D MMM, Y') }}
                </td>
                <td>
                  <span :class="badgeClass(template.status)">
                    {{ template.status }}
                  </span>
                </td>

                <td>
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                    </div>
                    <div class="dropdown-content w-40">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <Link
                            :href="route('admin.videoai.prompt-preset.edit', template)"
                            class="dropdown-link"
                          >
                            <Icon icon="fe:edit" />
                            <span>{{ trans('Edit') }}</span>
                          </Link>
                        </li>
                        <li class="dropdown-list-item">
                          <button
                            @click="
                              deleteRow(route('admin.videoai.prompt-preset.destroy', template))
                            "
                            class="dropdown-link"
                          >
                            <Icon icon="fe:trash" />
                            <span>{{ trans('Delete') }}</span>
                          </button>
                        </li>
                      </ul>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
            <NoDataFound v-else :for-table="true" />
          </table>
        </div>
      </div>
    </div>
  </main>
</template>
