import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  build: {
    outDir: '../../public/build-videoai',
    emptyOutDir: true,
    manifest: true
  },
  plugins: [
    laravel({
      publicDirectory: '../../public',
      buildDirectory: 'build-videoai',
      input: [__dirname + '/resources/js/app.js'],
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    })
  ],
  resolve: {
    alias: {
      '@modules': path.resolve(__dirname, '../'),
      '@root': path.resolve(__dirname, './../../resources/js/'),
      '@videoai': path.resolve(__dirname, './resources/js/')
    }
  }
})

//export const paths = [
//    'Modules/VideoAi/resources/assets/sass/app.scss',
//    'Modules/VideoAi/resources/assets/js/app.js',
//];
