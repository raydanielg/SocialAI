import './bootstrap'
import '@vueform/multiselect/themes/default.css'
import { createSSRApp, h, ref } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import VueLazyLoad from 'vue3-lazyload'
import { Icon } from '@iconify/vue'
import './../../public/assets/css/payment.css'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import trans from '@/Composables/transComposable'
import Link from './Components/Link.vue'
import sharedComposable from '@/Composables/sharedComposable.js'
const { sanitizeUrl, sanitizeHtml } = sharedComposable()

const appName = document.querySelector('meta[name="app-name"]')?.content || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createSSRApp({ render: () => h(App, props) })
      .mixin({ methods: { trans, route: window.route, sanitizeUrl, sanitizeHtml } })
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
