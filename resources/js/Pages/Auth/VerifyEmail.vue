<script setup>
import { computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import LeftBanner from '@/Pages/Auth/Partials/LeftBanner.vue'
import AuthLayout from '@/Layouts/Auth/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

const props = defineProps({
  status: {
    type: String
  },
  authPages: Object
})
const loginData = props.authPages?.login ?? {}

const form = useForm({})

const submit = () => {
  form.post(route('verification.send'))
}
const verificationLinkSent = computed(() => props.status === 'verification-link-sent')
</script>

<template>
  <Head title="Email Verification" />
  <div class="signin-banner-area signin-banner-main-wrap d-flex align-items-center">
    <LeftBanner :data="loginData" />

    <div class="container px-5">
      <h3 class="mb-4">{{ trans('Email verification') }}</h3>
      <p class="alert alert-info" v-if="!verificationLinkSent">
        {{
          trans(
            `Thanks for signing up! Before getting started, could you verify your email address by clicking
                on the link we just emailed to you? If you didn't receive the email, we will gladly send you
                another.`
          )
        }}
      </p>
      <p class="alert alert-success" v-else>
        {{
          trans(`A new verification link has been sent to the email address you provided during
                registration.`)
        }}
      </p>

      <form @submit.prevent="submit" v-if="!verificationLinkSent">
        <div class="mb-2 text-center">
          <button type="submit" class="tp-btn-blue-lg">
            <svg
              v-if="form.processing"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              :width="props.size + 'px'"
              :height="props.size + 'px'"
              viewBox="0 0 100 100"
              preserveAspectRatio="xMidYMid"
            >
              <circle
                cx="50"
                cy="50"
                r="32"
                stroke-width="8"
                stroke="white"
                stroke-dasharray="50.26548245743669 50.26548245743669"
                fill="none"
                stroke-linecap="round"
              >
                <animateTransform
                  attributeName="transform"
                  type="rotate"
                  repeatCount="indefinite"
                  dur="1s"
                  keyTimes="0;1"
                  values="0 50 50;360 50 50"
                ></animateTransform>
              </circle>
            </svg>
            <span v-else>{{ trans('Resend Verification Email') }}</span>
          </button>
        </div>
      </form>
      <div class="mt-4 text-center">
        <Link class="tp-btn-orange" :href="route('logout')" method="post" as="button">
          {{ trans('Logout') }}
        </Link>
      </div>
    </div>
  </div>
</template>
