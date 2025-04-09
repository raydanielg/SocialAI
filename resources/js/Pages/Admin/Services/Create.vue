<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import { useForm } from '@inertiajs/vue3'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import RichEditor from '@/Components/Admin/RichEditor.vue'
import notify from '@/Composables/toastComposable'
import InputFieldError from '@/Components/InputFieldError.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps(['buttons', 'categories'])

const form = useForm({
  category_id: '',
  title: '',
  slug: '',
  icon: '',
  preview: '',
  overview: '',
  faqs: [
    {
      question: '',
      answer: ''
    }
  ],
  is_active: true,
  is_featured: false,

  // seo
  seo: {
    title: '',
    image: '',
    description: '',
    tags: ''
  }
})

const submit = () => {
  form.post(route('admin.services.store'), {
    onSuccess: () => {
      notify.success(trans('Added Successfully'))
      form.reset()
    }
  })
}

const addFaq = () => {
  form.faqs.push({
    question: '',
    answer: ''
  })
}

const removeFaq = (index) => {
  form.faqs.splice(index, 1)
}
</script>

<template>
  <main class="container p-4 sm:p-6">
    <PageHeader title="Create Service" :buttons="buttons" />
    <div class="card mx-auto w-[800px]">
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="mb-2">
            <label for="">{{ trans('Category') }}</label>
            <select v-model="form.category_id" class="select">
              <option value="">{{ trans('Select') }}</option>
              <option v-for="category in categories" :value="category.id" :key="category.id">
                {{ category.title }}
              </option>
            </select>
            <InputFieldError :message="form.errors.category_id" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Title') }}</label>
            <input type="text" v-model="form.title" class="input" />
            <InputFieldError :message="form.errors.title" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Icon') }}</label>
            <input type="file" @change="(e) => (form.icon = e.target.files[0])" class="input" />
            <InputFieldError :message="form.errors.icon" />
          </div>

          <div class="mb-2">
            <label class="label mb-2">{{ trans('Preview') }}</label>
            <input type="file" @change="(e) => (form.preview = e.target.files[0])" class="input" />
            <InputFieldError :message="form.errors.preview" />
          </div>

          <div class="mb-2 mt-3">
            <label>{{ trans('Overview') }}</label>
            <cke tag-name="textarea" :editor="ClassicEditor" v-model="form.overview" />
            <RichEditor v-model="form.overview" />
            <InputFieldError :message="form.errors.overview" />
          </div>

          <div class="mt-10 flex items-center justify-between">
            <h4>{{ trans("Faq's") }}</h4>
            <button type="button" class="btn btn-primary" @click="addFaq()">+</button>
          </div>

          <div v-for="(item, index) in form.faqs" :key="index">
            <div class="mt-2 flex items-center gap-2">
              <input type="text" v-model="item.question" class="input" placeholder="question" />
              <input type="text" v-model="item.answer" class="input" placeholder="answer" />
              <button type="button" class="btn btn-danger" @click="removeFaq(index)">x</button>
            </div>
            <InputFieldError :message="form.errors['faqs.' + index + '.question']" />
            <InputFieldError :message="form.errors['faqs.' + index + '.answer']" />
          </div>

          <h6 class="mb-2 mt-10">{{ trans('SEO Settings') }}</h6>
          <div class="mb-2">
            <label>{{ trans('SEO Meta Title') }}</label>
            <input v-model="form.seo.title" type="text" class="input" />
            <InputFieldError :message="form.errors['seo.title']" />
          </div>

          <div class="mb-2">
            <label>{{ trans('SEO Meta Image') }}</label>
            <input
              @change="($event) => (form.seo.image = $event.target.files[0])"
              type="file"
              class="input"
              accept="image/*"
            />
            <InputFieldError :message="form.errors['seo.image']" />
          </div>
          <div class="mb-2 mt-2">
            <label>{{ trans('SEO Meta Description') }}</label>
            <textarea v-model="form.seo.description" class="input h-100"></textarea>
            <InputFieldError :message="form.errors['seo.description']" />
          </div>
          <div class="mb-2 mt-2">
            <label>{{ trans('SEO Meta Tags') }}</label>
            <input v-model="form.seo.tags" type="text" class="input" />
            <InputFieldError :message="form.errors['seo.tags']" />
          </div>

          <div class="mb-2 mt-3">
            <div>
              <label for="toggle-status" class="toggle toggle-sm">
                <input
                  v-model="form.is_active"
                  class="toggle-input peer sr-only"
                  id="toggle-status"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Is Active?') }}</span>
              </label>
            </div>
          </div>

          <div class="mb-2 mt-3">
            <div>
              <label for="toggle-featured-status" class="toggle toggle-sm">
                <input
                  v-model="form.is_featured"
                  class="toggle-input peer sr-only"
                  id="toggle-featured-status"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md">{{ trans('Is Featured?') }}</span>
              </label>
            </div>
          </div>

          <div class="mb-2">
            <SpinnerBtn
              classes="btn btn-primary"
              :processing="form.processing"
              :btn-text="trans('Create')"
            />
          </div>
        </form>
      </div>
    </div>
  </main>
</template>
