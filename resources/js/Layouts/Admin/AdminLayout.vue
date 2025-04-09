<script setup>
import { onMounted, onUpdated, defineAsyncComponent } from 'vue'
import dropdown from '@root/Plugins/Admin/dropdown'

const Sidebar = defineAsyncComponent(() => import('@root/Layouts/Admin/Sidebar.vue'))
const Header = defineAsyncComponent(() => import('@root/Layouts/Admin/Header.vue'))
const ValidationErrors = defineAsyncComponent(() =>
  import('@root/Components/Admin/ValidationErrors.vue')
)
const ToastrContainer = defineAsyncComponent(() => import('@root/Components/ToastrContainer.vue'))
const ActionModal = defineAsyncComponent(() => import('@root/Components/Admin/ActionModal.vue'))

onMounted(() => dropdown.init())

onUpdated(() => dropdown.init())
</script>

<template>
  <ToastrContainer />

  <ActionModal />
  <Sidebar />
  <div class="wrapper">
    <Header />
    <ValidationErrors />
    <div class="content">
      <slot></slot>
    </div>
  </div>
</template>