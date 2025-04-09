<script setup>
import InputFieldError from "@/Components/InputFieldError.vue"
import { Head, useForm } from "@inertiajs/vue3"
import SpinnerBtn from "@/Components/Admin/SpinnerBtn.vue"
import AuthLayout from "@/Layouts/Auth/AuthLayout.vue"
import LeftBanner from "@/Pages/Auth/Partials/LeftBanner.vue"

defineOptions({ layout: AuthLayout })
const props = defineProps({
  status: {
    type: String,
  },
  authPages: Object,
})

const loginData = props.authPages?.login ?? {}

const form = useForm({
  email: "",
})

const submit = () => {
  form.post(route("password.email"))
}
</script>

<template>
  <Head title="Forgot Password" />
  <div class="signin-banner-area signin-banner-main-wrap d-flex align-items-center">
    <LeftBanner :data="loginData" />
    <div class="signin-banner-from d-flex justify-content-center align-items-center">
      <div class="signin-banner-from-wrap">
        <div class="signin-banner-title-box">
          <h4 class="signin-banner-from-title">{{ trans("Forget Password") }}</h4>
        </div>
        <p v-if="!status" class="mb-4 alert alert-primary">
          {{
            trans(
              "Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one."
            )
          }}
        </p>

        <p v-else class="mb-4 alert alert-success">
          {{ status }}
        </p>

        <form @submit.prevent="submit">
          <div class="mb-3 postbox__comment-input">
            <input
              type="email"
              v-model="form.email"
              autofocus
              autocomplete="email"
              class="inputText"
              :placeholder="trans('enter your email here')"
            />
            <span class="floating-label">{{ trans("Your Email") }}</span>
            <InputFieldError :message="form.errors.email" />
          </div>

          <div class="mt-2" v-if="!status">
            <SpinnerBtn
              class="signin-btn w-100"
              :processing="form.processing"
              btn-text="Email Password Reset Link"
            />
          </div>
        </form>

        <p class="mt-4">
          {{ trans("Have an account?") }}
          <Link :href="route('login')" class="fw-bold">{{ trans("Sign In") }}</Link>
        </p>
      </div>
    </div>
  </div>
</template>
