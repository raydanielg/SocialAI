<script setup>
import moment from "moment"

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import sharedComposable from "@/Composables/sharedComposable"
import OverviewGrid from "@/Components/Admin/OverviewGrid.vue"
import NoDataFound from "@/Components/Admin/NoDataFound.vue"
import trans from "@/Composables/transComposable"
const { deleteRow, textExcerpt } = sharedComposable()
defineOptions({ layout: AdminLayout })

const props = defineProps([
  "prompts",
  "totalPrompts",
  "activePrompts",
  "inActivePrompts",
  "buttons",
  "segments",
])

const stats = [
  {
    value: props.totalPrompts,
    title: trans("Total Prompts"),
    iconClass: "bx:bar-chart",
  },
  {
    value: props.activePrompts,
    title: trans("Active Prompts"),
    iconClass: "bx:check-circle",
  },
  {
    value: props.inActivePrompts,
    title: trans("Inactive Prompts"),
    iconClass: "bx:x-circle",
  },
]
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Prompts" :buttons="buttons" />

    <div class="space-y-6">
      <OverviewGrid :items="stats" grid="3" />

      <div class="card">
        <div class="table-responsive whitespace-nowrap rounded-primary">
          <table class="table">
            <thead>
              <tr>
                <th class="col-3">{{ trans("Title") }}</th>
                <th class="col-1">{{ trans("Prompt") }}</th>
                <th class="col-2">{{ trans("Status") }}</th>
                <th class="col-2">{{ trans("Created At") }}</th>
                <th class="col-2">
                  <p class="text-right">{{ trans("Action") }}</p>
                </th>
              </tr>
            </thead>
            <tbody v-if="prompts.total">
              <tr v-for="prompt in prompts.data" :key="prompt.id">
                <td class="text-left">
                  {{ prompt.title }}
                </td>

                <td class="text-left">
                  {{ textExcerpt(prompt.prompt, 70) }}
                </td>

                <td class="text-left">
                  <span class="badge" :class="prompt.status == 'active'
                    ? 'badge-success'
                    : 'badge-danger'
                    ">
                    {{
                      prompt.status == "active"
                        ? trans("Active")
                        : trans("Draft")
                    }}
                  </span>
                </td>
                <td>
                  {{ moment(prompt.created_at).format("D-MMM-Y") }}
                </td>
                <td>
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                    </div>
                    <div class="dropdown-content w-40">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <Link :href="route('admin.prompts.edit', prompt.id)" class="dropdown-link">
                          <Icon icon="fe:edit" />
                          <span>{{ trans("Edit") }}</span>
                          </Link>
                        </li>
                        <li class="dropdown-list-item">
                          <button @click="
                            deleteRow(
                              route('admin.prompts.destroy', prompt.id)
                            )
                            " class="dropdown-link">
                            <Icon icon="fe:trash" />
                            <span>{{ trans("Delete") }}</span>
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
