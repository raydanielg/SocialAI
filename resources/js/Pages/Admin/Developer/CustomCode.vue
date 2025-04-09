<template>
    <main class="container p-4 sm:p-6">
      <PageHeader :title="trans('Application Settings')" :buttons="buttons" />
      <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12">
          <div class="lg:col-span-5">
            <strong>{{ trans('Custom Header Footer Code') }}</strong>
            <p>{{ trans('Edit you application global settings') }}</p>
          </div>
          <div class="lg:col-span-7">
            <form @submit.prevent="update">
              <div class="card">
                <div class="card-body">
                  <div class="mb-2">
                    <label class="label">{{ trans('Custom Header Code') }}</label>
                    <textarea                   
                      v-model="form.custom_header"
                      class="input"
                    ></textarea>
                  </div>
                  <div class="mb-2">
                    <label class="label">{{ trans('Custom Footer Code') }}</label>
                    <textarea                   
                      v-model="form.custom_footer"
                      class="input"
                    ></textarea>
                  </div>
  
                
                  <div class="mt-3">
                    <SpinnerBtn :processing="form.processing" :btn-text="trans('Save Changes')" />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </template>
  
  <script setup>
  import PageHeader from '@/Layouts/Admin/PageHeader.vue'
  import { useForm } from '@inertiajs/vue3'
  import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
  import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
  import notify from '@/Composables/toastComposable'
  
  defineOptions({ layout: AdminLayout })
  const props = defineProps([
    'segments',
    'buttons',
    'id',
    'custom_header',
    'custom_footer',
   
  ])
  
  const form = useForm({
    custom_header: props.custom_header,
    custom_footer: props.custom_footer
  })
  
  function update() {
    const url = route('admin.developer-settings.update', props.id)
    form.put(url, {
      onSuccess: () => {
        notify.success(trans('Settings has been updated successfully'))
      }
    })
  }
  </script>
  