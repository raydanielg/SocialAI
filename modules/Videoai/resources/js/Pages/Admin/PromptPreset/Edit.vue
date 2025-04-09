<script setup>
import SpinnerBtn from '@root/Components/Admin/SpinnerBtn.vue'
import InputFieldError from '@root/Components/InputFieldError.vue'
import sharedComposable from '@root/Composables/sharedComposable'
import AdminLayout from '@root/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@root/Layouts/Admin/PageHeader.vue'
import toast from '@root/Composables/toastComposable'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  promptPreset: {
    type: Object,
    required: true
  }
})

const { trim } = sharedComposable()

const form = useForm({
  title: props.promptPreset.title || '',
  description: props.promptPreset.description || '',
  icon: props.promptPreset.icon || '',
  status: props.promptPreset.status || '',
  prompt: props.promptPreset.prompt || '',
  meta: props.promptPreset.meta || {},
  _method: 'PUT'
})

const submit = () => {
  form.post(route('admin.videoai.prompt-preset.update', props.promptPreset.id), {
    onSuccess: () => {
      toast.success(trans('Prompt Preset updated successfully'))
    }
  })
}

</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader />

    <div class="mx-auto lg:w-9/12">
      <h3 class="card-title mb-2">{{ trans('Edit Prompt Preset') }}</h3>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="card card-body">
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Title') }}</label>
            <input type="text" v-model="form.title" class="input" />
            <InputFieldError :message="form.errors.title" />
          </div>
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Description') }}</label>
            <textarea v-model="form.description" class="textarea"></textarea>
            <InputFieldError :message="form.errors.description" />
          </div>
        </div>

        <div class="card card-body">
          <div class="mb-2">
            <label class="label mb-1">{{ trans('Custom Prompt') }}</label>
            <textarea v-model="form.prompt" ref="bodyEl" class="textarea"></textarea>
            <InputFieldError :message="form.errors.prompt" />
            <small class="text-yellow-400">
              * {{ trans('Use') }} <code>[]</code>
              {{ trans('for subject or action replacement. Example:') }}
              <code>{{ trans('A [subject] walking in the [action]') }}</code>
            </small>
          </div>
          <div class="flex items-end justify-between">
            <div class="w-80">
              <label for="toggle-featured" class="toggle toggle-sm">
                <input
                  v-model="form.status"
                  true-value="active"
                  false-value="inactive"
                  class="toggle-input peer sr-only"
                  id="toggle-featured"
                  type="checkbox"
                />
                <div class="toggle-body"></div>
                <span class="label label-md capitalize">{{ form.status }}</span>
              </label>
              <InputFieldError :message="form.errors.status" />
            </div>
            <div class="flex flex-col justify-end">
              <SpinnerBtn :processing="form.processing" :btn-text="trans('Update')" />
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>
</template>
