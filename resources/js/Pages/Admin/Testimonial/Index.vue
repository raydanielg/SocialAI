<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Testimonial" :buttons="buttons" />
    <div class="space-y-6">
      <table class="table">
        <thead>
          <tr>
            <th>{{ trans('Reviewer Name') }}</th>
            <th>{{ trans('Reviewer Position') }}</th>
            <th>{{ trans('Comment') }}</th>
            <th class="text-right">{{ trans('Ratings') }}</th>
            <th class="!text-right">{{ trans('Action') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts.data" :key="post.id">
            <td class="flex">
              <img :src="post.preview?.value" class="avatar rounded-square mr-3" />
              <span>
                {{ textExcerpt(post.title, 30) }}
              </span>
            </td>
            <td class="text-left">
              {{ textExcerpt(post.slug, 30) }}
            </td>
            <td class="text-left">
              {{ textExcerpt(post.excerpt?.value ?? '', 50) }}
            </td>
            <td class="text-right">{{ post.lang }} {{ trans('Star') }}</td>
            <td>
              <div class="dropdown" data-placement="bottom-start">
                <div class="dropdown-toggle">
                  <Icon class="text-2xl" icon="bx:dots-horizontal-rounded" />
                </div>
                <div class="dropdown-content w-40">
                  <ul class="dropdown-list">
                    <li class="dropdown-list-item">
                      <button @click="openEditTestimonialDrawer(post)" class="dropdown-link">
                        <Icon icon="fe:edit" />
                        <span>{{ trans('Edit') }}</span>
                      </button>
                    </li>

                    <li class="dropdown-list-item">
                      <button
                        class="dropdown-link"
                        @click="deleteRow('/admin/testimonials/' + post.id)"
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
      </table>

      <Paginate
        :links="posts.links"
        :currentPage="posts.current_page"
        :from="posts.from"
        :lastPage="posts.last_page"
        :lastPageUrl="posts.last_page_url"
        :nextpageurl="posts.next_page_url"
        :perPage="posts.per_page"
        :prevPageUrl="posts.prev_page_url"
        :to="posts.to"
        :total="posts.total"
      />
    </div>
  </main>

  <div id="addNewTestimonialDrawer" class="drawer drawer-right">
    <form @submit.prevent="storeTestimonial()">
      <div class="drawer-header">
        <h5>{{ trans('Add New Testimonial') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Reviewer Name') }}</label>
          <input
            v-model="form.reviewer_name"
            type="text"
            name="reviewer_name"
            maxlength="150"
            class="input"
            required
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Reviewer Position') }}</label>
          <input
            v-model="form.reviewer_position"
            type="text"
            name="reviewer_position"
            class="input"
            required
            placeholder="CEO of Google"
            maxlength="50"
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Reviewer Avatar') }}</label>
          <input
            @input="(e) => (form.reviewer_avatar = e.target.files[0])"
            type="file"
            name="reviewer_avatar"
            accept="image/*"
            class="input"
            required=""
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Review Star') }}</label>
          <select v-model="form.star" class="select" name="star">
            <option value="5">{{ trans('5 Star') }}</option>
            <option value="4">{{ trans('4 Star') }}</option>
            <option value="3">{{ trans('3 Star') }}</option>
            <option value="2">{{ trans('2 Star') }}</option>
            <option value="1">{{ trans('1 Star') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label>{{ trans('Comment') }}</label>
          <textarea
            v-model="form.comment"
            class="textarea h-100"
            maxlength="500"
            name="comment"
            required
          ></textarea>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn btn-primary"
            :processing="form.processing"
            :btn-text="trans('Create')"
          />
        </div>
      </div>
    </form>
  </div>

  <div id="editTestimonialDrawer" class="drawer drawer-right">
    <form @submit.prevent="updateTestimonial()">
      <div class="drawer-header">
        <h5>{{ trans('Edit Testimonial') }}</h5>
        <button
          type="button"
          class="btn btn-plain-secondary dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:bg-slate-700"
          data-dismiss="drawer"
        >
          <Icon class="text-xl" icon="mdi:close" />
        </button>
      </div>
      <div class="drawer-body">
        <div class="mb-2">
          <label>{{ trans('Reviewer Name') }}</label>
          <input
            v-model="editTestimonialForm.title"
            type="text"
            name="reviewer_name"
            id="reviewer_name"
            maxlength="150"
            class="input"
            required
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Reviewer Position') }}</label>
          <input
            v-model="editTestimonialForm.slug"
            type="text"
            name="reviewer_position"
            id="reviewer_position"
            class="input"
            required=""
            placeholder="CEO of Google"
            maxlength="50"
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Reviewer Avatar') }}</label>
          <input
            @input="(e) => (editTestimonialForm.preview.value = e.target.files[0])"
            type="file"
            name="reviewer_avatar"
            accept="image/*"
            class="input"
          />
        </div>
        <div class="mb-2">
          <label>{{ trans('Review Star') }}</label>
          <select v-model="editTestimonialForm.lang" class="select" name="star" id="star">
            <option value="5">{{ trans('5 Star') }}</option>
            <option value="4">{{ trans('4 Star') }}</option>
            <option value="3">{{ trans('3 Star') }}</option>
            <option value="2">{{ trans('2 Star') }}</option>
            <option value="1">{{ trans('1 Star') }}</option>
          </select>
        </div>
        <div class="mb-2">
          <label>{{ trans('Comment') }}</label>
          <textarea
            :value="editTestimonialForm?.excerpt?.value ?? ''"
            @input="(e) => (editTestimonialForm.excerpt.value = e.target.value)"
            class="textarea h-100"
            maxlength="500"
            name="comment"
            id="comment"
            required
          ></textarea>
        </div>
      </div>
      <div class="drawer-footer">
        <div class="flex justify-end gap-2">
          <button type="button" class="btn btn-secondary" data-dismiss="drawer">
            <span> {{ trans('Close') }}</span>
          </button>
          <SpinnerBtn
            classes="btn btn-primary"
            :processing="editTestimonialForm.processing"
            :btn-text="trans('Save Changes')"
          />
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

import Paginate from '@/Components/Admin/Paginate.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import sharedComposable from '@/Composables/sharedComposable'
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import drawer from '@/Plugins/Admin/drawer'
import notify from '@/Composables/toastComposable'
import { Link, router, useForm } from '@inertiajs/vue3'

defineOptions({ layout: AdminLayout })

const { textExcerpt, deleteRow } = sharedComposable()

onMounted(() => {
  drawer.init()
})

const props = defineProps(['posts', 'buttons', 'segments'])
const form = useForm({
  reviewer_name: '',
  reviewer_position: '',
  reviewer_avatar: '',
  star: 0,
  comment: ''
})

const editTestimonialForm = ref({})

function openEditTestimonialDrawer(testimonial) {
  editTestimonialForm.value = { ...testimonial }
  drawer.of('#editTestimonialDrawer').show()
}

const storeTestimonial = () => {
  form.post(route('admin.testimonials.store'), {
    onSuccess: () => {
      form.reset()
      notify.success(trans('Testimonial has been added successfully'))
      drawer.of('#addNewTestimonialDrawer').hide()
    }
  })
}

const updateTestimonial = () => {
  if (!(editTestimonialForm.value.preview.value instanceof File)) {
    editTestimonialForm.value.preview.value = null
  }

  router.post(
    route('admin.testimonials.update', editTestimonialForm.value.id),
    {
      _method: 'patch',
      testimonial: editTestimonialForm.value
    },
    {
      onSuccess: () => {
        notify.success('Testimonial Updated successfully')
        drawer.of('#editTestimonialDrawer').hide()
      }
    }
  )
}
</script>
@/Composables/sharedComposable
