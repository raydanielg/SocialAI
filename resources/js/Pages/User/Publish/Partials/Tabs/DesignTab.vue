<script setup>
import HollowDotsSpinner from '@/Components/HollowDotsSpinner.vue'
import { usePublishStore } from '@/Store/publishStore'
import { ref, onMounted, watch } from 'vue'
import { fabric } from 'fabric'
import axios from 'axios'
import toast from '@/Composables/toastComposable'
import { useDesignStore } from '@/Store/Admin/designStore'
import Multiselect from '@vueform/multiselect'
const designStore = useDesignStore()
defineProps(['designs'])

const store = usePublishStore()
let canvasEl = ref(null)
let textStyles = ref('Arial')
let textSize = ref(20)
let staticCanvas = null
let canvas = null

const selectedObject = ref(false)

const image = ref(store.getOriginalMedia, '')

onMounted(() => {
  staticCanvas = new fabric.StaticCanvas()
  canvas = new fabric.Canvas(canvasEl.value, {
    preserveObjectStacking: true,
    backgroundColor: 'transparent',
    width: 500,
    height: 500
  })
  canvas.on('selection:created', objectSelected)
  canvas.on('selection:updated', objectSelected)
  canvas.on('selection:cleared', objectDeselected)
})

watch(
  () => store.designEditor,
  () => {
    if (store.designEditor) editDesign()
  }
)
const replaceCanvasObjects = (stage = 'last') => {
  for (let obj of store.dataObjects.objects) {
    if (obj.id === 'placeholderImage') {
      obj.src = store.getOriginalMedia ?? image.value ?? '/assets/img/about/about-bg-shape.png'
      obj.crossOrigin = 'anonymous'
    }
    if (obj.id === 'placeholderLogo') {
      obj.src = store.form?.brand?.logo ?? '/assets/img/about/about-bg-shape.png'
      obj.crossOrigin = 'anonymous'
    }
    if (obj.id === 'slogan' && stage == 'initial') {
      obj.text = store.form.slogan ?? 'Slogan'
    }
  }
}

const changeImage = async (data, id) => {
  const activePlatform = store.getActivePlatformContent()
  const selectedDesign = store.selectedDesigns?.find((item) => item.platform === store.platformTab)

  const updatePlatforms = (updatedPlatform) => {
    const updatedPlatforms = store.form.platforms.map((platform) => {
      if (platform.platform === store.platformTab) {
        return { ...updatedPlatform }
      }
      return platform
    })
    return updatedPlatforms
  }

  if (selectedDesign) {
    activePlatform.media = []
    const updatedDesigns = store.selectedDesigns.filter(
      (item) => item.platform !== selectedDesign.platform
    )
    store.$patch({
      selectedDesigns: updatedDesigns,
      form: { platforms: updatePlatforms(activePlatform) }
    })
    return
  }

  if (
    store.getActivePlatformContent('media_type') !== 'image' ||
    store.getActivePlatformContent('media')?.length < 1
  ) {
    toast.danger('Select an image')
    return
  }

  if (store.getActivePlatformContent('media').length > 1) {
    toast.danger('Multiple images not supported')
    return
  }

  const newDesign = {
    platform: store.platformTab,
    design: id
  }

  store.$patch({
    isDesignProcessing: true,
    selectedDesigns: [...store.selectedDesigns, newDesign],
    dataObjects: data
  })

  await axios
    .post(route('api.publish.process_image'), {
      image: store.getActivePlatformContent('media')[0],
      type: store.platformSelectedMediaFrom
    })
    .then((res) => {
      image.value = res.data.image
      const originalMedia = {
        platform: store.platformTab,
        media: res.data.image
      }
      const filterMedia = store.originalSelectedMedias.filter(
        (media) => media.platform !== store.platformTab
      )
      store.$patch({ originalSelectedMedias: [...filterMedia, originalMedia] })
    })
    .catch((err) => {
      toast.danger(err.response.data)
    })

  replaceCanvasObjects('initial')
  staticCanvas.loadFromJSON(JSON.stringify(store.dataObjects), function () {
    staticCanvas.renderAll()
    activePlatform.media[0] = staticCanvas.toDataURL({
      width: 500,
      height: 500
    })
    setTimeout(() => {
      store.$patch({
        isDesignProcessing: false,
        form: { platforms: updatePlatforms(activePlatform) }
      })
    }, 2000)
  })
}
const editDesign = () => {
  loadCanvasFromJSON()
}
const loadCanvasFromJSON = () => {
  replaceCanvasObjects()
  canvas.loadFromJSON(JSON.stringify(store.dataObjects), function () {
    canvas.renderAll()
  })
}
const objectSelected = () => {
  const activeObject = canvas.getActiveObject()
  selectedObject.value = activeObject.type
  if (activeObject.isType('i-text')) {
    textSize.value = activeObject.fontSize
  }
  if (activeObject.type === 'activeSelection') {
    return
  }
}

