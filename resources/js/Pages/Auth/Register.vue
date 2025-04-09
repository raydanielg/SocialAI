<script setup>
import { useForm } from '@inertiajs/vue3'

import InputFieldError from '@/Components/InputFieldError.vue'
import AuthLayout from '@/Layouts/Auth/AuthLayout.vue'
import notify from '@/Composables/toastComposable'
import SpinnerBtn from '@/Components/Admin/SpinnerBtn.vue'
import LeftBanner from '@/Pages/Auth/Partials/LeftBanner.vue'
import { ref } from 'vue'
const props = defineProps(['seo', 'authPages', 'googleClient', 'facebookClient', 'planId'])
const loginData = props.authPages?.login ?? {}

defineOptions({ layout: AuthLayout })

const form = useForm({
  plan_id: props.planId ?? null,
  name: '',
  email: '',
  password: ''
})
const showPassword = ref(false)
const submit = () => {
  form.post(route('register'), {
    onSuccess: () => {
      form.reset()
      notify.success(trans('Registration successful'))
    },
    onFinish: () => form.reset('password')
  })
}
</script>

<template>
  <!-- tp-banner-area-start -->
  <div class="signin-banner-area signin-banner-main-wrap d-flex align-items-center">
    <LeftBanner :data="loginData" />

    <div class="signin-banner-from d-flex justify-content-center align-items-center">
      <div class="signin-banner-from-wrap">
        <div class="signin-banner-title-box">
          <h4 class="signin-banner-from-title">{{ trans('Register Account') }}</h4>
        </div>
        <div class="d-flex flex-column flex-sm-row signin-banner-login-browser gap-3">
          <a
            class="d-flex align-items-center justify-content-center mb-md-0 flex-fill mb-2 gap-1 text-nowrap"
            href="/auth/google"
            v-if="googleClient"
          >
            <svg
              class="mr-10"
              width="23"
              height="23"
              viewBox="0 0 23 23"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M21.5642 11.7235C21.5642 10.8961 21.4957 10.2924 21.3474 9.66626H11.707V13.4005H17.3657C17.2517 14.3285 16.6356 15.7261 15.2665 16.6652L15.2473 16.7902L18.2954 19.1044L18.5066 19.125C20.4461 17.3696 21.5642 14.7869 21.5642 11.7235"
                fill="#4285F4"
              />
              <path
                d="M11.7039 21.5625C14.4761 21.5625 16.8035 20.668 18.5034 19.1251L15.2633 16.6653C14.3963 17.2579 13.2326 17.6716 11.7039 17.6716C8.98861 17.6716 6.68407 15.9163 5.86257 13.4901L5.74215 13.5001L2.5727 15.9039L2.53125 16.0168C4.21972 19.3039 7.68797 21.5625 11.7039 21.5625Z"
                fill="#34A853"
              />
              <path
                d="M5.86404 13.4901C5.64728 12.864 5.52183 12.1931 5.52183 11.5C5.52183 10.8067 5.64728 10.1359 5.85263 9.50984L5.84689 9.37649L2.63771 6.93405L2.53271 6.983C1.83681 8.34704 1.4375 9.87881 1.4375 11.5C1.4375 13.1212 1.83681 14.6528 2.53271 16.0169L5.86404 13.4901"
                fill="#FBBC05"
              />
              <path
                d="M11.7039 5.32831C13.632 5.32831 14.9325 6.14448 15.6741 6.82654L18.5719 4.05375C16.7922 2.43257 14.4762 1.4375 11.7039 1.4375C7.688 1.4375 4.21973 3.69595 2.53125 6.98301L5.85118 9.50985C6.6841 7.08367 8.98865 5.32831 11.7039 5.32831"
                fill="#EB4335"
              />
            </svg>
            <span class="d-none d-sm-block"> {{ trans('Login with') }}</span>
            <span> {{ trans('Google') }}</span>
          </a>
          <a
            class="d-flex align-items-center justify-content-center mb-md-0 flex-fill mb-2 gap-1"
            href="/auth/facebook"
            v-if="facebookClient"
          >
            <div class="h-100 d-flex align-items-center gap-1">
              <img src="/assets/images/fb-logo.webp" class="h-100 py-3" alt="" />
              {{ trans('Facebook') }}
            </div>
          </a>
        </div>
        <form @submit.prevent="submit">
          <div class="signin-banner-from-box">
            <h5 class="signin-banner-from-subtitle">
              {{ trans('Or Sign In with email') }}
            </h5>
            <div class="row">
              <div class="col-12">
                <div class="postbox__comment-input mb-3">
                  <input type="text" v-model="form.name" class="inputText" required />
                  <InputFieldError :message="form.errors.name" />
                  <span class="floating-label">{{ trans('Full Name') }}</span>
                </div>
              </div>
              <div class="col-12">
                <div class="postbox__comment-input mb-3">
                  <input type="email" v-model="form.email" class="inputText" required />
                  <InputFieldError :message="form.errors.email" />
                  <span class="floating-label">{{ trans('Your Email') }}</span>
                </div>
              </div>
              <div class="col-12">
                <div class="postbox__comment-input mb-3">
                  <input
                    id="myInput"
                    v-model="form.password"
                    required
                    class="inputText password"
                    :type="showPassword ? 'text' : 'password'"
                  />
                  <InputFieldError :message="form.errors.password" />
                  <span class="floating-label">{{ trans('Password') }}</span>
                  <button type="button" @click="showPassword = !showPassword" class="eye-btn">
                    <Icon
                      icon="material-symbols:visibility-rounded"
                      class="fs-5"
                      v-if="showPassword"
                    />
                    <Icon
                      icon="material-symbols:visibility-off-rounded"
                      class="fs-5"
                      v-if="!showPassword"
                    />
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="signin-banner-from-btn mb-20">
            <SpinnerBtn
              :processing="form.processing"
              :btn-text="trans('Register')"
              class="signin-btn w-100"
            />
          </div>
        </form>
        <div class="signin-banner-from-register mt-5">
          <Link href="/login"
            >{{ trans('Already have an account ?') }} <span>{{ trans('Sign In') }}</span></Link
          >
        </div>
      </div>
    </div>
  </div>
  <!-- tp-banner-area-end -->
</template>
