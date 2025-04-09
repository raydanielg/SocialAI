import { defineStore } from 'pinia'
import { fabric } from 'fabric'
import { router, useForm } from '@inertiajs/vue3'
let canvas = null

export const useDesignStore = defineStore({
  id: 'designStore',
  state: () => ({
    textSizes: ['60', '40', '30', '20', '16'],
    shapes: ['octangle', 'pentagon', 'square'],
    tabLists: [
      {
        label: 'settings',
        icon: 'bx-cog'
      },
      {
        label: 'text',
        icon: 'bx-text'
      },
      {
        label: 'image',
        icon: 'bx-image-alt'
      },
      {
        label: 'shapes',
        icon: 'bxs-shapes'
      },
      {
        label: 'placeholder',
        icon: 'bx-flag'
      }
    ],
    fontLists: [
      'Classica',
      'Butler',
      'Roboto',
      'Open Sans',
      'Lato',
      'Oswald',
      'Raleway',
      'Montserrat'
    ],
    selectedObject: null,
    activeObject: null,
    saveCanvasJson: null,
    tab: 'settings',
    form: useForm({
      canvas: null,
      placeholder: null,
      title: '',
      status: 'inactive'
    }),
    placeholders: {
      image: false,
      logo: false,
      slogan: false
    },
    textStyles: {
      fontSize: 20,
      fontFamily: 'Arial',
      fill: 'white',
      fontWeight: 'normal',
      fontStyle: 'normal',
      underline: false,
      textAlign: 'center',
      fill: 'white',
      backgroundColor: 'transparent'
    },
    shapeStyles: {
      fill: '',
      stroke: ''
    },
    objectStyles: {},
    canvasStyles: {
      preserveObjectStacking: true,
      backgroundColor: 'transparent',
      width: 500,
      height: 500
    },
    imageStyles: {
      cornerRadius: 0
    },
    objectOpacity: 100,
    canvasLoading: false
  }),
  actions: {
    setTab(tab) {
      this.selectedObject = null
      this.tab = tab
    },
    objectSelected() {
      const activeObject = canvas.getActiveObject()
      this.selectedObject = activeObject.type
      console.log(activeObject)
      if (activeObject.type === 'activeSelection') {
        return
      }

      if (activeObject.isType('i-text')) {
        this.textStyles.fontSize = activeObject.fontSize
        this.textStyles.fontFamily = activeObject.fontFamily
        this.textStyles.fontWeight = activeObject.fontWeight
        this.textStyles.fontStyle = activeObject.fontStyle || 'normal'
        this.textStyles.fill = activeObject.fill
        this.textStyles.backgroundColor = activeObject.backgroundColor || 'transparent'
      } else if (activeObject.isType('group')) {
        this.objectStyles = activeObject.getObjects()
      } else if (['rect', 'path', 'polygon', 'circle'].includes(activeObject.type)) {
        this.selectedObject = 'shape'
        this.shapeStyles.fill = activeObject.fill
        this.shapeStyles.stroke = activeObject.stroke
      }
      this.tab = null
    },
    objectDeselected() {
      this.selectedObject = null
      if (!this.tab) {
        this.tab = 'settings'
      }
    },
    initializeCanvas(el, imageUrl = null) {
      canvas = new fabric.Canvas(el, this.canvasStyles)
      canvas.on('selection:created', this.objectSelected)
      canvas.on('selection:updated', this.objectSelected)
      canvas.on('selection:cleared', this.objectDeselected)

      // Create a new Image object
      if (imageUrl) {
        var background = new Image()
        background.src = imageUrl
        console.log(background.width, background.height)
        // Wait for the image to load
        background.onload = function () {
          // Set the background image
          canvas.setBackgroundImage(imageUrl, canvas.renderAll.bind(canvas), {
            scaleX: canvas.width / background.width,
            scaleY: canvas.height / background.height,
            backgroundImageStretch: true
          })
        }
      }
    },
    loadCanvasFromJSON(data, form) {
      let dataObjects = data.objects
      for (let obj of dataObjects) {
        if (obj.id === 'placeholderImage') {
          this.placeholders.image = true
        }
        if (obj.id === 'placeholderLogo') {
          this.placeholders.logo = true
        }
        if (obj.id === 'slogan') {
          this.placeholders.slogan = true
        }
        if (obj.type === 'i-text' && obj.left < 51) {
          let left

          if (obj.left < 50) {
            left = Math.abs(obj.left + 50)
          }
          if (obj.left < 0) {
            left = Math.abs(obj.left + 100)
          }
          obj.left += left
        }
      }
      canvas.loadFromJSON(JSON.stringify(data), function () {
        canvas.renderAll()
      })
      this.form.title = form?.title || form?.category_id
      this.form.status = form.status
    },
    changeSelectedTextStyle() {
      const activeObject = canvas.getActiveObject()
      activeObject.set({ ...this.textStyles })
      canvas.requestRenderAll()
    },
    changeShapeStyle() {
      const activeObject = canvas.getActiveObject()
      activeObject.set({ ...this.shapeStyles })
      canvas.renderAll()
    },
    changeGroupObjectStyle() {
      this.canvasLoading = true
      const activeObject = canvas.getActiveObject()
      activeObject.getObjects().forEach((object, index) => {
        object.set(this.objectStyles[index])
      })
      activeObject.dirty = true
      setTimeout(() => canvas.requestRenderAll(), 0)
      this.canvasLoading = false
    },
    changeCanvasStyle() {
      canvas.backgroundColor = this.canvasStyles.backgroundColor
      canvas.renderAll()
    },
    changeImageStyle() {
      if (this.imageStyles.cornerRadius > 100) {
        return
      }
      const activeObject = canvas.getActiveObject()
      const roundedCorners = (object, cornerRadius) =>
        new fabric.Rect({
          width: object.width,
          height: object.height,
          rx: cornerRadius / object.scaleX,
          ry: cornerRadius / object.scaleY,
          left: -object.width / 2,
          top: -object.height / 2
        })
      activeObject.clipPath = roundedCorners(activeObject, this.imageStyles.cornerRadius)
      activeObject.dirty = true
      setTimeout(() => canvas.requestRenderAll(), 500)
    },
    setText(size) {
      const text = new fabric.IText('Text', {
        left: 10,
        top: 10,
        fontSize: size,
        fontFamily: 'Arial',
        fill: '#ffffff',
        fontWeight: 'normal',
        underline: false,
        textAlign: 'center',
        textBackgroundColor: 'transparent'
      })
      canvas.add(text)
      canvas.renderAll()
    },
    setShape(link) {
      this.canvasLoading = true
      fabric.loadSVGFromURL(link, (objects, options) => {
        let obj = fabric.util.groupSVGElements(objects, options)
        obj.set({ left: 10, top: 10, subTargetCheck: true })
        canvas.add(obj)
       
        canvas.renderAll()
        this.canvasLoading = false
      })
    },
    bringToFront() {
      canvas.bringToFront(canvas.getActiveObject())
      canvas.renderAll()
    },
    sendToBack() {
      canvas.sendToBack(canvas.getActiveObject())
      canvas.renderAll()
    },

    uploadImage(e) {
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
    },
    addPlaceholderSlogan() {
      if (this.placeholders.slogan) {
        return
      }
      const text = new fabric.IText('Your text here', {
        left: 10,
        top: 10,
        fontSize: 20,
        fontFamily: 'Arial',
        fill: 'white',
        fontWeight: 'bold',
        id: 'slogan'
      })
      canvas.add(text)
      canvas.renderAll()
      this.placeholders.slogan = true
    },
    addPlaceholderFile(url, id, key) {
      if (this.placeholders[key]) {
        return
      }
      fabric.Image.fromURL(url, function (img) {
        img.scale(0.2).set({
          left: 100,
          top: 100,
          id: id
        })
        canvas.add(img)
      })
      canvas.renderAll()
      this.placeholders[key] = true
    },
    submit(status, id = null) {
      this.form.canvas = JSON.stringify(canvas.toJSON(['id']))
      this.form.placeholder = canvas.toDataURL()
      if (status) {
        this.form.status = status
      }
      const routeLink = id ? route('admin.design.update', id) : route('admin.design.store')
      const method = id ? 'patch' : 'post'
      this.form[method](routeLink, {
        onSuccess: () => {
          this.$reset()
        }
      })
    },
    submitImage(uuid, saveType = 'copy') {
      const form = {
        _method: 'PATCH',
        image: canvas.toDataURL({
          width: 500,
          height: 500
        }),
        saveType: saveType
      }

      router.post(route('user.assets.update', uuid), form, {
        onSuccess: () => {
          this.$reset()
        }
      })
    },
    submitLogo(status, id = null) {
      let preview = canvas.toDataURL()
      if (status) {
        this.form.status = status
      }
      const form = {
        preview: preview,
        category_id: this.form.title,
        status: this.form.status,
        canvas: JSON.stringify(canvas.toJSON(['id']))
      }
      const routeLink = id
        ? route('admin.brand-logos.update', id)
        : route('admin.brand-logos.store')
      const method = id ? 'patch' : 'post'
      router[method](routeLink, form, {
        onSuccess: () => {
          this.$reset()
        }
      })
    },
    remove() {
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
    },
    changeObjectOpacity() {
      const activeObject = canvas.getActiveObject()
      activeObject.opacity = this.objectOpacity / 100
      canvas.renderAll()
    }
  },
  getters: {
    getTabState: (state) => {
      return (key) => state.tab == key
    },
    getSelectedObjectState: (state) => {
      return (key) => state.selectedObject == key
    }
  }
})
