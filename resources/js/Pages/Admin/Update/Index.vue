<script setup>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue"
import PageHeader from "@/Layouts/Admin/PageHeader.vue"
import SpinnerBtn from "@/Components/SpinnerBtn.vue"
import { useForm } from "@inertiajs/vue3"
import { modal } from '@/Composables/actionModalComposable'
import trans from "@/Composables/transComposable"
import { onMounted, ref } from "vue"
defineOptions({ layout: AdminLayout })
const props = defineProps(["version", "purchaseKey", "updateData"])

const form = useForm({
  purchase_key: props.purchaseKey,
})

const updateForm = useForm({
  version: props.updateData?.version,
})

const submit = () => {
  form.post(route("admin.update.store"), {
    onError: (e) => {
      console.log(e)
    },
  })
}

const update = () => {
  if (updateForm.processing) return

  let newVersion = props.updateData?.version

  modal.init(route("admin.update.update", newVersion), {
    method: 'put',
    options: {
      confirm_text: trans('Are you sure you want to update to version v.' + newVersion + '?'),
      message: trans("Warning: You will not be able to revert this back once updated!"),
      accept_btn_text: trans('Yes, Update Now'),
      reject_btn_text: trans('No, Skip This Update')
    }
  })
}
</script>

<template>
  <main class="flex-grow p-4 sm:p-6">
    <PageHeader />
    <div class="space-y-6">

      <div class="alert alert-info" role="alert" v-show="updateData?.message">
        <i width="1rem" height="1rem" data-feather="alert-circle"></i>
        <p>
          <b>{{ trans("Note") }}:</b>
          {{ updateData?.message }}
        </p>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="flex justify-between">
            <h4 class="card-title">{{ trans("Site Update") }}</h4>
            <p>{{ trans("Current Version") }} {{ version }}</p>
          </div>
          <template v-if="updateData">
            <div class="flex items-center justify-between p-4 my-3 border rounded-lg">
              <p>{{ trans("Update Available") }}</p>
              <h6>
                {{ updateData.version }}
              </h6>
              <div>
                <form @submit.prevent="update">
                  <SpinnerBtn :processing="updateForm.processing" :btn-text="trans('Update Now')" />
                </form>
              </div>
            </div>
          </template>

          <!-- show if has not update data -->
          <form @submit.prevent="submit" v-else>
            <div class="mb-2">
              <label for="">{{ trans("Purchase Key") }}</label>
              <input type="text" class="input" :value="purchaseKey" disabled />
            </div>
            <div class="mb-2">
              <SpinnerBtn :processing="form.processing" :btn-text="trans('Check New Update')" />
            </div>
          </form>
        </div>
      </div>

      <div v-if="!updateData" class="alert alert-info" role="alert">
        <i width="1rem" height="1rem" data-feather="alert-circle"></i>
        <p>
          <b>{{ trans("Note") }}:</b>
          {{
            trans(
              "If you have customized the script from codebase do not use this option. you will lose your customization."
            )
          }}
        </p>
      </div>
    </div>
  </main>
</template>
