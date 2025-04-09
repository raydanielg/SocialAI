<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import moment from 'moment'
import { computed } from 'vue'

defineOptions({ layout: AdminLayout })
const props = defineProps(['job', 'buttons', 'segments'])
const meta = computed(() => props.job.user.meta)
const socials = computed(() => meta.value.social)
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Job details" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        <!-- Left Section Start  -->
        <section class="col-span-1 flex h-min w-full flex-col gap-6 lg:sticky lg:top-20">
          <div class="card">
            <div class="card-body flex flex-col gap-y-3">
              <div class="relative my-2 h-16 w-16">
                <img
                  :src="
                    job.user.avatar == null
                      ? `https://ui-avatars.com/api/?name=${job.user.name}`
                      : `${job.user.avatar}`
                  "
                  alt=" avatar-img"
                  class="h-full w-full rounded-full"
                />
              </div>
              <div>
                <Link
                  :href="route('admin.users.show', job.user_id)"
                  class="mb-1 block font-medium text-slate-700 dark:text-slate-200"
                >
                  {{ job.user.name }}
                </Link>
                <span class="description">{{ trans('Status') }}: </span>
                <span
                  class="badge badge-sm"
                  :class="job.status == 1 ? 'badge-success' : 'badge-danger'"
                >
                  {{ job.status == 1 ? trans('Active') : trans('Inactive') }}
                </span>
              </div>
              <div>
                <h5>{{ trans('Overview') }}</h5>
                <div>{{ job.user.meta.business.description }}</div>
              </div>
              <div>
                {{ trans('Join Date: ') }}
                {{ job.user.created_at_date }}
              </div>
              <div>
                <h5>{{ trans('Socials') }}</h5>
                <ul class="flex flex-wrap gap-x-4">
                  <li class="capitalize" v-for="(social, key) in socials" :key="key">
                    <a
                      v-if="social"
                      :href="social.startsWith('http') ? social : `https://${social}`"
                      target="_blank"
                      class="hover:underline"
                    >
                      <span>{{ key }}</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
        <!-- Right Section Start  -->
        <section class="col-span-3">
          <div class="flex h-full flex-wrap gap-4">
            <div class="flex-grow">
              <div class="card h-full">
                <div class="card-body space-y-4">
                  <h4 class="font-bold">{{ trans('Details') }}</h4>

                  <div>
                    <h6>{{ trans('Overview') }}</h6>
                    <div v-html="sanitizeHtml(job.short_description)" class="mt-px"></div>
                  </div>
                  <div>
                    <h6>{{ trans('Description') }}</h6>
                    <div v-html="sanitizeHtml(job.description)" class="mt-px"></div>
                  </div>
                  <div>
                    <h6>{{ trans('Required Skills') }}</h6>
                    <ul class="ml-5">
                      <li v-for="tag in job.tags" :key="tag.id" class="list-disc">
                        {{ tag.title }}
                      </li>
                    </ul>
                  </div>
                  <div>
                    <span class="font-semibold">{{ trans('Service') }}</span>
                    <div>
                      {{ job.service?.title }}
                    </div>
                  </div>
                  <div>
                    <h6>{{ trans('Categories') }}</h6>
                    <ul class="ml-5">
                      <li v-for="cat in job.categories" :key="cat.id" class="list-disc">
                        {{ cat.title }}
                      </li>
                    </ul>
                  </div>
                  <div class="grid grid-cols-4 gap-y-6">
                    <div>
                      <span class="font-semibold">{{ trans('Salary') }}</span>
                      <div>
                        {{ job.salary_range }}/{{ job.salary_type.charAt(0).toLowerCase() }}
                      </div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Expertise') }}</span>
                      <div>
                        {{ job.expertise }}
                      </div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Location') }}</span>
                      <div v-if="JSON.parse(job.meta).is_remote">{{ trans('Remote') }}</div>
                      <div v-else>{{ job.country?.[0]?.name }},{{ job.state[0]?.name }}</div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Job Type') }}</span>
                      <div>{{ job.type }}</div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Date') }}</span>
                      <div>
                        {{ moment(job.updated_at).format('D MMM, YYYY') }}
                      </div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Experience') }}</span>
                      <div>
                        {{ job.experience }}
                      </div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Apply Type') }}</span>
                      <div>
                        {{
                          job.apply_type == 1
                            ? 'Email'
                            : job.apply_type == 2
                            ? 'External'
                            : 'Default'
                        }}
                      </div>
                    </div>
                    <div>
                      <span class="font-semibold">{{ trans('Expired Date') }}</span>
                      <div>
                        {{ job.expired_at ? moment(job.expired_at).format('D MMM, YYYY') : 'None' }}
                      </div>
                    </div>
                  </div>
                  <div>
                    <h6>{{ trans('Custom fields') }}</h6>
                    <div class="mt-1 grid grid-cols-3" v-if="JSON.parse(job.fields)?.length > 0">
                      <div v-for="(field, i) in JSON.parse(job.fields)" :key="i">
                        <span>{{ trans('Label') }}: {{ field.label }}</span> <br />
                        <span>{{ trans('Type') }}: {{ field.type }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>
</template>
