import axios from 'axios'
import { defineStore } from 'pinia'

import sharedComposable from '@/Composables/sharedComposable'
import notify from '@/Composables/toastComposable'
import { router, useForm } from '@inertiajs/vue3'

const { countWordsAndChars } = sharedComposable()
export const usePublishStore = defineStore({
  id: 'publishStore',
  state: () => ({
    form: useForm({}),
    tiktokOptions: {
      privacy_level: '',
      disable_comment: false,
      disable_duet: false,
      disable_stitch: false
    },
    assetTabs: ['uploads', 'ai', 'stock'],
    platforms: [],
    platformTab: '',
    publishAccounts: [],
    userPlatforms: [],
    newContent: {},
    publishingPlatform: null,
    publishingPlatformIdIndex: null,
    brandPostContentPlatform: {},
    platformSelectedMediaType: null,
    imageTab: 'uploads',
    videoTab: 'uploads',
    mainTab: 'input',
    loading: {
      content: false,
      slogan: false,
      publish: false,
      draft: false
    },
    isDesignProcessing: false,
    selectedDesignId: null,
    selectedDesigns: [],
    designEditor: false,
    dataObjects: {},
    originalSelectedMedias: []
  }),

  actions: {
    draftPost() {
      this.loading.draft = true
      let url = route('user.brand-posts.update', this.form.uuid)
      let postData = {
        newBrandPost: {
          ...this.form
        },
        status: 'draft'
      }
      router.put(url, postData, {
        onSuccess: (page) => {
          this.form.platforms = [...(page.props.content?.platforms ?? [])]
        },
        onFinish: () => {
          this.loading.draft = false
        }
      })
    },

    schedulePost() {
      if (this.form.scheduled_at == null) {
        notify.warning('Please choose a schedule date and time')
        return
      }

      let url = route('user.brand-posts.update', this.form.uuid)

      let postData = {
        newBrandPost: this.form,
        status: 'schedule',
        user_platforms: this.publishAccounts,
        is_schedule: true,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
      }

      this.loading.publish = true
      router.put(url, postData, {
        onFinish: () => {
          this.loading.publish = false
        }
      })
    },

    publishPost() {
      if (countWordsAndChars(this.form.input).words > 100) {
        notify.danger('Maximum words allowed is 100')
        return
      }

      if (this.publishAccounts.length == 0) {
        this.setTab('connect')
        notify.warning('Please choose at least one publisher account')
        return
      }

      this.publishingPlatformIdIndex = 0

      this.loading.publish = true
      this.dispatchPosts('save_and_publish')
    },

    dispatchPosts(status = 'save_and_publish') {
      let publishPlatform = this.publishAccounts[this.publishingPlatformIdIndex]

      if (!publishPlatform) {
        this.finishPublishing()
        return
      }

      if (this.getPublishedPlatforms.find((item) => item.platform == publishPlatform.platform)) {
        return this.publishNextPost()
      }

      this.publishingPlatform = publishPlatform

      if (this.publishingPlatform.platform === 'tiktok') {
        this.form.tiktokOptions = this.tiktokOptions
      }

      axios
        .put(route('user.brand-posts.update', this.form.uuid), {
          newBrandPost: this.form,
          platform_id: this.publishingPlatform.id,
          status
        })
        .then((res) => {
          let resData = res.data

          this.form.platforms = this.form.platforms.map((platform) => {
            return platform.id === resData.id ? resData : platform
          })
        })
        .catch((err) => {
          this.form.platforms = this.form.platforms.map((platform) => {
            if (platform.id === this.publishingPlatform.id) {
              return { ...platform, status: 'failed' }
            }
            return platform
          })
          notify.danger(Object.values(err)?.[0] ?? 'Something went wrong!')
        })
        .finally(() => {
          let hasNextPostToDispatch =
            this.publishingPlatformIdIndex < this.publishAccounts.length - 1
          hasNextPostToDispatch ? this.publishNextPost() : this.finishPublishing()
        })
    },

    publishNextPost() {
      this.publishingPlatformIdIndex++
      setTimeout(() => this.dispatchPosts(), 100)
    },
    finishPublishing() {
      this.publishingPlatformIdIndex = null
      this.publishingPlatform = null
      this.loading.publish = false
    },

    setOriginalContent(content) {
      this.form = { ...content }
      this.brandPostContentPlatform = this.form.platforms?.find(
        (item) => item.platform == this.platformTab
      )
      if (!this.brandPostContentPlatform) {
        this.brandPostContentPlatform = {
          content: '',
          platform: this.platformTab
        }
        this.form.platforms = [...this.form.platforms, this.brandPostContentPlatform]
      }
      this.platformSelectedMediaType = content.media_type ?? ''
      this.platformSelectedMedia = this.findPostPlatformByName(this.platformTab)?.media ?? []
    },
    setTab(tab) {
      this.mainTab = tab
    },
    setPlatformTab(tab) {
      const previousTab = this.platformTab
      this.platformTab = tab

      const previousTabData = this.brandPostContentPlatform

      this.brandPostContentPlatform = this.form.platforms.find((item) => item.platform === tab)
      if (!this.brandPostContentPlatform) {
        this.brandPostContentPlatform = {
          content: '',
          platform: tab
        }
        this.form.platforms = [...this.form.platforms, this.brandPostContentPlatform]
      }
      this.form.platforms = this.form.platforms.map((platform) => {
        if (platform.platform === previousTab) {
          return { ...previousTabData }
        }
        return platform
      })
    },

    setImagesTab(tab) {
      this.imageTab = tab
    },
    setVideosTab(tab) {
      this.videoTab = tab
    },

    generateContent(type) {
      const properties = {
        content: 'content',
        slogan: 'slogan'
      }

      this.loading[properties[type]] = true

      axios
        .post(
          route('user.generate-content', {
            type: type,
            brand_id: this.form.brand_id,
            post_id: this.form.id,
            description: this.form.input,
            platform: this.platformTab
          })
        )
        .then((res) => {
          setTimeout(() => {
            if (type === 'slogan') {
              this.form[properties[type]] = res.data
            }

            if (type === 'content') {
              this.brandPostContentPlatform.content = res.data
            }
            this.draftPost()
          }, 3000)
        })
        .catch((err) => {
          notify.danger(err.response.data)
        })
        .finally(() => {
          setTimeout(() => (this.loading[properties[type]] = false), 3000)
        })
    },

    setPlatformMedia(media, type, mediaType = 'image') {
      // get selected active platform
      let selectedActivePlatform = this.getActivePlatformContent()

      // reset selected media if media type changed
      if (selectedActivePlatform.media_type != mediaType) {
        this.platformSelectedMedia = []
      }

      // toggle media
      if (this.platformSelectedMedia.includes(media)) {
        this.platformSelectedMedia = this.platformSelectedMedia.filter((item) => item != media)
      } else {
        if (mediaType == 'video') {
          this.platformSelectedMedia = []

          this.platformSelectedMedia.push(media)
        } else if (mediaType == 'image') {
          this.platformSelectedMedia.push(media)
        }
      }

      // set media type and media
      this.brandPostContentPlatform.media_type = mediaType
      this.brandPostContentPlatform.media = this.platformSelectedMedia
      selectedActivePlatform.media_type = this.platformSelectedMedia.length > 0 ? mediaType : null
      selectedActivePlatform.media = this.platformSelectedMedia

      this.platformSelectedMediaFrom = type
      this.platformSelectedMediaType = this.platformSelectedMedia?.length > 0 ? mediaType : null
    },

    togglePublishAccount(platform, canEmpty = false) {
      if (this.loading.publish) {
        return
      }

      let status = this.findPostPlatformByName(platform.platform).status ?? null
      if (['published', 'scheduled'].includes(status)) {
        return notify.danger(
          `The ${platform.platform} platform is already ${status}. Please choose from another platform`
        )
      }

      if (this.findPublishAccount(platform.id)) {
        if (this.publishAccounts.length === 1 && !canEmpty) {
          return notify.warning("Can't remove item, at least one item is required")
        }
        this.publishAccounts = this.publishAccounts.filter((item) => item.id != platform.id)
      } else {
        this.publishAccounts = this.publishAccounts.filter(
          (item) => item.platform != platform.platform
        )
        this.publishAccounts.push(platform)

        let tiktokUserPlatform = this.findPublishAccountByName('tiktok') ?? null
        if (tiktokUserPlatform) {
          let tiktokCreatorInfo = tiktokUserPlatform.meta ?? []
          if (tiktokCreatorInfo.length > 0) {
            this.tiktokOptions.disable_comment = tiktokCreatorInfo?.comment_disabled ?? false
            this.tiktokOptions.disable_duet = tiktokCreatorInfo?.duet_disabled ?? false
            this.tiktokOptions.disable_stitch = tiktokCreatorInfo?.stitch_disabled ?? false
          }
        }
      }
    }
  },
  getters: {
    findPublishAccount: (state) => {
      return (id) => state.publishAccounts.find((item) => item.id == id)
    },
    findPublishAccountByName: (state) => {
      return (name) => state.publishAccounts.find((item) => item.platform == name)
    },

    findPostPlatform: (state) => {
      return (id) => state.form?.platforms.find((item) => item.id == id) ?? null
    },

    findPostPlatformByUserPlatformId: (state) => {
      return (user_platform_id) =>
        state.form?.platforms.find((item) => item.user_platform_id == user_platform_id) ?? null
    },

    findPostPlatformByName: (state) => {
      return (platform) => state.form?.platforms?.find((item) => item.platform == platform) ?? null
    },

    checkUserPlatformIsAvailable: (state) => {
      return (platform) => {
        return ['draft', 'failed'].includes(
          state.form?.platforms?.find((item) => item.platform == platform)?.status
        )
      }
    },
    getPublishedPlatforms: (state) => {
      return state.form?.platforms?.filter((item) => item.status == 'published') ?? []
    },

    getTabState: (state) => {
      return (key) => state.mainTab == key
    },
    getPlatformTabState: (state) => {
      return (key) => state.platformTab == key
    },
    getImagesTabState: (state) => {
      return (key) => state.imageTab == key
    },
    getVideosTabState: (state) => {
      return (key) => state.videoTab == key
    },
    getActivePlatformContent: (state) => {
      return (key = null) => {
        let activePlatformContent =
          state.form?.platforms?.find((item) => item.platform == state.platformTab) || {}
        return key ? activePlatformContent[key] : activePlatformContent
      }
    },
    getOriginalMedia: (state) => {
      return (
        state.originalSelectedMedias?.find((item) => item.platform === state.platformTab)?.media ??
        []
      )
    },
    tiktokUserOptions: (state) => {
      return state.findPublishAccountByName('tiktok')?.meta ?? {}
    }
  }
})
