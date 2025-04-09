import { defineStore } from 'pinia'
import axios from 'axios'
import { router, useForm, usePage } from '@inertiajs/vue3'
import { usePublishStore } from '@/Store/publishStore'
import toastComposable from '@/Composables/toastComposable'

export const usePublishAssetStore = defineStore({
  id: 'publishAssetStore',
  state: () => ({
    assetForm: useForm({
      image: '',
      video: ''
    }),
    imageSearchQuery: '',
    videoSearchQuery: '',
    generateVideoId: null,
    loading: {
      stockImages: false,
      stockVideos: false,
      aiImages: false,
      aiVideo: false
    },
    assetImageInput: null,
    assetVideoInput: null,
    stockImages: [],
    stockVideos: [],
    aiImages: [],
    aiVideos: [],
    isStockImagesFetched: false,
    isStockVideosFetched: false,
    isAiImageFetched: false,
    isAiVideoFetched: false,
    assetUploadProgress: 0,
    assets: {
      uploadedImages: {
        data: [],
        currentPage: 1,
        loadMore: false
      },
      generatedImages: {
        data: [],
        currentPage: 1,
        loadMore: false
      },
      uploadedVideos: {
        data: [],
        currentPage: 1,
        loadMore: false
      },
      generatedVideos: {
        data: [],
        currentPage: 1,
        loadMore: false
      },
      loading: false
    }
  }),
  actions: {
    setAssets(generatedImages, uploadedImages, generatedVideos, uploadedVideos) {
      const assetTypes = {
        generatedImages: {
          newData: generatedImages.data,
          loadMore: !!generatedImages.next_page_url
        },
        generatedVideos: {
          newData: generatedVideos.data,
          loadMore: !!generatedVideos.next_page_url
        },
        uploadedImages: { newData: uploadedImages.data, loadMore: !!uploadedImages.next_page_url },
        uploadedVideos: { newData: uploadedVideos.data, loadMore: !!uploadedVideos.next_page_url }
      }

      Object.entries(assetTypes).forEach(([type, { newData, loadMore }]) => {
        this.assets[type].data = [...this.assets[type].data, ...newData]
        this.assets[type].loadMore = loadMore
      })
    },
    stockImageSearch() {
      this.loading.stockImages = true
      this.isStockImagesFetched = false
      axios
        .get(
          route('user.generate-stock-image', {
            query: this.imageSearchQuery
          })
        )
        .then((res) => (this.stockImages = res.data.results))
        .finally(() => {
          setTimeout(() => {
            this.isStockImagesFetched = true
            this.loading.stockImages = false
          }, 2000)
        })
    },
    generateImage() {
      const publishStore = usePublishStore()
      this.loading.aiImages = true
      router.post(
        route('user.generate-image'),
        {
          brand_id: publishStore.form.brand_id,
          description: publishStore.form.input
        },
        {
          only: ['generatedAssetImages'],
          onSuccess: (page) => {
            const generatedImage = page.props.generatedAssetImages.data[0]
            const isExist = this.assets.generatedImages.data.find(
              (img) => img.id === generatedImage.id
            )
            if (!isExist) {
              this.assets.generatedImages.data.unshift(generatedImage)
            }
          },
          onError: () => {
            if (usePage().props.errors?.ai_error) {
              toastComposable.danger(usePage().props.errors.ai_error)
            }
          },
          onFinish: () => {
            setTimeout(() => (this.loading.aiImages = false), 3000)
          }
        }
      )
    },
    submitAsset(e, assetType) {
      this.assetForm[assetType] = e.target.files[0]
      this.assetForm.post(route('user.assets.store'), {
        onProgress: (progress) => {
          this.assetUploadProgress = progress.percentage
        },
        onSuccess: (page) => {
          if (assetType === 'image' && page.props.uploadedAssetImages.data?.length > 0) {
            const generatedImage = page.props.uploadedAssetImages.data[0]
            const isExist = this.assets.uploadedImages.data.find(
              (img) => img.id === generatedImage.id
            )
            if (!isExist) {
              this.assets.uploadedImages.data.unshift(generatedImage)
            }
          }
          if (assetType === 'video' && page.props.uploadedAssetVideos.data?.length > 0) {
            const generatedVideo = page.props.uploadedAssetVideos.data[0]
            const isExist = this.assets.uploadedVideos.data.find(
              (video) => video.id === generatedVideo.id
            )
            if (!isExist) {
              this.assets.uploadedVideos.data.unshift(generatedVideo)
            }
          }
          this.assetForm.reset()
        },
        onFinish: () => {
          setTimeout(() => (this.assetUploadProgress = 0), 1000)
        }
      })
    },
    stockVideoSearch() {
      this.loading.stockVideos = true
      this.isStockVideosFetched = false
      axios
        .get(
          route('user.stock-video', {
            query: this.videoSearchQuery
          })
        )
        .then((res) => {
          const videos = res.data.videos

          this.stockVideos = videos.map((video) => video.video_files[0])
        })
        .finally(() => {
          setTimeout(() => {
            this.isStockVideosFetched = true
            this.loading.stockVideos = false
          }, 2000)
        })
    },
    async processVideo(url, delay, isGenerateVideo = false) {
      const res = await axios.post(url)
      if (res.data.status == 'processing') {
        if (isGenerateVideo) {
          this.generateVideoId = res.data.id
        }
        await new Promise((resolve) => setTimeout(resolve, delay))
        this.fetchVideo()
      }

      if (res.data.status == 'success') {
        this.aiVideos = res.data.output[0]
        const generatedVideo = usePage().props.generatedAssetVideos.data[0]
        const isExist = this.assets.generatedVideos.data.find(
          (video) => video.id === generatedVideo.id
        )
        if (!isExist) {
          this.assets.generatedVideos.data.unshift(generatedVideo)
        }
        this.generateVideoId = null
        setTimeout(() => (this.loading.aiVideo = false), 3000)
      }
      if (res.data.status == 'failed') {
        this.aiVideos = []
        this.generateVideoId = null
        setTimeout(() => (this.loading.aiVideo = false), 3000)
      }
    },
    fetchVideo() {
      this.processVideo(route('user.fetch-video', { id: this.generateVideoId }), 30000)
    },
    generateVideo() {
      const publishStore = usePublishStore()
      this.loading.aiVideo = true
      this.processVideo(
        route('user.generate-video', {
          brand_id: publishStore.form.brand_id
        }),
        30000,
        true
      )
    },

    loadMoreAssets(type, mime_type) {
      const assetType = `${type}${mime_type}`

      this.assets[assetType].currentPage++
      this.assets[assetType].loadMore = true
      this.assets.loading = true
      axios
        .get(
          route('api-assets', {
            type: type,
            mime_type: mime_type,
            page: this.assets[assetType].currentPage
          })
        )
        .then((res) => {
          this.assets[assetType].data.push(...res.data.data)
          this.assets[assetType].currentPage = res.data.current_page
          if (!res.data.next_page_url) {
            this.assets[assetType].loadMore = false
          }
        })
        .finally(() => {
          this.assets.loading = false
        })
    }
  }
})
