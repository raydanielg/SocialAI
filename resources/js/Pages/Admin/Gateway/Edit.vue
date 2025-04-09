<script setup>
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue";
import toast from "@/Composables/toastComposable";
import trans from "@/Composables/transComposable";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import { useForm } from "@inertiajs/vue3";

import CoingateInstructions from "./Partials/CoingateInstructions.vue";

defineOptions({ layout: AdminLayout })

const props = defineProps(["segments", "buttons", "gateway", "credentials"])
const form = useForm({
  _method: "Patch",
  name: props.gateway.name,
  logo: "",
  currency: props.gateway.currency,
  test_mode: props.gateway.test_mode,
  min_amount: props.gateway.min_amount,
  max_amount: props.gateway.max_amount,
  charge: props.gateway.charge,
  multiply: props.gateway.multiply,
  credentials: props.credentials ?? [],
  comment: props.gateway.comment,
  log_enabled: props.gateway.log_enabled,
  status: props.gateway.status,
  is_crypto: props.gateway.is_crypto === 1 ? true : false,
})

function ucwords(word) {
  return word.charAt(0).toUpperCase() + word.slice(1)
}

function str_replace(search, replace, subject) {
  return subject.replaceAll(search, replace)
}

function updateGateway() {
  form.post(route("admin.gateways.update", props.gateway.id), {
    onSuccess: () => {
      toast.success("Gateway has been updated successfully")
    },
  })
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Edit Payment Gateway')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="mt-5">
          <strong>{{ trans("Edit Payment Gateway") }}</strong>
          <p>{{ trans("Edit gateway information for accepting payment") }}</p>
          <CoingateInstructions v-if="gateway.name == 'Coingate'" />
        </div>
        <div class="mt-5">
          <form @submit.prevent="updateGateway">
            <div class="card">
              <div class="card-body">
                <div class="mb-4">
                  <label class="" for="name">{{ trans("Gateway Name") }}</label>
                  <input
                    type="text"
                    class="input"
                    name="name"
                    id="name"
                    v-model="form.name"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label class="" for="logo">{{ trans("Logo") }}</label>
                  <div class="flex-1">
                    <input
                      type="file"
                      id="logo"
                      class="input mb-3"
                      name="logo"
                      @input="(e) => (form.logo = e.target.files[0])"
                    />

                    <div class="flex justify-start">
                      <img
                        v-if="gateway.logo != ''"
                        :src="gateway.logo"
                        height="10"
                        width="30"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
                <div class="mb-4">
                  <label class="" for="currency">{{ trans("Currency") }}</label>
                  <input
                    type="text"
                    class="input"
                    name="currency"
                    id="currency"
                    v-model="form.currency"
                    required
                  />
                </div>

                <div class="mb-4" v-if="gateway.is_auto == 1">
                  <label class="" for="sandbox">{{ trans("Sandbox Mode") }}</label>
                  <select
                    class="select flex-1"
                    name="test_mode"
                    id="sandbox"
                    v-model="form.test_mode"
                  >
                    <option value="1">{{ trans("Enable") }}</option>
                    <option value="0">{{ trans("Disable") }}</option>
                  </select>
                </div>

                <div class="mb-4" v-if="gateway.name == 'Coingate'">
                  <label>{{ trans("Enable Logging") }}</label>
                  <select class="select flex-1" v-model="form.log_enabled">
                    <option value="1">{{ trans("Enable") }}</option>
                    <option value="0">{{ trans("Disable") }}</option>
                  </select>
                </div>

                <div class="mb-4">
                  <label class="" for="min_amount">{{ trans("Minimum Amount") }}</label>
                  <input
                    type="number"
                    name="min_amount"
                    id="min_amount"
                    step="any"
                    v-model="form.min_amount"
                    class="input"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label class="" for="max_amount">{{ trans("Maximum Amount") }}</label>
                  <input
                    type="number"
                    name="max_amount"
                    id="max_amount"
                    step="any"
                    v-model="form.max_amount"
                    class="input"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label class="" for="charge">{{ trans("Charge") }}</label>
                  <input
                    type="text"
                    class="input"
                    name="charge"
                    id="charge"
                    v-model="form.charge"
                    required
                  />
                </div>
                <div class="mb-4">
                  <label class="" for="multiply">{{
                    trans("Multiply from base currency")
                  }}</label>
                  <input
                    type="number"
                    step="any"
                    class="input"
                    v-model="form.multiply"
                    required
                  />
                </div>

                <template v-if="gateway.is_auto == 1">
                  <div
                    class="mb-4"
                    v-for="(credential, key) in form.credentials"
                    :key="credential"
                  >
                    <label class="" for="status">{{
                      ucwords(str_replace("_", " ", key))
                    }}</label>
                    <input
                      type="text"
                      class="input"
                      v-model="form.credentials[key]"
                      required
                    />
                  </div>
                </template>

                <div class="mb-4">
                  <label class="required block" for="status">{{
                    trans("Payment Instruction")
                  }}</label>
                  <textarea
                    class="textarea"
                    maxlength="1000"
                    name="comment"
                    v-model="form.comment"
                  ></textarea>
                </div>

                <div class="mb-4">
                  <label class="" for="status">{{ trans("Status") }}</label>
                  <select
                    class="select flex-1"
                    name="status"
                    id="status"
                    v-model="form.status"
                  >
                    <option value="1">{{ trans("Active") }}</option>
                    <option value="0">{{ trans("Deactivate") }}</option>
                  </select>
                </div>
                <div class="mb-4">
                  <SpinnerBtn :processing="form.processing" />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>
