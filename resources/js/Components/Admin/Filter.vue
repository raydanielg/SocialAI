<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps([
  'request',
  'hidden',
  'title',
  'action',
  'buttons',
  'filterType',
  'options'
])

const filterForm = useForm({
  search: props?.request?.search ?? '',
  type: props?.request?.type ?? 'email',
  action: props.action ?? null
})

const filter = () => {
  let route = filterForm.action || location.href
  filterForm.get(route)
}
</script>

<template>
  <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
    <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
      {{ props.title ?? '' }}
    </div>

    <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
      <template v-if="props.buttons?.length != 0">
        <div class="flex flex-wrap gap-1">
          <template v-for="button in buttons" :key="button.index">
            <button
              v-if="button.as == 'button'"
              type="button"
              @click="(e) => e.preventDefault()"
              data-toggle="modal"
              :data-target="button.target"
              class="btn btn-primary btn-sm"
            >
              <div v-html="sanitizeHtml(button.name)"></div>
            </button>

            <a
              v-else-if="button.as == 'a'"
              :href="button.url"
              :download="button.download ? 'true' : 'false'"
              v-html="sanitizeHtml(button.name)"
              class="btn btn-primary btn-sm"
            >
            </a>

            <Link
              v-else-if="button.as != 'button' || button.as != 'a'"
              :href="button.url"
              class="btn btn-primary btn-sm"
              v-html="sanitizeHtml(button.name)"
            >
            </Link>
          </template>
        </div>
      </template>

      <div class="dropdown" data-placement="bottom-end" v-if="props.hidden != 'filter'">
        <div class="dropdown-toggle">
          <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
            <Icon icon="fe:filter" />
            <span>{{ trans('Filter') }}</span>
            <Icon icon="bx:chevron-down" />
          </button>
        </div>

        <div class="dropdown-content w-72 !overflow-visible">
          <form @submit.prevent="filter">
            <ul class="dropdown-list space-y-4 p-4">
              <li class="dropdown-list-item">
                <h2 class="my-1 text-sm font-medium">{{ trans('Status') }}</h2>
                <div class="mb-2">
                  <input
                    type="text"
                    name="search"
                    v-model="filterForm.search"
                    class="input"
                    placeholder="Search......"
                  />
                </div>
              </li>
              <li class="dropdown-list-item" v-if="props.hidden?.type != 'type'">
                <div class="mb-2">
                  <select class="select" name="type" v-model="filterForm.type">
                    <option value="email">{{ trans('User Email') }}</option>

                    <option
                      value="name"
                      v-if="props.filterType != 'support' && props.filterType != 'notification'"
                    >
                      {{ trans('Name') }}
                    </option>

                    <option value="ticket_no" v-if="props.filterType == 'support'">
                      {{ trans('Ticket No') }}
                    </option>

                    <option value="subject" v-if="props.filterType == 'support'">
                      {{ trans('Subject') }}
                    </option>

                    <option value="title" v-if="props.filterType == 'notification'">
                      {{ trans('Title') }}
                    </option>
                  </select>
                </div>
              </li>

              <li class="dropdown-list-item">
                <button class="btn btn-primary w-full">
                  {{ trans('Filter') }}
                </button>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
