<script setup>
import DefaultLayout from '@/Layouts/Default/DefaultLayout.vue'
import { computed } from 'vue'
import { ref } from 'vue'

defineOptions({ layout: DefaultLayout })
const props = defineProps(['projects', 'categories'])

const selectedProjectCategory = ref('*')

const filteredProjects = computed(() => {
  if (selectedProjectCategory.value === '*') {
    return props.projects.data
  } else {
    return props.projects.data?.filter((item) => item.category_id == selectedProjectCategory.value)
  }
})
</script>

<template>
  <!-- breadcrumb-area-start -->
  <div class="breadcrumb__area breadcrumb-height-2 breadcrumb-overlay p-relative fix">
    <div class="breadcrumb__shape-2 z-index-4">
      <img src="/assets/img/breadcrumb/breadcrumb-shape-2-2.png" alt="" />
    </div>
    <div class="breadcrumb__shape-3 z-index-4">
      <img src="/assets/img/breadcrumb/breadcrumb-sub-2.png" alt="" />
    </div>
    <div class="breadcrumb__shape-4 z-index-4">
      <img src="/assets/img/breadcrumb/breadcrumb-sub-3.png" alt="" />
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10">
          <div class="breadcrumb__content z-index-3 text-center">
            <h3 class="breadcrumb__title tp-char-animation text-black">
              {{ trans('Our Projects') }}
            </h3>
            <div class="breadcrumb__text wow tpfadeUp" data-wow-duration=".9s" data-wow-delay=".6s">
              <p>
                {{
                  trans(
                    'We have an experienced team of production and inspection personnel to ensure quality.'
                  )
                }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumb-area-end -->

  <!--Portfolio Start-->
  <div class="portfolio-area pt-100 pb-50">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="portfolio-filter masonary-menu mb-35 text-center">
            <button
              @click="() => (selectedProjectCategory = '*')"
              :class="selectedProjectCategory === '*' ? 'active' : ''"
            >
              <span>{{ trans('All') }}</span>
            </button>

            <button
              v-for="category in categories"
              :class="selectedProjectCategory === category.id ? 'active' : ''"
              @click="() => (selectedProjectCategory = category.id)"
              :key="category"
            >
              <span>{{ category.title }}</span>
            </button>
          </div>
        </div>
      </div>
      <div v-if="filteredProjects.length > 0" class="row grid">
        <div
          v-for="project in filteredProjects"
          :key="project"
          class="col-xl-4 col-lg-6 col-md-6 col-sm-6 grid-item"
          :class="`cat${project.category_id}`"
        >
          <div class="inner-project-item mb-30">
            <div class="inner-project-img fix p-relative">
              <img class="w-100" :src="sanitizeHtml(project.preview)" alt="" />
            </div>
            <div class="inner-project-content">
              <span class="inner-project-category-title">{{ project.category?.title }}</span>
              <h4 class="inner-project-title">
                <Link :href="route('projects.show', sanitizeHtml(project.slug))">{{ project.title }}</Link>
              </h4>
              <p>
                {{ project.description }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center">
        <h3>{{ trans('No projects') }}</h3>
      </div>
    </div>
  </div>
  <!--Portfolio End-->
</template>
