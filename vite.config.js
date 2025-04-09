import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import DefineOptions from 'unplugin-vue-define-options/vite'
export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.js', 'resources/css/app.css', 'resources/scss/admin/main.scss'],
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    DefineOptions()
  ],
  resolve: {
    alias: {
      '@root': path.resolve(__dirname, 'resources/js'),
      '@modules': path.resolve(__dirname, 'modules'),
      '@videoai': path.resolve(__dirname, 'modules/Videoai/resources/js/')
    }
  }
})
