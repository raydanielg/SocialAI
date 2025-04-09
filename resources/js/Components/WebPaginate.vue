<template>
  <div v-if="links.length > 3">
    <div
      class="pagination-one d-flex align-items-center justify-content-center justify-content-sm-start style-none"
    >
      <template v-for="(link, key) in links" :key="key">
        
        <template v-if="link.label.includes('Next') && link.url === null">
          <li class="ms-2">
            <span class="d-flex align-items-center"
              >{{ 'Next' }} <img src="/assets/images/icon/icon_42.svg" alt="" class="ms-2"
            /></span>
          </li>
        </template>

        <li v-else :class="{ active: link.active }">
          <Link :key="`link-${key}`" :href="link.url ?? '#'">
            <template v-if="link.label.includes('Next')">
              <li class="ms-2">
                <span class="d-flex align-items-center"
                  >{{ 'Next' }} <img src="/assets/images/icon/icon_50.svg" alt="" class="ms-2"
                /></span>
              </li>
            </template>
            <template v-else-if="link.label.includes('Previous')"> </template>
            <span v-else v-html="sanitizeHtml(link.label)"></span>
          </Link>
        </li>
      </template>
    </div>
  </div>
</template>

<script setup>
defineProps({ links: Array })
</script>
