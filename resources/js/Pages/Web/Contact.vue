<script setup>
import InputFieldError from '@/Components/InputFieldError.vue'
import SpinnerBtn from '@/Components/SpinnerBtn.vue'
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: DefaultLayout })

defineProps(['contact'])

const form = useForm({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submit = () => {
  form.post('/contact-us', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    }
  })
}
</script>

<template>
  <!-- tp-breadcrumb-area-start -->
  <div class="about-banner-area p-relative">
    <div class="about-shape-1 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="about-shape-2 z-index-3">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="about-banner p-relative z-index fix">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="about-banner-content">
              <h4
                class="about-banner-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="sanitizeHtml(contact.page_title)"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-area-end -->

  <!-- tp-breadcrumb-header-area-start -->
  <div class="about-img-area mb-100 z-index-3">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div
            class="about-img about-img-height p-relative"
            :style="{ backgroundImage: `url(${sanitizeHtml(contact.image)})` }"
          >
            <div class="about-img-content">
              <h4
                class="about-img-title"
                data-parallax='{"y": 1000, "smoothness": 10}'
                v-html="sanitizeHtml(contact.page_title)"
              ></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-breadcrumb-header-area-end -->

  <!-- tp-contact-area-strat -->
  <div class="contact-info-area pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item">
            <div class="contact-info-img">
              <img :src="sanitizeHtml(contact.office_left_img)" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_left_name }}</a>
              </h5>
              <p>
                {{ contact.office_left_address }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item p-relative">
            <div class="contact-info-badge">
              <span>{{ trans('Main Office') }}</span>
            </div>
            <div class="contact-info-img">
              <img :src="sanitizeHtml(contact.office_center_img)" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_center_name }}</a>
              </h5>
              <p>
                <a href="#">{{ contact.office_center_address }}</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 mb-30">
          <div class="contact-info-item">
            <div class="contact-info-img">
              <img :src="sanitizeHtml(contact.office_right_img)" alt="" />
            </div>
            <div class="contact-info-title-box">
              <h5 class="contact-info-title-sm">
                <a href="#">{{ contact.office_right_name }}</a>
              </h5>
              <p>
                <a href="#">{{ contact.office_right_address }}</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-form-area pb-120">
    <div class="container">
      <div class="row gx-0">
        <div class="col-xl-5 col-lg-6">
          <div class="contact-form-left">
            <div class="contact-form-section-box pb-10">
              <h5 class="inner-section-subtitle">{{ contact.top_title }}</h5>
              
              <h4 class="tp-section-title pb-10">{{ trans('We\'d love to') }} <br> {{ trans('hear From') }} <span><svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect width="44" height="44" fill="url(#pattern0)"></rect><defs><pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_2106_35" transform="translate(-0.425532 -0.170213) scale(0.0212766)"></use></pattern><image id="image0_2106_35" width="83" height="66" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFMAAABCCAYAAAArOOo+AAADcklEQVR4nO2bP0wTURzHP5RqQhyMtyJNTCcTnKCLnVhs4sRmHRk10U0WFhcXiQskuDPhxirRQZMagn8WB1gatTqQiMV/qRBM6nB99oDe9Y7+3mvf8T5j03u/yyfv97vvK8dQs9ls4hAh0+8bSBNOpiBOpiBOpiBOpiBOpiBOpiBOpiCnWma1AmvzUK/JrJeVWcYeqhWovoKnDw9/fu1e72ufCplhAhUXLsrUSa3MbgKD5IsyNVMlM4nAIF5Opr71Mk8qUFEoy92LlTJ7FRgkf7X3NRRDtvyeKSkwyKOvcmsN9M6UEuiNQf3z8c8lWxwGUKbkDvTGoHAzfC3JFocBkamjhfNFKC/Ag4no70jSN5m6ZiBAadY/0SxNR39PKhIpjMrUKRD8ti4v+jtubd6vF4b0vAQDMnULVOSLcHu1XbNbPel5CZqiUb0Gb57oF6hQba1qR81JhWQkUmjZmY+nO0cRaYJtrVi52/06HS0OmmTeWm239+sVHRUOt7Wi25z8f62GFgcDJ6B6TV5ssK0V1Ur3p7di7q38kxwMHyd7FduprdW6ceakQse8BBg6OPjbzGaH9aweQVKxndpasTQdr73Bn5flxfj3mYTMyxfv9KzcBS/nH/XKi37blRfCHwyl2XCRceekQte8BBg+N3Lp/tRUgTNn+3eyHDkPo1dg/LovdHTc/2zvB8wsh0uuVmDlTrJaM8u9328Y2efPNtjc/MDE5GV9VRLg5dq7Nop6Lf4DR6ErEiky29vfWF9/r7eKBuLkyaPobHFo/d18a+sjjcae3kqCJJ2TCulfiY6SAah92rZGZpxzdxg6smWQDMDOznd2d3/qrSRE0jmp0D0voSXzT2OP/f0D/dUEKM2e7Drd8xJaMqvVL/z+1dBfTYDJGye7rls6kMC6F7e8XPKWNdHiYKFMSP6SlYkWB0tlerlkMUd3JFJYKROglGB36o5ECmtl5ovxdpypeQkWywQoxHiym5qXYLnMWDvTQCRSWC3Ty0WHeJMtDpbLhOgQb7LFIQUyo0K8qUiksF4mhId4U5FIkQqZnUK86XkJKZEJx0O86XkJKZJ5NMSbjESK1MiEdojvR4tDymTmi61Xr/skcyBew5bCy8Fcf96pAFK2M/uNkymINf9UZQNuZwriZAriZAriZAriZAriZAriZAriZAryD4xxER8vOFEDAAAAAElFTkSuQmCC"></image></defs></svg></span> {{ trans('you.') }} </h4>
              <p>
                {{ contact.sub_title }}
              </p>
            </div>
            <div class="contact-form-social-box p-relative">
              <div class="contact-form-social-item">
                <a target="_blank" :href="sanitizeHtml(contact.facebook)"
                  ><i class="fab fa-facebook-f"></i
                ></a>
                <a target="_blank" :href="sanitizeHtml(contact.twitter)"
                  ><i class="fab fa-twitter"></i
                ></a>
                <a target="_blank" :href="sanitizeHtml(contact.linkedin)"
                  ><i class="fab fa-linkedin-in"></i
                ></a>
                <a target="_blank" :href="sanitizeHtml(contact.instagram)"
                  ><i class="fab fa-instagram"></i
                ></a>
              </div>
              <div class="contact-form-section-img">
                <img :src="sanitizeHtml(contact.left_img)" alt="" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-7 col-lg-6">
          <div class="contact-form-right-warp">
            <div class="postbox__comment-form">
              <form @submit.prevent="submit" class="box">
                <div class="row gx-20">
                  <div class="col-12">
                    <div class="postbox__comment-input mb-30">
                      <input type="text" v-model="form.name" class="inputText" />
                      <span class="floating-label">{{ trans('Full Name') }}</span>
                      <InputFieldError :message="form.errors.name" />
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="postbox__comment-input mb-30">
                      <input type="email" v-model="form.email" class="inputText" />
                      <InputFieldError :message="form.errors.email" />
                      <span class="floating-label">{{ trans('Your Email') }}</span>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="postbox__comment-input mb-35">
                      <input type="text" v-model="form.subject" class="inputText" />
                      <InputFieldError :message="form.errors.subject" />
                      <span class="floating-label">{{ trans('Subject') }}</span>
                    </div>
                  </div>

                  <div class="col-xxl-12">
                    <div class="postbox__comment-input mb-30">
                      <textarea v-model="form.message" class="textareaText"></textarea>
                      <InputFieldError :message="form.errors.message" />
                      <span class="floating-label-2">{{ trans('Message...') }}</span>
                    </div>
                  </div>
                  <div class="col-xxl-12">
                    <div class="postbox__btn-box">
                      <SpinnerBtn
                        :processing="form.processing"
                        :btn-text="trans('Send your Request')"
                        class="submit-btn w-100"
                      />
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-inner-area pb-90">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="contact-inner-title-sm-wrap mb-50 text-center">
            <h4 class="contact-inner-title-sm">{{ contact.bottom_title }}</h4>
            <p>{{ contact.bottom_sub_title }}</p>
          </div>
        </div>
      </div>
      <div class="d-flex contact-inner-wrapper justify-content-center px-0">
        <div class="row gx-0 info-container">
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-1">
                <img :src="sanitizeHtml(contact.bottom_email_img)" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="`mailto:${sanitizeHtml(contact.email)}`">{{ contact.email }}</a>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-2">
                <img :src="sanitizeHtml(contact.bottom_phone_img)" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="`tel:${sanitizeHtml(contact.phone)}`">{{ contact.phone }}</a>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4">
            <div
              class="contact-inner-item d-flex align-items-center justify-content-start justify-content-lg-center"
            >
              <div class="contact-inner-img contact-img-3">
                <img :src="sanitizeHtml(contact.bottom_address_img)" alt="" />
              </div>
              <div class="contact-inner-link">
                <a :href="sanitizeHtml(contact?.map_link ?? '#')" target="_blank">{{
                  contact.address
                }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- tp-contact-area-end -->
</template>