const setText = () => {
  const text = new fabric.IText('Insert text', {
    left: 20,
    top: 20,
    fontSize: 24,
    fontFamily: 'Arial',
    fill: '#ffffff',
    fontWeight: 'normal',
    underline: false,
    textAlign: 'center',
    textBackgroundColor: 'transparent'
  })
  canvas.add(text)
  canvas.renderAll()
}
const uploadImage = (e) => {
  const reader = new FileReader()
  reader.onload = function (e) {
    fabric.Image.fromURL(e.target.result, function (img) {
      img.scale(0.2).set({
        left: 200,
        top: 100
      })
      canvas.add(img)
    })
  }
  reader.readAsDataURL(e.target.files[0])
}
const remove = () => {
  const activeObject = canvas.getActiveObjects()
  if (activeObject.length) {
    if (confirm('Do you want to delete the selected items?')) {
      activeObject.forEach(function (object) {
        canvas.remove(object)
      })
    }
  } else {
    canvas.remove(canvas.getActiveObject())
  }

  canvas.renderAll()
}
const bringToFront = () => {
  canvas.bringToFront(canvas.getActiveObject())
  canvas.renderAll()
}
const sendToBack = () => {
  canvas.sendToBack(canvas.getActiveObject())
  canvas.renderAll()
}
const objectDeselected = () => {
  selectedObject.value = null
}
const reRender = () => {
  store.$patch({ isDesignProcessing: true, dataObjects: canvas.toJSON(['id']) })

  replaceCanvasObjects()
  const activePlatform = store.getActivePlatformContent()
  staticCanvas.loadFromJSON(JSON.stringify(store.dataObjects), function () {
    staticCanvas.renderAll()
    activePlatform.media[0] = staticCanvas.toDataURL({
      width: 500,
      height: 500
    })
    const platforms = store.form.platforms.map((platform) => {
      if (platform.platform === store.platformTab) {
        return { ...activePlatform }
      }
      return platform
    })
    setTimeout(() => store.$patch({ isDesignProcessing: false, form: { platforms } }), 3000)
  })
}
const changeSelectedTextStyle = () => {
  const activeObject = canvas.getActiveObject()
  activeObject.set({
    fontFamily: textStyles.value,
    fontSize: textSize.value
  })
  canvas.requestRenderAll()
}
</script>

