import { useForm } from '@inertiajs/vue3'
import { defineStore } from 'pinia'
import axios from 'axios'
import toast from '@/Composables/toastComposable'
import sharedComposable from '@/Composables/sharedComposable'
const { pickBy } = sharedComposable()

export const useAiToolsStore = defineStore('aiToolsStore', {
  state: () => ({
    props: {},
    generatedText: '',
    generatedVideo: '',
    generateVideoId: null,
    generatedVoice: '',
    generateVoiceId: null,
    generatedImages: [],
    documentName: '',
    fieldErrors: {},
    errors: {},
    hasError: false,
    isProcessing: false,
    form: useForm({
      prompt: '',
      language: 'english',
      tone: '',
      max_token: 200,
      qty: 1,
      creativity: '',
      seconds: 0,
      init_audio: null,
      model: '',
      template_id: '',
      fields: ''
    }),

    tones: ['Professional', 'Funny', 'Casual', 'Excited', 'Bold', 'Dramatic'],
    creativityLevels: [
      {
        label: 'Optimal',
        value: 0.5
      },
      {
        label: 'Low',
        value: 0.8
      },
      {
        label: 'Medium',
        value: 0.9
      },
      {
        label: 'High',
        value: 1
      }
    ]
  }),
  actions: {
    setInitialState(form) {
      this.form = form
    },
    transformPrompt() {
      const fields = []
      this.form.fields.forEach((element) => {
        if (element.hasOwnProperty('value')) {
          fields[element.name.toLowerCase()] = element.value
          this.hasError = false
        } else {
          this.hasError = true
          this.fieldErrors[element.name] = `${element.name} is required`
          return
        }
      })

      this.form.prompt = this.props.template.prompt.replace(
        /\[(.*?)\]/g,
        (match, key) => fields[key.toLowerCase()]
      )
    },
    generateText() {
      axios
        .post(route('api-ai-generate-text', pickBy(this.form)))
        .then(async (res) => {
          for (const text of res.data) {
            this.generatedText += text
            await new Promise((resolve) => setTimeout(resolve, 100))
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors
          if (error.response.status == 400) {
            toast.danger('You dont have enough credits please purchase some credits')
          }
        })
        .finally(() => {
          this.isProcessing = false
          this.fieldErrors = {}
        })
    },
    async processMedia(url, delay, isGenerateMedia = false, mediaType) {
      const res = await axios.post(url, pickBy(this.form))
      if (res.data.status == 'processing') {
        if (isGenerateMedia) {
          if (mediaType === 'video') {
            this.generateVideoId = res.data.id
          } else if (mediaType === 'voice' || mediaType === 'audio') {
            this.generateVoiceId = res.data.id
          }
        }
        await new Promise((resolve) => setTimeout(resolve, delay))
        if (mediaType === 'video') {
          this.fetchVideo()
        } else if (mediaType === 'voice' || mediaType === 'audio') {
          this.fetchVoice()
        }
      }
      if (res.data.status == 'success') {
        if (mediaType === 'video') {
          this.generatedVideo = res.data.output[0]
          this.generateVideoId = null
        } else if (mediaType === 'voice' || mediaType === 'audio') {
          this.generatedVoice = res.data.output[0]
          this.generateVoiceId = null
        }
        this.isProcessing = false
        this.fieldErrors = {}
      }
      if (res.data.status == 'failed') {
        if (mediaType === 'video') {
          this.generatedVideo = []
          this.generateVideoId = null
        } else if (mediaType === 'voice' || mediaType === 'audio') {
          this.generatedVoice = []
          this.generateVoiceId = null
        }
        this.isProcessing = false
        this.fieldErrors = {}
      }
      if (res.data.error) {
        toast.danger(res.data.error)
      }
    },
    fetchVideo() {
      this.processMedia(
        route('api-ai-fetch-generate-video', { id: this.generateVideoId }),
        30000,
        false,
        'video'
      )
    },

    generateVideo() {
      this.processMedia(route('api-ai-generate-video'), 30000, true, 'video')
    },

    fetchVoice() {
      this.processMedia(
        route('api-ai-fetch-generate-voice', { id: this.generateVoiceId }),
        30000,
        false,
        'voice'
      )
    },

    generateVoice() {
      this.processMedia(route('api-ai-generate-voice'), 30000, true, 'voice')
    },

    generateAudio() {
      this.processMedia(route('api-ai-generate-audio'), 30000, true, 'audio')
    },
    generateImage() {
      axios
        .post(route('api-ai-generate-image', pickBy(this.form)))
        .then(async (res) => {
          for (const image of res.data) {
            this.generatedImages.push(image)
          }
        })
        .catch((error) => {
          this.errors = error.response?.data?.errors
          if (error.response?.status == 400) {
            toast.danger('You dont have enough credits please purchase some credits')
          }
        })
        .finally(() => {
          this.isProcessing = false
          this.fieldErrors = {}
        })
    },

    submit() {
      const totalCharge = this.props.template.credit_charge * this.form.qty
      if (totalCharge > this.props.credits) {
        toast.danger('You dont have enough credits please purchase some credits')
        return
      }
      this.transformPrompt()
      if (this.hasError) return

      this.isProcessing = true

      if (this.props.template.prompt_type === 'text') {
        this.generateText()
        return
      }
      if (this.props.template.prompt_type === 'image') {
        this.generateImage()
        return
      }
      if (this.props.template.prompt_type === 'video') {
        this.generateVideo()
        return
      }
      if (this.props.template.prompt_type === 'voice_clone') {
        this.generateVoice()
        return
      }
      if (this.props.template.prompt_type === 'audio') {
        this.generateAudio()
        return
      }
    },
    downloadHTMLFile(textContent, name) {
      const blob = new Blob([textContent], { type: 'text/html' })
      const a = document.createElement('a')
      a.href = URL.createObjectURL(blob)
      a.download = name ? name.replace(' ', '-') : 'untitled.html'

      a.click()
      URL.revokeObjectURL(a.href)
    }
  }
})
