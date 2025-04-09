import '@root/bootstrap'
import '@vueform/multiselect/themes/default.css'
import { createSSRApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import VueLazyLoad from 'vue3-lazyload'
import { Icon } from '@iconify/vue'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import trans from '@root/Composables/transComposable'
import sharedComposable from '@root/Composables/sharedComposable'
import Link from '@root/Components/Link.vue'
const { sanitizeHtml } = sharedComposable()
const appName = document.querySelector('meta[name="app-name"]')?.content || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .mixin({ methods: { trans, route: window.route, sanitizeHtml } })
      .component('Link', Link)
      .component('Icon', Icon)
      .use(plugin)
      .use(VueLazyLoad)
      .use(createPinia())
      .mount(el)
  },
  progress: {
    color: '#d2f34c',
    showSpinner: true
  }
})
