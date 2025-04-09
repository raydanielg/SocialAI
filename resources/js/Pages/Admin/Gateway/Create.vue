<script setup>
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import { useForm } from "@inertiajs/vue3";

defineOptions({
  layout: AdminLayout,
})
const props = defineProps(["segments", "buttons"])

const form = useForm({
  name: null,
  logo: null,
  currency: null,
  min_amount: 1,
  max_amount: 10,
  charge: 0,
  multiply: 1,
  comment: null,
  status: 1,
  is_crypto: false,
})

const store = () => {
  form.post("/admin/gateways")
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader :title="trans('Create Payment Gateway')" :buttons="buttons" />
    <div class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="mt-5">
          <strong>{{ trans("Create Payment Gateway") }}</strong>
          <p>{{ trans("Create manual payment gateway for accepting payment") }}</p>
        </div>
        <div class="mt-5">
          <form @submit.prevent="store" enctype="multipart/form-data">
            <div class="card">
              <div class="card-body">
                <div class="mb-4">
                  <label class="required" for="name">{{ trans("Gateway Name") }}</label>
                  <input
                    v-model="form.name"
                    type="text"
                    class="input"
                    name="name"
                    id="name"
                  />

                  <div class="invalid-feedback" v-if="form.errors.name">
                    {{ form.errors.name }}
                  </div>
                </div>
                <div class="mb-4">
                  <label class="required" for="logo">{{ trans("Logo") }}</label>
                  <input
                    type="file"
                    id="logo"
                    @input="(e) => (form.logo = e.target.files[0])"
                    class="input"
                    name="logo"
                    accept="image/*"
                  />
                  <div class="invalid-feedback" v-if="form.errors.logo">
                    {{ form.errors.logo }}
                  </div>
                </div>
                <div class="mb-4">
                  <label class="required" for="currency">{{ trans("Currency") }}</label>
                  <input
                    v-model="form.currency"
                    type="text"
                    class="input"
                    name="currency"
                    id="currency"
                    required
                  />
                  <div class="invalid-feedback" v-if="form.errors.currency">
                    {{ form.errors.currency }}
                  </div>
                </div>

                <div class="mb-4">
                  <label class="required" for="min_amount">
                    {{ trans("Minimum Amount") }}</label
                  >
                  <input
                    v-model="form.min_amount"
                    type="number"
                    name="min_amount"
                    id="min_amount"
                    step="any"
                    class="input"
                    required
                  />
                  <div class="invalid-feedback" v-if="form.errors.min_amount">
                    {{ form.errors.min_amount }}
                  </div>
                </div>
                <div class="mb-4">
                  <label class="required" for="max_amount">
                    {{ trans("Maximum Amount") }}</label
                  >
                  <input
                    v-model="form.max_amount"
                    type="number"
                    name="max_amount"
                    id="max_amount"
                    step="any"
                    class="input"
                    required
                  />
                  <div class="invalid-feedback" v-if="form.errors.max_amount">
                    {{ form.errors.max_amount }}
                  </div>
                </div>
                <div class="mb-4">
                  <label class="required" for="charge">
                    {{ trans("Gateway Charge") }}</label
                  >
                  <input
                    type="number"
                    step="any"
                    v-model="form.charge"
                    class="input"
                    name="charge"
                    id="charge"
                    required
                  />
                  <div class="invalid-feedback" v-if="form.errors.charge">
                    {{ form.errors.charge }}
                  </div>
                </div>
                <div class="mb-4">
                  <label class="required" for="multiply">
                    {{ trans("Multiply from base currency") }}</label
                  >
                  <input
                    type="number"
                    step="any"
                    v-model="form.multiply"
                    class="input"
                    name="multiply"
                    id="multiply"
                    required
                  />
                  <div class="invalid-feedback" v-if="form.errors.multiply">
                    {{ form.errors.multiply }}
                  </div>
                </div>

                <div class="mb-4">
                  <label class="required" for="status">
                    {{ trans("Payment Instruction") }}</label
                  >
                  <textarea
                    v-model="form.comment"
                    class="input"
                    maxlength="1000"
                    name="comment"
                  ></textarea>
                  <div class="invalid-feedback" v-if="form.errors.comment">
                    {{ form.errors.comment }}
                  </div>
                </div>
               
                <div class="mb-4">
                  <label class="required" for="status">{{ trans("Status") }}</label>
                  <select
                    v-model="form.status"
                    class="input selectric"
                    name="status"
                    id="status"
                  >
                    <option value="1">{{ trans("Active") }}</option>
                    <option value="0">{{ trans("Deactivate") }}</option>
                  </select>
                  <div class="invalid-feedback" v-if="form.errors.status">
                    {{ form.errors.status }}
                  </div>
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