<template>
  <div
    v-show="store.designEditor"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
  >
    <div class="max-h-[700px] max-w-[900px] rounded-md bg-secondary-100 p-6 dark:bg-secondary-800">
      <div class="mb-4 flex items-center justify-between">
        <h6>Modify design</h6>
        <button type="button" @click="store.$patch({ designEditor: false })">
          <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
            <path
              fill="currentColor"
              d="m12 13.4l-2.9 2.9q-.275.275-.7.275t-.7-.275q-.275-.275-.275-.7t.275-.7l2.9-2.9l-2.9-2.875q-.275-.275-.275-.7t.275-.7q.275-.275.7-.275t.7.275l2.9 2.9l2.875-2.9q.275-.275.7-.275t.7.275q.3.3.3.713t-.3.687L13.375 12l2.9 2.9q.275.275.275.7t-.275.7q-.3.3-.713.3t-.687-.3L12 13.4Z"
            />
          </svg>
        </button>
      </div>
      <div class="grid grid-cols-2 place-content-center gap-5 md:grid-cols-12">
        <div
          class="col-span-full space-y-6 rounded-md bg-secondary-200 p-3 dark:bg-secondary-900 md:col-span-4"
        >
          <div class="mt-2">
            <label class="label mb-1">{{ trans('Font Family') }}</label>
            <Multiselect
              @select="changeSelectedTextStyle"
              class="multiselect-dark"
              v-model="textStyles"
              mode="single"
              :options="designStore.fontLists"
              :searchable="true"
              placeholder="Select Fonts"
            >
              <template v-slot:singlelabel="{ value }">
                <div class="multiselect-single-label">
                  <span :style="{ fontFamily: `${value.label}` }">{{ value.label }}</span>
                </div>
              </template>

              <template v-slot:option="{ option }">
                <span :style="{ fontFamily: `${option.label}` }">{{ option.label }}</span>
              </template>
            </Multiselect>
          </div>
          <div class="flex justify-between">
            <span class="text-lg">Size</span>
            <input
              v-model="textSize"
              @input="changeSelectedTextStyle"
              type="text"
              class="input w-20"
            />
          </div>
          <button
            @click="setText"
            class="w-full rounded-md border bg-secondary-100 py-2 text-center shadow hover:bg-opacity-50 dark:border-secondary-600 dark:bg-secondary-700 dark:hover:bg-opacity-50"
          >
            {{ trans('Insert text') }}
          </button>
          <input @input="uploadImage" accept="image/*" type="file" class="input" />
        </div>
        <div class="col-span-full flex flex-col justify-end md:col-span-8">
          <div
            class="mx-auto mb-2 flex max-w-max items-center gap-1 rounded-md bg-secondary-200 dark:bg-secondary-900"
          >
            <button
              @click="bringToFront"
              class="btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"
            >
              <i class="bx bxs-arrow-from-bottom text-xl"></i>
            </button>
            <button
              @click="sendToBack"
              class="btn px-2 py-1 hover:bg-primary-800/60 hover:text-white"
            >
              <i class="bx bxs-arrow-from-top text-xl"></i>
            </button>
            <button @click="remove" class="btn p-2 hover:bg-primary-800/60 hover:text-white">
              <i class="bx bxs-trash-alt"></i>
            </button>
          </div>
          <canvas
            ref="canvasEl"
            class="ml-auto h-[500px] w-[500px] rounded border border-secondary-200 dark:border-secondary-700"
          ></canvas>
        </div>
      </div>
      <div class="mt-4 flex justify-end">
        <button @click="reRender" class="btn btn-primary">
          <HollowDotsSpinner
            v-if="store.isDesignProcessing"
            dotClass="dot-white"
            class="flex w-20 items-center justify-center"
          />
          <span v-else>Re Render</span>
        </button>
      </div>
    </div>
  </div>

  <label class="label mb-3 text-lg">Slogan</label>
  <input type="text" v-model="store.form.slogan" class="input mb-2" placeholder="Slogan" />

  <div class="mb-4 mt-2 flex items-center gap-3">
    <button
      :disabled="store.loading.slogan"
      type="button"
      @click="store.generateContent('slogan')"
      class="btn btn-soft-primary w-full"
    >
      <svg
        v-if="store.loading.slogan"
        class="my-1.5 mr-px h-5 w-5 animate-spin text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
      <i class="bx bx-refresh text-2xl" v-else></i>
      <span>Regenerate</span>
    </button>
  </div>

  <h5 class="mb-3 border-b border-secondary-300 pb-4 pt-2 dark:border-gray-700">Designs</h5>
  <p class="mb-3 text-lg text-secondary-400">Frames</p>
  <div
    class="grid grid-cols-1 place-items-center gap-5 overflow-y-auto sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2"
  >
    <template v-if="designs.length > 0">
      <button
        v-for="(design, i) in designs"
        :key="i"
        class="h-64 overflow-hidden rounded-lg border dark:border-gray-600"
        :class="{
          'border-2 border-primary-500 dark:border-primary-500': store.selectedDesigns?.find(
            (d) => d.platform == store.platformTab && d.design == design.id
          )
        }"
        @click="changeImage(design.canvas, design.id)"
      >
        <img v-lazy="design.placeholder" class="h-full w-full object-cover" alt="image" />
      </button>
    </template>
  </div>
</template>
