<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
defineOptions({ layout: DefaultLayout })
defineProps(['categories', 'tags', 'posts'])
import sharedComposable from '@/Composables/sharedComposable'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'
import moment from 'moment'
const { getQueryParams } = sharedComposable()
const request = getQueryParams()
const searchInput = ref(request.s ?? '')

const submit = () => {
  router.get(route('blogs.index'), { s: searchInput.value })
}
</script>

<template>
  <div class="sidebar__wrapper">
    <div class="sidebar__widget mb-40">
      <div class="sidebar__widge-title-box">
        <h3 class="sidebar__widget-title">{{ trans('Search') }}</h3>
      </div>
      <div class="sidebar__widget-content">
        <div class="sidebar__search">
          <form @submit.prevent="submit">
            <div class="sidebar__search-input-2">
              <input v-model="searchInput" type="text" placeholder="Search...." />
              <button type="submit">
                <svg
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M8.01371 15.2219C11.9525 15.2219 15.1456 12.0382 15.1456 8.11096C15.1456 4.18368 11.9525 1 8.01371 1C4.07488 1 0.881836 4.18368 0.881836 8.11096C0.881836 12.0382 4.07488 15.2219 8.01371 15.2219Z"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <path
                    d="M16.9287 16.9996L13.0508 13.1331"
                    stroke="#5F6168"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="sidebar__widget mb-40" v-if="posts.length > 0">
      <div class="sidebar__widge-title-box">
        <h3 class="sidebar__widget-title">{{ trans('Recent Post') }}</h3>
      </div>
      <div class="sidebar__widget-content">
        <div class="sidebar__post rc__post">
          <div v-for="item in posts" :key="item.id" class="rc__post d-flex mb-20">
            <div class="rc__post-thumb mr-20">
              <Link :href="route('blogs.show', item.slug)"
                ><img :src="sanitizeHtml(item.preview.value)" alt=""
              /></Link>
            </div>
            <div class="rc__post-content">
              <h3 class="rc__post-title">
                <Link :href="sanitizeHtml(route('blogs.show', item.slug))">{{ item.title }}</Link>
              </h3>
              <div class="rc__meta">
                <span>{{ moment(item.created_at).format('DD MMM, YYYY') }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="sidebar__widget mb-40" v-if="categories.length > 0">
      <div class="sidebar__widge-title-box">
        <h3 class="sidebar__widget-title">{{ trans('Categories') }}</h3>
      </div>
      <div class="sidebar__widget-content">
        <ul>
          <li v-for="cat in categories" :key="cat.id">
            <Link :href="`/blogs/category/${cat.slug}`"
              ><span><i class="fal fa-angle-right"></i>{{ cat.title }}</span
              ><span>{{ cat.postCategories_count }}</span></Link
            >
          </li>
        </ul>
      </div>
    </div>
    <div class="sidebar__widget mb-40" v-if="tags.length > 0">
      <div class="sidebar__widge-title-box">
        <h3 class="sidebar__widget-title">{{ trans('Popular Tags') }}</h3>
      </div>
      <div class="sidebar__widget-content">
        <div class="tagcloud">
          <Link v-for="tag in tags" :href="`/blogs/tag/${tag.slug}`" :key="tag.id">
            {{ tag.title }}</Link
          >
        </div>
      </div>
    </div>
  </div>
</template>
