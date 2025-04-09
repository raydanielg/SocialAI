<script setup>
import { computed, ref } from 'vue'

import { storeToRefs } from 'pinia'

import CreatePostCard from '@/Components/User/CreatePostCard.vue'
import sharedComposable from '@/Composables/sharedComposable'
import { usePublishStore } from '@/Store/publishStore'
import trans from '@/Composables/transComposable'

const { textExcerpt } = sharedComposable()

const store = usePublishStore()
const { getPlatformTabState, platforms, platformTab, userPlatforms } = storeToRefs(store)

const getCurrentlyActiveTabUserPlatforms = computed(() => {
  return userPlatforms.value.filter((item) => item.platform == platformTab.value)
})

const redirectTo = (platform) => {
  window.open(route('connect.' + platform), '_blank')
}

const showInfoContainer = ref(false)
</script>

<template>
  <div class="flex flex-col gap-3">
    <template v-for="platform in platforms" :key="platform">
      <CreatePostCard
        v-if="getPlatformTabState(platform)"
        v-on:action="redirectTo(platform)"
        :text="trans(`Connect ${platform}`)"
        classes="w-full h-28"
      />
    </template>

    <div class="flex items-center justify-between">
      <h6 class="mt-5">{{ trans('Connected Accounts') }}:</h6>

      <!-- info button to toggle alert -->
      <button
        title="Content recommendations"
        class="btn transition duration-100"
        :class="[showInfoContainer ? 'btn-primary' : 'btn-soft-primary']"
        @click="showInfoContainer = !showInfoContainer"
      >
        <Icon icon="bx:info-circle" class="text-lg" />
      </button>
    </div>

    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded text-sm" v-if="showInfoContainer">
      <!-- instagram -->
      <div v-if="getPlatformTabState('instagram')">
        <p class="font-bold">{{ trans('Ensure to meet the following criteria:') }}</p>
        <ol class="list-outlined list-decimal space-y-2 ps-4">
          <li>{{ trans('Account is set as a professional account (Business or Creator)') }}</li>
          <li>{{ trans('Account is successfully connected to a Facebook page') }}</li>
          <li>
            {{
              trans(
                'You have at least Content access or Full control over the Facebook page to which your Instagram is linked'
              )
            }}
          </li>
          <li>
            {{
              trans(
                'Your Instagram account is enabled for SocialAI in the Business Integrations settings of your Facebook account'
              )
            }}
          </li>
        </ol>
        <p class="mb-2 mt-3 font-bold">{{ trans('Video Restrictions:') }}</p>
        <table class="table">
          <thead>
            <tr>
              <th class="w-[14%]">{{ trans('Property') }}</th>
              <th class="w-[54%]">{{ trans('Specification') }}</th>
            </tr>
          </thead>
          <tbody class="_5m37" id="u_0_7_M5">
            <tr class="row_0">
              <td>
                <p>{{ trans('File Type') }}</p>
              </td>
              <td>
                <p>{{ trans('.mp4 (recommended)') }}</p>
              </td>
            </tr>
            <tr class="row_1 _5m29">
              <td>
                <p>{{ trans('Aspect Ratio') }}</p>
              </td>
              <td>
                <p>{{ trans('9 x 16') }}</p>
              </td>
            </tr>
            <tr class="row_2">
              <td>
                <p>{{ trans('Resolution') }}</p>
              </td>
              <td>
                <p>{{ trans('1080 x 1920 pixels (recommended). Minimum is 540 x 960 pixels') }}</p>
              </td>
            </tr>
            <tr class="row_3 _5m29">
              <td>
                <p>{{ trans('Frame Rate') }}</p>
              </td>
              <td>
                <p>{{ trans('24 to 60 frames per second') }}</p>
              </td>
            </tr>
            <tr class="row_4">
              <td>
                <p>{{ trans('Duration') }}</p>
              </td>
              <td>
                <p>{{ trans('3 to 90 seconds.') }}</p>
                <p>
                  {{
                    trans(
                      'A reel published as a story on a Facebook Page can not exceed 60 seconds.'
                    )
                  }}
                </p>
              </td>
            </tr>
            <tr class="row_5 _5m29">
              <td>
                <p>{{ trans('Video Settings') }}</p>
              </td>
              <td>
                <table class="uiGrid _51mz _57v1" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="_51mx">
                      <td class="_51m- vTop hLeft _57v2">
                        <ul>
                          <li>{{ trans('Chroma subsampling 4:2:0') }}</li>
                          <li>{{ trans('Closed GOP (2-5 seconds)') }}</li>
                          <li>
                            {{ trans('Compression – H.264, H.265 (VP9, AV1 are also supported)') }}
                          </li>
                        </ul>
                      </td>
                      <td class="_51m- vTop hLeft _57v2 _51mw">
                        <ul>
                          <li>{{ trans('Fixed frame rate') }}</li>
                          <li>{{ trans('Progressive scan') }}</li>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr class="row_6">
              <td>
                <p>{{ trans('Audio Settings') }}</p>
              </td>
              <td>
                <table class="uiGrid _51mz _57v1" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr class="_51mx">
                      <td class="_51m- vTop hLeft _57v2">
                        <ul>
                          <li>{{ trans('Audio bitrate – 128kbs+') }}</li>
                          <li>{{ trans('Channels – Stereo') }}</li>
                        </ul>
                      </td>
                      <td class="_51m- vTop hLeft _57v2 _51mw">
                        <ul>
                          <li>{{ trans('Codec – AAC Low Complexity') }}</li>
                          <li>{{ trans('Sample rate – 48kHz') }}</li>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- tiktok -->
      <div v-else-if="getPlatformTabState('tiktok')">
        <p class="font-bold">{{ trans('Video Restrictions:') }}</p>
        <table class="mt-2 ">
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Supported media formats') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('MP4 (recommended)') }}</li>
                <li>{{ trans('WebM') }}</li>
                <li>{{ trans('MOV') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Supported codecs') }}</p>
              <br />
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('H.264 (recommended)') }}</li>
                <li>{{ trans('H.265') }}</li>
                <li>{{ trans('VP8') }}</li>
                <li>{{ trans('VP9') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Framerate restrictions') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('Minimum of 23 FPS') }}</li>
                <li>{{ trans('Maximum of 60 FPS') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Picture size restrictions') }}</p>
              <br />
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('Minimum of 360 pixels for both height and width') }}</li>
                <li>{{ trans('Maximum of 4096 pixels for both height and width') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Duration restrictions') }}</p>
              <br />
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>
                  {{
                    trans(
                      'All TikTok creators can post 3-minute videos, while some have access to post 5-minute or 10-minute videos.'
                    )
                  }}
                </li>
                <li>
                  {{ trans('The longest video a developer can send via the initialize') }}
                  <a
                    href="https://developers.tiktok.com/doc/content-posting-api-reference-upload-video"
                    target="_blank"
                    >{{ trans('Upload Video') }}</a
                  >
                  {{
                    trans(
                      'endpoint is 10 minutes. TikTok users may trim developer-sent videos inside the TikTok app to fit their accounts actual maximum publish durations.'
                    )
                  }}
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Size restrictions') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('Maximum of 200MB') }}</li>
              </ul>
            </td>
          </tr>
        </table>

        <p class="mt-10 font-bold">{{ trans('Image Restrictions:') }}</p>
        <table class="mt-3">
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Supported media formats') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('WebP') }}</li>
                <li>{{ trans('JPEG') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Picture size restrictions') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('Maximum 1080p') }}</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td rowspan="1" colspan="1">
              <p >{{ trans('Size restrictions') }}</p>
            </td>
            <td rowspan="1" colspan="1">
              <ul type="disc">
                <li>{{ trans('Maximum of 20MB for each image') }}</li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
      <!-- twitter -->
      <div v-if="getPlatformTabState('twitter')">
        <p class="font-bold">{{ trans('Image specifications and recommendations:') }}</p>
        <ul>
          <li>{{ trans('Supported image media types: JPG, PNG, GIF, WEBP') }}</li>
          <li>{{ trans('Maximum image size: 5MB') }}</li>
          <li>{{ trans('Maximum number of images: 4') }}</li>
        </ul>
      </div>

      <!-- facebook -->
      <div v-if="getPlatformTabState('facebook')">
        <p class="font-bold">{{ trans('Image specifications and recommendations:') }}</p>
        <ul>
          <li>{{ trans('Videos are limited to 10GB and 4 hours.') }}</li>
        </ul>
        <p class="mt-5 font-bold">{{ trans('Thumbnail Image Requirements') }}</p>
        <p>{{ trans('Format: BMP, GIF, JPEG, PNG,TIFF File Size: 10MB or less.') }}</p>
        <p class="mt-2 italic">
          {{
            trans(
              'There are no image dimension requirements, but it should share the same aspect ratio as your video.'
            )
          }}
        </p>
      </div>

      <!-- Linkedin -->
      <div v-if="getPlatformTabState('linkedin')">
        <p class="font-bold">{{ trans('Image Specifications:') }}</p>
        {{ trans('The Images API supports the following image pixel count and formats:') }}
        <p>
          {{
            trans(
              ' Images with less than 36152320 pixels JPG, GIF, and PNG formats GIF format supports up to 250 frames'
            )
          }}
        </p>

        <p class="mt-5 font-bold">{{ trans('Video Specifications:') }}</p>
        {{ trans('The following are the high-level specifications for video file sizing:') }}
        <ul>
          <li>{{ trans('Length: Three seconds to 30 minutes') }}</li>
          <li>{{ trans('File size: Between 75kb and 200MB') }}</li>
          <li>{{ trans('Video format: MP4') }}</li>
        </ul>
      </div>
    </div>

    <p class="text-center text-slate-500" v-if="getCurrentlyActiveTabUserPlatforms.length == 0">
      {{ trans('No account found') }}
    </p>

    <div v-for="platform in getCurrentlyActiveTabUserPlatforms" :key="platform.id">
      <div
        class="flex flex-col gap-1"
        :class="{
          'opacity-50': !store.checkUserPlatformIsAvailable(platform.platform)
        }"
      >
        <button
          @click="store.togglePublishAccount(platform, true)"
          class="overflow-hidden rounded-lg border border-dashed border-green-600 p-3"
          :class="{
            'bg-green-100 font-semibold dark:bg-gray-700': store.findPublishAccount(platform.id),
            'bg-gray-50 dark:bg-gray-800': !store.findPublishAccount(platform.id),
            'cursor-not-allowed bg-green-50': !store.checkUserPlatformIsAvailable(platform.platform)
          }"
        >
          <div class="flex items-center justify-between">
            <span class="flex items-center justify-between gap-3">
              <img
                :src="platform.picture ?? '/assets/images/no-image.jpg'"
                @error="(e) => (e.target.src = '/assets/images/no-image.jpg')"
                class="h-10 w-10 rounded-full"
              />
              <span class="text-nowrap">{{ platform.name }}</span>
              <span v-if="platform.username" class="truncate text-gray-500"
                >({{ textExcerpt(platform.username, 15) }})</span
              >
            </span>

            <i
              v-if="store.findPostPlatformByUserPlatformId(platform.id)?.status === 'published'"
              class="bx bx-check text-2xl text-green-600"
            />

            <i
              v-else
              class="bx text-2xl text-green-600"
              :class="{
                'bxs-check-circle': store.findPublishAccount(platform.id),
                'bx-plus-circle': !store.findPublishAccount(platform.id)
              }"
            />
          </div>
        </button>
      </div>
    </div>
  </div>
</template>
