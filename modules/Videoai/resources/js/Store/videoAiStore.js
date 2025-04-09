import { defineStore } from 'pinia'
import axios from 'axios'
import toast from '@root/Composables/toastComposable'
import sharedComposable from '@root/Composables/sharedComposable'

const { pickBy, sanitizeHtml } = sharedComposable()

export const useVideoAiStore = defineStore('videoAiStore', {
  state: () => ({
    props: {},
    generatedVideo: '',
    generateVideoId: '',
    fieldErrors: {},
    errors: {},
    hasError: false,
    isProcessing: false,
    selectedImage: null,
    imagePreview: null,
    validationRules: {},
    form: {
      prompt: '',
      duration: '',
      imageUrl: '',
      provider: ''
    }
  }),

  actions: {
    checkPrompt(text) {
      const matches = text.match(/\[(.*?)\]/g) || []
      const errors = {}

      if (matches.length > 0) {
        matches.forEach((match) => {
          errors[match.replace('[', '').replace(']', '')] = `${match} field needs to be filled`
        })
      }

      this.hasError = false
      if (Object.keys(errors).length > 0) {
        this.hasError = true
        this.errors = errors
      }
    },

    async handleImageSelect(event) {
      const file = event.target.files[0]
      if (file) {
        this.imagePreview = URL.createObjectURL(file)

        if (this.validationRules.image === 'required') {
          const allowedTypes = ['image/jpeg', 'image/png', 'image/gif']
          if (!allowedTypes.includes(file.type)) {
            toast.danger('Invalid image type')
            this.clearImage()
            return
          }
        }

        const formData = new FormData()
        formData.append('image', file)

        try {
          const res = await axios.post(route('videoai.api.upload-image'), formData)
          this.form.imageUrl = res.data.path
        } catch (error) {
          toast.danger('Failed to upload image')
          this.clearImage()
        }
      }
    },

    setPreset(promptPreset) {
      this.form.prompt += promptPreset.prompt
    },

    clearImage() {
      this.selectedImage = null
      this.imagePreview = null
      this.form.imageUrl = ''
    },

    resetState(keepProcessing = false) {
      this.generatedVideo = ''
      this.generateVideoId = null
      this.isProcessing = keepProcessing
      this.fieldErrors = {}
    },

    handleSuccess(output) {
      this.generatedVideo = output
      this.generateVideoId = null
      this.isProcessing = false
      this.fieldErrors = {}
      toast.success('Video generated successfully!')
    },

    handleError(error) {
      this.resetState()
      toast.danger(error || 'An error occurred')
    },

    async fetchVideo() {
      try {
        const res = await axios.get(
          route('videoai.api.ai-fetch-generate-video', {
            id: this.generateVideoId,
            provider: this.props.aiVideoSetting?.provider
          })
        )
        const responseStatus = res.data?.status || 'processing'
        const lowerCaseStatus = responseStatus.toLowerCase()

        if (['processing', 'pending', 'running'].includes(lowerCaseStatus)) {
          await new Promise((resolve) => setTimeout(resolve, 30000))
          this.fetchVideo()
          return
        }

        if (['success', 'completed', 'succeeded'].includes(lowerCaseStatus)) {
          this.handleSuccess(res.data.output[0])
          return
        }

        this.handleError(res.data.error || 'Failed to generate video')
      } catch (error) {
        this.handleError(error)
      }
    },

    async generateVideo() {
      try {
        this.resetState(true)
        this.form.prompt = sanitizeHtml(this.form.prompt)
        this.form.provider = this.props.aiVideoSetting?.provider
        const res = await axios.post(route('videoai.api.ai-generate-video'), pickBy(this.form))

        if (res.data.status === 'processing') {
          this.generateVideoId = res.data?.id
          await new Promise((resolve) => setTimeout(resolve, 3000))
          this.fetchVideo()
          return
        }

        if (res.data.status === 'success') {
          this.handleSuccess(res.data.output[0])
          return
        }

        this.handleError(res.data.error || 'Failed to generate video')
      } catch (error) {
        this.handleError(error)
      }
    },

    validateForm() {
      this.hasError = false
      this.fieldErrors = {}

      if (!this.form.prompt) {
        this.fieldErrors.prompt = 'Please enter a prompt'
        this.hasError = true
      }

      if (this.validationRules.image === 'required' && !this.form.imageUrl) {
        this.fieldErrors.image = 'Please select an image'
        this.hasError = true
      }

      const allowedDurations = this.validationRules.duration || []
      const duration = this.form.duration.toString()

      if (allowedDurations.length > 0 && !allowedDurations.includes(duration)) {
        this.fieldErrors.duration = `Duration must be one of: ${allowedDurations.join(
          ', '
        )} seconds`
        this.hasError = true
      }

      return !this.hasError
    },

    submit() {
      this.checkPrompt(this.form.prompt)

      if (!this.validateForm()) return
      this.errors = {}

      if (Object.keys(this.errors).length === 0) {
        this.isProcessing = true
        this.generateVideo()
      }
    }
  }
})
