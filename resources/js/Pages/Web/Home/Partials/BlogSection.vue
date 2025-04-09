<script setup>
import moment from 'moment'

defineProps(['blogs'])
</script>

<template>
  <div class="tp-blog-area pb-80">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-5">
          <div class="tp-blog-section-box mb-50 text-center">
            <h3 class="tp-section-title-3">
              {{ trans('Our Latest ') }}<span>{{ trans('News and Articles') }}</span>
            </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div v-for="blog in blogs" :key="blog.id" class="col-xl-4 col-lg-4 col-md-6 mb-60">
          <div class="tp-blog-item">
            <div class="tp-blog-thumb fix">
              <Link :href="route('blogs.show', blog)"
                ><img :src="sanitizeHtml(blog.preview?.value)" alt=""
              /></Link>
            </div>
            <div class="tp-blog-meta d-flex align-items-center">
              <div class="tp-blog-category category-color-1">
                <span>{{ blog.categories?.[0]?.title }}</span>
              </div>
              <div class="tp-blog-date">
                <span>{{ moment(blog.created_at).format('DD MMM, YYYY') }}</span>
              </div>
            </div>
            <div class="tp-blog-title-box">
              <Link class="tp-blog-title-sm" :href="route('blogs.show', blog)">{{
                blog.title
              }}</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
