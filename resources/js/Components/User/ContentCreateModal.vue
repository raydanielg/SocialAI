<script setup>
import Modal from '@/Components/Modal.vue'
import planPerks from '@/Composables/planPerksComposable'
import toast from '@/Composables/toastComposable'
import { useModalStore } from '@/Store/modalStore'
import { useForm } from '@inertiajs/vue3'
import { storeToRefs } from 'pinia'
import { ref, onMounted } from 'vue'
import HollowDotsSpinner from '../HollowDotsSpinner.vue'
import InputFieldError from '../InputFieldError.vue'
import sharedComposable from '@/Composables/sharedComposable'

const props = defineProps(['totalBrandPost', 'brands', 'brand_uuid'])
const modal = useModalStore()
const { countWordsAndChars } = sharedComposable()
const emit = defineEmits(['action'])
const { getState } = storeToRefs(modal)
const isListening = ref(false)
const voicedDescription = ref(false)
const fileInput = ref(null)
const isSpeechRecognitionSupported = ref(false)

const form = useForm({
  brand_id: '',
  title: '',
  input: '',
  image: ''
})

const recognition = (() => {
  try {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
    if (SpeechRecognition) {
      isSpeechRecognitionSupported.value = true
      const recognition = new SpeechRecognition()
      recognition.continuous = true
      recognition.interimResults = true
      recognition.lang = 'en-US'
      return recognition
    }
    return null
  } catch (e) {
    console.warn('Speech recognition not supported in this browser')
    return null
  }
})()

onMounted(() => {
  if (recognition) {
    recognition.onresult = (event) => {
      const transcript = Array.from(event.results)
        .map((result) => result[0])
        .map((result) => result.transcript)
        .join('')
      voicedDescription.value = transcript
    }
    recognition.onspeechend = () => {
      form.input += voicedDescription.value
    }
  }

  if (props.brand_uuid) {
    form.brand_id = props.brands.find((brand) => brand.uuid == props.brand_uuid).id
  }
})

const toggleListening = () => {
  if (!recognition) {
    toast.warning('Speech recognition is not supported in your browser')
    return
  }

  isListening.value = !isListening.value
  if (isListening.value) {
    recognition.start()
  } else {
    recognition.stop()
  }
}

const setImageURL = (value) => {
  return URL.createObjectURL(value)
}

const submit = () => {
  planPerks.checkPlan('posts', props.totalBrandPost)
  if (planPerks.status === 'danger') {
    return toast.danger(planPerks.message)
  }
  if (form.input && countWordsAndChars(form.input).words > 200) {
    toast.danger('Maximum words allowed is 200')
    return
  }
  form.post(route('user.brand-posts.store'), {
    preserveState: true,
    onSuccess: () => modal.close()
  })
}
</script>
<template>
  <Modal :state="getState('createContent')" :header-state="true" header-title="Description">
    <select v-model="form.brand_id" class="select mt-3">
      <option value="" selected disabled>Select Brand</option>
      <option :value="brand.id" v-for="brand in brands" :key="brand.id">{{ brand.name }}</option>
    </select>
    <input type="text" v-model="form.title" class="input mt-3" placeholder="Title" />
    <InputFieldError :message="form.errors.title" />
    <div class="my-4 rounded border border-gray-600 p-3">
      <textarea
        v-model="form.input"
        class="textarea styled-scrollbar max-h-48 min-h-[12rem] resize-none border-none p-0 focus:ring-0"
        placeholder="Write something"
      ></textarea>
      <InputFieldError :message="form.errors.input" />
      <template v-if="form.image">
        <div class="group relative h-20 max-w-max">
          <img class="h-full rounded-md" :src="setImageURL(form.image)" alt="logo" />
          <button
            @click="form.image = null"
            class="btn btn-dark btn-xs invisible absolute -right-2 -top-2 h-5 w-5 rounded-full group-hover:visible"
          >
            <i class="bx bx-x text-xl"></i>
          </button>
        </div>
      </template>
    </div>
    <div class="flex items-center justify-between">
      <div class="space-y-3">
        <button type="button" class="btn btn-outline-primary mr-3" @click="toggleListening">
          <div class="looping-rhombuses-spinner ml-1 mr-3 scale-75" v-if="isListening">
            <div class="rhombus bg-primary-600"></div>
            <div class="rhombus bg-primary-600"></div>
            <div class="rhombus bg-primary-600"></div>
          </div>
          <i class="bx bx-microphone" v-else></i>

          <span>Voice Typing</span>
        </button>
        <input
          ref="fileInput"
          @input="(e) => (form.image = e.target.files[0])"
          accept="image/*"
          type="file"
          hidden
        />
        <button type="button" @click="fileInput.click()" class="btn btn-dark">
          <i class="bx bx-upload"></i>
          <span>Upload Image</span>
        </button>
      </div>
      <button
        @click="submit"
        :disabled="form.processing"
        type="button"
        class="btn btn-primary whitespace-nowrap"
      >
        <HollowDotsSpinner
          v-if="form.processing"
          class="flex items-center justify-center"
          dotClass="dot-white"
        />
        <template v-else>
          <i class="bx bx-paper-plane"></i>
          <span>Generate Post</span>
        </template>
      </button>
    </div>
  </Modal>
</template>
