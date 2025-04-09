<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import moment from 'moment'

import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation } from 'swiper/modules'
import Pagination from '@/Components/Web/Pagination.vue'
import Sidebar from './Partials/Sidebar.vue'
import sharedComposable from '@/Composables/sharedComposable'

const { textExcerpt } = sharedComposable()

defineOptions({ layout: DefaultLayout })
const props = defineProps(['posts', 'categories', 'recent_posts', 'tags'])

const navEls = {
  nextEl: '.grid-next',
  prevEl: '.grid-prev'
}
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-height p-relative blue-bg-2">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-8">
          <div class="breadcrumb__content">
            <h3 class="breadcrumb__title tp-char-animation">
              {{ trans('Read our blogs') }}
            </h3>
            <div class="breadcrumb__list wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".4s">
              <span class="child-one"
                ><Link href="/">{{ trans('Home') }}</Link></span
              >
              <span class="dvdr"><i class="fal fa-angle-right"></i></span>
              <span>{{ trans('Blogs') }}</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4 text-md-end d-none d-md-block text-center">
          <div class="breadcrumb__img p-relative z-index text-start">
            <img class="z-index-3" src="/assets/img/breadcrumb/breadcrumb-3.png" alt="" />
            <div
              class="breadcrumb__sub-img wow tpfadeUp"
              data-wow-duration=".9s"
              data-wow-delay=".4s"
            >
              <img src="/assets/img/breadcrumb/breadcrumb-sub-1.png" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <div class="postbox__area pt-100 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <h4 v-if="posts.data.length === 0" class="mt-130 text-center">
            {{ trans('No posts found') }}
          </h4>

          <div id="blog" class="postbox__wrapper pr-20">
            <article
              v-for="blog in posts.data"
              :key="blog.id"
              class="postbox__item format-image mb-70 transition-3"
            >
              <div class="postbox__thumb w-img">
                <Link :href="sanitizeHtml(route('blogs.show', blog.slug))">
                  <img :src="blog.preview?.value" alt="" />
                </Link>
              </div>
              <div class="postbox__content">
                <div class="postbox__meta">
                  <span
                    ><Link :href="blog.category_show_url">
                      {{ blog.categories?.[0]?.title ?? 'Uncategorized' }}</Link
                    ></span
                  >
                  <span
                    ><a href="#">{{ blog.create_date }}</a></span
                  >
                </div>
                <h3 class="postbox__title">
                  <Link :href="sanitizeHtml(route('blogs.show', blog.slug))">{{ blog.title }}</Link>
                </h3>
                <div class="postbox__text">
                  <p>
                    {{ textExcerpt(blog.short_description?.value, 350) }}
                  </p>
                </div>
                <div class="postbox__btn mt-35">
                  <Link
                    class="tp-btn-inner tp-btn-hover alt-color-black"
                    :href="sanitizeHtml(route('blogs.show', blog.slug))"
                  >
                    <span>{{ trans('Read More') }}</span>
                    <b></b>
                  </Link>
                </div>
              </div>
            </article>
            <Pagination :links="posts.links" />
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <Sidebar :categories="categories" :posts="recent_posts" :tags="tags" />
        </div>
      </div>
    </div>
  </div>
</template>
