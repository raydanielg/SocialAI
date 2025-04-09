<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Edit Team Member" :buttons="buttons" />
    <div class="space-y-6">
      <form method="post" @submit.prevent="editTeam" enctype="multipart/form-data">
        <div class="grid grid-cols-12">
          <div class="col-span-5">
            <strong>{{ trans('Edit team member') }}</strong>
            <p>
              {{ trans('Edit your team member details and necessary information from here') }}
            </p>
          </div>
          <div class="col-span-7">
            <!-- Alerts -->
            <div class="card">
              <div class="card-body">
                <div class="mb-2">
                  <label>{{ trans('Member Name') }}</label>
                  <input
                    type="text"
                    name="member_name"
                    v-model="info.title"
                    required
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Member Position') }}</label>
                  <input
                    type="text"
                    name="member_position"
                    v-model="info.slug"
                    required
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Profile Picture') }}</label>
                  <input
                    @input="(e) => (info.preview.value = e.target.files[0])"
                    type="file"
                    accept="image/*"
                    name="profile_picture"
                    class="input"
                  />
                </div>

                <div class="mb-2">
                  <label>{{ trans('Profile Description') }}</label>
                  <textarea
                    class="textarea h-200"
                    name="about"
                    maxlength="1000"
                    required
                    v-model="info.description.value"
                  ></textarea>
                </div>
                <div class="mb-2">
                  <label>{{ trans('Facebook profile link') }}</label>
                  <input
                    type="url"
                    name="socials[facebook]"
                    v-model="socials.facebook"
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Twitter profile link') }}</label>
                  <input
                    type="url"
                    name="socials[twitter]"
                    v-model="socials.twitter"
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Linkedin profile link') }}</label>
                  <input
                    type="url"
                    name="socials[linkedin]"
                    v-model="socials.linkedin"
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label>{{ trans('Instagram profile link') }}</label>
                  <input
                    type="url"
                    name="socials[instagram]"
                    v-model="socials.instagram"
                    class="input"
                  />
                </div>
                <div class="mb-2">
                  <label for="toggle-status" class="toggle toggle-sm">
                    <input
                      v-model="info.status"
                      class="toggle-input peer sr-only"
                      id="toggle-status"
                      type="checkbox"
                    />
                    <div class="toggle-body"></div>
                    <span class="label label-md">{{ trans('Make it publish?') }}</span>
                  </label>
                </div>

                <div class="mt-2">
                  <SpinnerBtn :btn-text="trans('Save Changes')" :processing="isProcessing" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import notify from '@/Composables/toastComposable'
import { router } from '@inertiajs/vue3'

import { ref, onMounted } from 'vue'
defineOptions({ layout: AdminLayout })
const props = defineProps(['buttons', 'segments', 'info', 'socials'])
onMounted(() => {
  props.info.status = props.info.status == 1 ? true : false
})

const isProcessing = ref(false)

const editTeam = () => {
  if (!(props.info.preview.value instanceof File)) {
    props.info.preview.value = null
  }

  isProcessing.value = true
  router.post(
    route('admin.team.update', props.info.id),
    {
      _method: 'patch',
      team: props.info,
      socials: props.socials
    },
    {
      onSuccess: () => {
        isProcessing.value = false
        notify.success(trans('Team has been updated successfully'))
      }
    }
  )
}
</script>
