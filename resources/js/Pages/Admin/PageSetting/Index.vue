<script setup>
import { onMounted } from "vue";

import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import About from "@/Pages/Admin/PageSetting/About.vue";
import AuthPages from "@/Pages/Admin/PageSetting/AuthPages.vue";
import Career from "@/Pages/Admin/PageSetting/Career.vue";
import Contact from "@/Pages/Admin/PageSetting/Contact.vue";
import Home from "@/Pages/Admin/PageSetting/Home.vue";
import Integration from "@/Pages/Admin/PageSetting/Integration.vue";
import Primary from "@/Pages/Admin/PageSetting/Primary.vue";
import Service from "@/Pages/Admin/PageSetting/Service.vue";
import tabs from "@/Plugins/Admin/tabs";

defineOptions({ layout: AdminLayout })

const props = defineProps([
  "buttons",
  "primary_data",
  "auth_pages",

  "home_page",
  "career_page",
  "service_page",
  "about_page",
  "contact_page",
  "integration_page",
])
onMounted(() => {
  tabs.init()
})
</script>

<template>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Page Settings" :buttons="buttons" />

    <div class="space-y-6">
      <div class="card">
        <div class="card-body">
          <div class="tabs tabs-vertical">
            <ul class="tabs-list w-72">
              <li class="tabs-item">
                <button class="tabs-btn active" data-panel-id="#primary" type="button">
                  <span>{{ trans("Primary") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#auth" type="button">
                  <span>{{ trans("Auth Pages") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#home" type="button">
                  <span>{{ trans("Home Page") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#about" type="button">
                  <span>{{ trans("About Page") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#career" type="button">
                  <span>{{ trans("Career Page") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#service" type="button">
                  <span>{{ trans("Service Page") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#integration" type="button">
                  <span>{{ trans("Integration Page") }}</span>
                </button>
              </li>

              <li class="tabs-item">
                <button class="tabs-btn" data-panel-id="#contact" type="button">
                  <span>{{ trans("Contact Page") }}</span>
                </button>
              </li>
            </ul>

            <div class="tabs-content h-[80vh]" data-simplebar>
              <div class="tabs-panel active" id="primary">
                <Primary :data="primary_data" />
              </div>

              <div class="tabs-panel" id="auth">
                <AuthPages :data="auth_pages" />
              </div>

              <div class="tabs-panel" id="home">
                <Home :data="home_page" />
              </div>

              <div class="tabs-panel" id="about">
                <About :data="about_page" />
              </div>

              <div class="tabs-panel" id="contact">
                <Contact :data="contact_page" />
              </div>

              <div class="tabs-panel" id="career">
                <Career :data="career_page" />
              </div>

              <div class="tabs-panel" id="service">
                <Service :data="service_page" />
              </div>
              <div class="tabs-panel" id="integration">
                <Integration :data="integration_page" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
