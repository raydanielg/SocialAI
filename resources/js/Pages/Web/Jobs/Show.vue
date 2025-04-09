<script setup>
import { ref } from "vue";

import SpinnerBtn from "@/Components/SpinnerBtn.vue";
import NiceSelect from "@/Components/Web/NiceSelect.vue";
import sharedComposable from "@/Composables/sharedComposable";
import DefaultLayout from "@/Layouts/Default/DefaultLayout.vue";
import { useForm } from "@inertiajs/vue3";

const { socialShare } = sharedComposable()
defineOptions({ layout: DefaultLayout })
const props = defineProps(['job', 'jobs'])
console.log(true)
const jobApplyFormShown = ref(false)

const form = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  linkedin_profile: '',
  website: '',
  experience: '',
  expected_salary: '',
  note: '',
  cv: ''
})

const submit = () => {
  form.post(route('jobs.application', props.job.slug), {
    onSuccess: () => {
      jobApplyFormShown.value = false
      form.reset()
    }
  })
}
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-height p-relative blue-bg-2">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="breadcrumb__content z-index-3">
            <h3 class="breadcrumb__title tp-char-animation">{{ job.title }}</h3>
            <div class="breadcrumb__list wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".4s">
              <span class="child-one"
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span class="child-one"
                ><Link href="/jobs">{{ trans('Jobs') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ job.title }}</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-md-end">
          <div class="breadcrumb__img p-relative z-index text-start">
            <img class="z-index-3" src="/assets/img/breadcrumb/breadcrumb-3.png" alt="" />
            <div
              class="breadcrumb__sub-img wow tpfadeUp"
              data-wow-duration=".9s"
              data-wow-delay=".4s"
            >
              <img src="/assets/img/breadcrumb/breadcrumb-sub-1.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <div class="career-details-area career-border-bottom pt-110 pb-110">
    <div class="container">
      <div class="row align-content-start">
        <div class="col-xl-7 col-lg-7">
          <div class="career-details-wrapper">
            <div class="career-details-title-box">
           
              <h4 class="career-details-title">{{ job.title }}</h4>
            </div>
            <div class="career-details-location-box">
              <span>
                <svg
                  width="15"
                  height="17"
                  viewBox="0 0 15 17"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M1 7.10747C1 3.73441 3.93813 1 7.5625 1C11.1869 1 14.125 3.73441 14.125 7.10747C14.125 10.4541 12.0305 14.3593 8.76256 15.7558C8.00076 16.0814 7.12424 16.0814 6.36244 15.7558C3.09452 14.3593 1 10.4541 1 7.10747Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                  />
                  <path
                    d="M9.4375 7.56274C9.4375 8.59828 8.59803 9.43774 7.5625 9.43774C6.52697 9.43774 5.6875 8.59828 5.6875 7.56274C5.6875 6.52721 6.52697 5.68774 7.5625 5.68774C8.59803 5.68774 9.4375 6.52721 9.4375 7.56274Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                  />
                </svg>
                {{ job.location }}
              </span>
              <span>
                <svg
                  width="17"
                  height="17"
                  viewBox="0 0 17 17"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8.5 15.75C12.5041 15.75 15.75 12.5041 15.75 8.5C15.75 4.49594 12.5041 1.25 8.5 1.25C4.49594 1.25 1.25 4.49594 1.25 8.5C1.25 12.5041 4.49594 15.75 8.5 15.75Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M8.5 5.52838V9.42838L11.1 10.7284"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                {{ job.type }}
              </span>
              <span>{{ job.expert_level }}</span>
            </div>
            <div class="career-details-job-responsiblity mb-45" v-html="sanitizeHtml(job.description)"></div>
          </div>
        </div>
        <div class="col-xl-5 col-lg-5 career-details-pin">
          <div class="col-xxl-12" v-if="!jobApplyFormShown">
            <div class="postbox__apply-btn-border">
              <div id="my-btn" class="postbox__apply-btn-box">
                <a
                  class="submit-btn mb-50 w-100"
                  href="javascript:void(0)"
                  @click="() => (jobApplyFormShown = true)"
                  >{{ trans('Apply For This Job') }}</a
                >
              </div>
            </div>
          </div>
          <div v-else class="career-details-hide-wrapper">
            <form @submit.prevent="submit">
              <div class="career-details-apply-info-box pb-10">
                <div class="career-details-profile-box pb-20">
                  <h4 class="career-details-title-xs">{{ trans('Profile') }}</h4>
                  <p>{{ trans('Basic information about you') }}</p>
                </div>
                <div class="postbox__comment-form">
                  <div class="box">
                    <div class="row gx-20">
                      <div class="col-12">
                        <div class="postbox__comment-input mb-30">
                          <input type="text" v-model="form.name" class="inputText" />
                          <span class="floating-label">{{ trans('Full Name') }}</span>
                          <p class="text-danger ms-3 mt-2">{{ form.errors.name }}</p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__comment-input mb-30">
                          <input type="email" v-model="form.email" class="inputText" />
                          <span class="floating-label">{{ trans('Your Email') }}</span>
                          <p class="text-danger ms-3 mt-2">{{ form.errors.email }}</p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__comment-input mb-30">
                          <input type="text" v-model="form.phone" class="inputText" />
                          <span class="floating-label">{{ trans('Phone') }}</span>
                          <p class="text-danger ms-3 mt-2">{{ form.errors.phone }}</p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__comment-input mb-35">
                          <input type="text" v-model="form.address" class="inputText" />
                          <span class="floating-label">{{ trans('Address') }}</span>
                          <p class="text-danger ms-3 mt-2">{{ form.errors.address }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="career-details-apply-info-box">
                <div class="career-details-profile-box pb-20">
                  <h4 class="career-details-title-xs">
                    {{ trans('Application Details') }}
                  </h4>
                  <p>{{ trans('Summarize your relevant experience') }}</p>
                </div>
                <div class="postbox__comment-form">
                  <div class="box">
                    <div class="row gx-20">
                      <div class="col-12">
                        <div class="postbox__comment-input mb-30">
                          <input type="text" v-model="form.linkedin_profile" class="inputText" />
                          <span class="floating-label">{{ trans('LinkedIn Profile') }}</span>
                          <p class="text-danger ms-3 mt-2">
                            {{ form.errors.linkedin_profile }}
                          </p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__comment-input mb-30">
                          <input type="text" v-model="form.website" class="inputText" />
                          <span class="floating-label">{{ trans('Personal website') }}</span>
                          <p class="text-danger ms-3 mt-2">{{ form.errors.website }}</p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__select mb-30">
                          <NiceSelect
                            v-model="form.experience"
                            :options="[
                              '1 Year',
                              '2 Years',
                              '3 Years',
                              '4 Years',
                              '5 Years',
                              '6 Years',
                              '7 Years',
                              '8 Years',
                              '9 Years',
                              '10+ Years'
                            ]"
                            :placeholder="trans('Years of experience')"
                          />
                          <p class="text-danger ms-3 mt-2">
                            {{ form.errors.experience }}
                          </p>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="postbox__comment-input mb-35">
                          <input
                            type="text"
                            v-model.number="form.expected_salary"
                            class="inputText"
                          />
                          <span class="floating-label">{{ trans('Expected salary') }}</span>
                          <p class="text-danger ms-3 mt-2">
                            {{ form.errors.expected_salary }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xxl-12">
                  <div class="postbox__resume-title-box">
                    <h5 class="career-details-title-xs pb-15">
                      {{ trans('Upload a recent resume or CV') }}
                    </h5>
                  </div>
                  <div class="postbox__resume mb-30">
                    <input
                      id="cv"
                      type="file"
                      @change="(e) => (form.cv = e.target.files[0])"
                      hidden
                    />
                    <label for="cv">
                      <span>
                        <svg
                          width="18"
                          height="15"
                          viewBox="0 0 18 15"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M11.9133 10.4519L9.00453 7.54309L6.0957 10.4519"
                            stroke="#202124"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                          <path
                            d="M9.00391 7.54309V14.0879"
                            stroke="#202124"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                          <path
                            d="M15.1044 12.1899C15.8137 11.8032 16.374 11.1914 16.6969 10.4509C17.0198 9.7104 17.0869 8.88347 16.8877 8.1006C16.6884 7.31774 16.2341 6.62352 15.5965 6.12752C14.9588 5.63152 14.1742 5.36198 13.3664 5.36145H12.4501C12.23 4.51006 11.8197 3.71966 11.2502 3.04965C10.6806 2.37965 9.96657 1.84748 9.16174 1.49315C8.35691 1.13883 7.48222 0.971567 6.60344 1.00395C5.72467 1.03632 4.86466 1.2675 4.08808 1.68009C3.31151 2.09268 2.63857 2.67595 2.11986 3.38605C1.60115 4.09615 1.25017 4.9146 1.09331 5.77988C0.936443 6.64515 0.977774 7.53472 1.21419 8.38172C1.45061 9.22872 1.87597 10.0111 2.45829 10.67"
                            stroke="#202124"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                          <path
                            d="M11.9133 10.4519L9.00453 7.54309L6.0957 10.4519"
                            stroke="#202124"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                        </svg>
                        {{ trans('Upload your resume') }}
                      </span>
                    </label>
                    <p class="text-danger ms-3 mt-2">
                      {{ form.errors.cv }}
                    </p>
                  </div>
                </div>
                <div class="col-xxl-12">
                  <div class="postbox__btn-box mb-50">
                    <SpinnerBtn
                      :processing="form.processing"
                      class="submit-btn w-100"
                      :btn-text="trans('Submit Application')"
                    />
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-xxl-12">
            <div class="career-details-social-box mb-20">
              <a :href="socialShare('facebook')"><i class="fab fa-facebook-f"></i></a>
                <a :href="socialShare('twitter')"><i class="fab fa-twitter"></i></a>
                <a :href="socialShare('linkedin')"><i class="fab fa-linkedin"></i></a>
                <a :href="socialShare('instagram')"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="career-details-bottom-text text-center">
              <a href="#">{{ trans('Share to your social media platform') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- tp-job-area-start -->
  <div class="job-area pt-120 pb-10">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="job-section-box mb-40 text-center">
            <h3 class="tp-section-title">{{ trans('Open Positions') }}</h3>
            <p>
              Borem ipsum dolor sit amet, consectetur adipiscing elit. Nulla scelerisque tristique
              <br />
              Et amet risus enim accumsan sit purus sit.
            </p>
          </div>
        </div>
      </div>
      <div v-for="job in jobs" class="job-post-box" :key="job">
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-4">
            <div class="job-post-info d-flex justify-content-start align-items-center">
              <div class="job-post-category">
                <span>{{ job.title }}</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5">
            <div class="job-post-wrapper d-flex align-items-center">
              <div class="job-post-time d-flex align-items-center">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M9 16.75C13.2802 16.75 16.75 13.2802 16.75 9C16.75 4.71979 13.2802 1.25 9 1.25C4.71979 1.25 1.25 4.71979 1.25 9C1.25 13.2802 4.71979 16.75 9 16.75Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M9 5.7998V9.9998L11.8 11.3998"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                <span>{{ job.type }}</span>
              </div>
              <div class="job-post-location d-flex align-items-center">
                <svg
                  width="16"
                  height="18"
                  viewBox="0 0 16 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M1 7.51463C1 3.9167 4.13401 1 8 1C11.866 1 15 3.9167 15 7.51463C15 11.0844 12.7658 15.2499 9.28007 16.7396C8.46748 17.0868 7.53252 17.0868 6.71993 16.7396C3.23416 15.2499 1 11.0844 1 7.51463Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                  />
                  <path
                    d="M10 8C10 9.10457 9.10457 10 8 10C6.89543 10 6 9.10457 6 8C6 6.89543 6.89543 6 8 6C9.10457 6 10 6.89543 10 8Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                  />
                </svg>
                <span>{{ job.location }}</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3">
            <div class="job-post-apply-btn text-md-end text-start">
              <Link
                class="tp-btn-inner tp-btn-hover alt-color-orange"
                :href="route('jobs.show', job.slug)"
                ><span>{{ trans('Apply') }}</span> <b></b
              ></Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-job-area-end -->
</template>
