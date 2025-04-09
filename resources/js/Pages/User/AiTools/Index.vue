<script setup>
import { router } from '@inertiajs/vue3'
import OverviewGrid from '@/Components/Admin/OverviewGrid.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import sharedComposable from '@/Composables/sharedComposable'
import UserLayout from '@/Layouts/User/UserLayout.vue'
import trans from '@/Composables/transComposable'
import toast from '@/Composables/toastComposable'
import NoDataFound from '@/Components/Admin/NoDataFound.vue'
import { computed } from 'vue'

defineOptions({ layout: UserLayout })
const props = defineProps(['templates', 'credits', 'bookmarked', 'segments'])
const { textExcerpt, uiAvatar, trim } = sharedComposable()
const stats = computed(() => {
  return [
    {
      value: props.templates.length,
      title: trans('AI Tools'),
      iconSrc: '/assets/dashboard/images/icon/icon_43.svg'
    },
    {
      value: props.bookmarked?.length ?? 0,
      title: trans('Bookmarked'),
      iconSrc: '/assets/dashboard/images/icon/icon_13.svg'
    },
    {
      value: props.credits,
      title: trans('Credits'),
      iconSrc: '/assets/dashboard/images/icon/money.png'
    }
  ]
})

const bookmark = (id, bookmarked) => {
  router.post(
    route('user.ai-tools.bookmark'),
    {
      ai_template_id: id
    },
    {
      onSuccess: () => {
        if (bookmarked == 1) {
          toast.danger('Bookmarked Removed Successfully')
        } else {
          toast.success('Bookmarked Successfully')
        }
      }
    }
  )
}
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="AI Tools" :buttons="[]" />
    <OverviewGrid :items="stats" grid="3" />
    <div class="mt-8">
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <template v-for="temp in templates" :key="temp.id">
          <div class="card card-body">
            <div class="flex items-center justify-start gap-4 border-b border-primary-600 pb-8">
              <Link :href="route('user.ai-tools.show', temp.uuid)" class="logo h-16 min-w-[4rem]">
                <img
                  v-lazy="uiAvatar(temp.title, temp.icon)"
                  alt="image"
                  class="h-full w-full rounded-full"
                />
              </Link>
              <div>
                <Link
                  :href="route('user.ai-tools.show', temp.uuid)"
                  class="font-semibold capitalize"
                >
                  {{ textExcerpt(temp.title, 65) }}
                </Link>
                <p class="text-sm capitalize text-gray-500">{{ trim(temp.prompt_type) }}</p>
              </div>

              <button
                @click="bookmark(temp.id, temp.isBookmarked)"
                type="button"
                class="btn ml-auto h-10 w-10 rounded-full"
                :class="{
                  'btn-primary': temp.isBookmarked == 1,
                  'btn-outline-primary': temp.isBookmarked == 0
                }"
              >
                <i class="bx bx-bookmark-alt-minus text-xl"></i>
              </button>
            </div>
            <div v-html="textExcerpt(sanitizeHtml(temp.description), 100)" class="pt-5"></div>
          </div>
        </template>
      </div>

      <NoDataFound v-if="templates.length < 1" />
    </div>
  </main>
</template>
