<script setup>
import { ref } from 'vue'
import Modal from '@/Components/Modal.vue'
import { useModalStore } from '@/Store/modalStore'
const modalStore = useModalStore()

const props = defineProps(['data'])
const videoUrl = ref(props.data?.demo_video)
</script>

<template>
  <div class="ab-company-area pt-105 pb-100">
    <div class="container">
      <div class="row ab-company-section-space">
        <div class="col-xl-6">
          <div class="ab-company-section-box">
            <h4 class="inner-section-subtitle">{{ data.top_title }}</h4>
            <h3 class="tp-section-title">
              {{ data.left_title }}
            </h3>
          </div>
        </div>
        <div class="col-xl-6 wow tpfadeRight mt-40" data-wow-duration=".9s" data-wow-delay=".5s">
          <div class="ab-company-right">
            <div class="ab-company-section-text">
              <p>
                {{ data.right_text1 }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-xl-4">
          <div class="ab-company-video">
            <a @click="modalStore.open('videoPopup')" class="popup-video" href="javascript:void(0)"
              ><i class="fas fa-play"></i
            ></a>
            <span>{{ trans('Watch Demo') }}</span>
          </div>
        </div>
        <div class="col-xl-8">
          <div class="row">
            <div class="col-md-4 col-sm-4 mb-40">
              <div class="ab-company-fun-fact-wrap d-flex justify-content-start">
                <div class="ab-company-fun-fact">
                  <span>{{ trans('USED BY') }}</span>
                  <h4 v-html="sanitizeHtml(data.creators)"></h4>
                  <p>{{ trans('Creators') }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 mb-40">
              <div
                class="ab-company-fun-fact-wrap d-flex justify-content-md-center justify-content-left"
              >
                <div class="ab-company-fun-fact">
                  <span>{{ trans('VALUE') }}</span>
                  <h4 v-html="sanitizeHtml(data.revenue)"></h4>
                  <p>{{ trans('Revenue per Year') }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 mb-40">
              <div
                class="ab-company-fun-fact-wrap ab-company-border-none d-flex justify-content-md-center justify-content-left"
              >
                <div class="ab-company-fun-fact">
                  <span>{{ trans('IN') }}</span>
                  <h4 v-html="sanitizeHtml(data.countries)"></h4>
                  <p>{{ trans('Countries using') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <Modal :state="modalStore.states['videoPopup']" :closeBtn="false">
    <div class="video-popup-modal">
      <iframe :src="sanitizeHtml(videoUrl)" height="100%" width="100%"></iframe>
    </div>
  </Modal>
</template>
