<script setup>
import moment from 'moment'
import { Swiper, SwiperSlide } from 'swiper/vue'

import sharedComposable from '@/Composables/sharedComposable'
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'

import Sidebar from './Partials/Sidebar.vue'
import DOMPurify from 'dompurify';
defineOptions({ layout: DefaultLayout })
defineProps(['blog', 'categories', 'tags', 'recent_blogs', 'related_blogs', 'prevBlog', 'nextBlog'])

const { socialShare, textExcerpt, getQueryParams } = sharedComposable()
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-ptb-4 p-relative blue-bg-2">
    <div class="breadcrumb__shape-1">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-1.png" alt="" />
    </div>
    <div class="breadcrumb__shape-2">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2.png" alt="" />
    </div>
    <div class="container">
      <div class="row align-items-end">
        <div class="col-md-9">
          <div class="blog-details-banner z-index-2">
            <div class="blog-details-title-box">
              <span>{{ blog.categories?.[0]?.title || trans('Uncategorized') }}</span>
              <h3 class="blog-details-banner-title">
                {{ textExcerpt(blog.title, 42) }}
              </h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-15">
          <div class="blog-details-social-box z-index-3 text-md-end text-start">
            <a :href="socialShare('facebook')"><i class="fab fa-facebook-f"></i></a>
            <a :href="socialShare('twitter')"><i class="fab fa-twitter"></i></a>
            <a :href="socialShare('linkedin')"><i class="fab fa-linkedin"></i></a>
            <a :href="socialShare('instagram')"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!-- breadcrumb-banner-start -->
  <div class="blog-details-img-area mb-80">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="blog-details-big-img z-index-2">
            <img
              :src="sanitizeHtml(blog.banner?.value ?? blog.preview?.value)"
              alt=""
              class="max-h-[400px]"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-banner-end -->

  <!-- postbox area start -->
  <div class="postbox__area pb-100">
    <div class="container">
      <div class="row">
        <div class="col-xxl-8 col-xl-8 col-lg-8">
          <div class="postbox__details-wrapper pr-20">
            <article>
              <div class="postbox__details-title-box pb-30">
                <h4 class="postbox__details-title">{{ blog.title }}</h4>
                <div v-html="DOMPurify.sanitize(blog.long_description?.value)"></div>
              </div>

              <div class="postbox__details tagcloud mb-50">
                <span>{{ trans('Tags') }}:</span>
                <Link v-for="tag in blog.tags" :href="`/blogs/tag/${tag.slug}`" :key="tag.id">
                  {{ tag.title }}</Link
                >
              </div>
              <div class="postbox__navigation-more mb-70 d-flex justify-content-between">
                <div class="postbox__navigation-left d-flex align-items-center">
                  <div class="postbox__navigation-img rc__post-thumb">
                    <img v-if="nextBlog" :src="sanitizeHtml(nextBlog.preview?.value)" alt="" />
                  </div>
                  <div v-if="nextBlog" class="postbox__navigation-content">
                    <span>
                      <i class="far fa-arrow-left"></i>
                      {{ trans(' Previous post') }}
                    </span>
                    <h5>
                      <Link v-if="nextBlog" :href="`/blogs/${sanitizeHtml(nextBlog.slug)}`">{{
                        textExcerpt(nextBlog.title, 20)
                      }}</Link>
                    </h5>
                  </div>
                </div>
                <div v-if="prevBlog" class="postbox__navigation-right d-flex align-items-center">
                  <div class="postbox__navigation-content">
                    <span>
                      {{ trans('Next post') }}
                      <i class="far fa-arrow-right"></i>
                    </span>
                    <h5>
                      <Link :href="`/blogs/${sanitizeHtml(prevBlog.slug)}`">{{
                        textExcerpt(prevBlog.title, 20)
                      }}</Link>
                    </h5>
                  </div>
                  <div class="postbox__navigation-img rc__post-thumb">
                    <img :src="sanitizeHtml(prevBlog?.preview?.value)" class="" alt="" />
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4">
          <Sidebar :categories="categories" :posts="recent_blogs" :tags="tags" />
        </div>
      </div>
    </div>
  </div>
  <!-- postbox area end -->

  <!--Portfolio Start-->
  <div class="blog-grid-inner grey-bg pt-100 pb-50">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="popular-blog-title mb-40 text-center">
            <h4>{{ trans('Related Posts') }}</h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="blog-details-slider-wrapper">
            <Swiper
              :loop="true"
              :slidesPerView="3"
              :spaceBetween="30"
              :breakpoints="{
                '1200': {
                  slidesPerView: 3
                },
                '992': {
                  slidesPerView: 2
                },
                '768': {
                  slidesPerView: 2
                },
                '576': {
                  slidesPerView: 1
                },
                '0': {
                  slidesPerView: 1
                }
              }"
              class="swiper-container blog-slider-active pb-50"
            >
              <SwiperSlide v-for="(blog, i) in related_blogs" :key="i" class="swiper-slide">
                <div class="tp-blog-item">
                  <div class="tp-blog-thumb fix">
                    <Link :href="route('blogs.show', blog)"
                      ><img class="w-100" :src="sanitizeHtml(blog.preview?.value)" alt=""
                    /></Link>
                  </div>
                  <div class="tp-blog-content">
                    <div class="tp-blog-meta d-flex align-items-center">
                      <div class="tp-blog-category category-color-1">
                        <span>{{ blog.categories?.[0]?.title || 'Uncategorized' }}</span>
                      </div>
                      <div class="tp-blog-date">
                        <span>{{ moment(blog.created_at).format('DD MMM, Y') }}</span>
                      </div>
                    </div>
                    <div class="tp-blog-title-box">
                      <Link class="tp-blog-title-sm" :href="route('blogs.show', blog)">
                        {{ textExcerpt(blog.title, 40) }}</Link
                      >
                    </div>
                  </div>
                </div>
              </SwiperSlide>
            </Swiper>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Portfolio End-->
</template>
