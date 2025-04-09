import { reactive } from 'vue'

export const menu = reactive({
  contents: [],
  contentId: null,
  isEdit: false,
  newItem: {
    id: null,
    text: '',
    icon: '',
    href: '',
    permission: '',
    target: '_self',
    deletable: true,
    children: []
  },

  addNewItem() {
    if (this.newItem.text) {
      this.newItem.id = Math.floor(Math.random() * Date.now()).toString(36)
      const newItemCopy = JSON.parse(JSON.stringify(this.newItem))
      this.contents.push(newItemCopy)
      this.resetItem()
    }
  },
  editItem() {
    this.isEdit = true
    const item = this.findItemById(this.contents, this.contentId)
    if (item) {
      this.newItem = { ...item }
    }
  },
  updateItem() {
    const item = this.findItemById(this.contents, this.newItem.id)
    if (item && this.newItem.text) {
      Object.assign(item, this.newItem)
      this.resetItem()
      this.isEdit = false
    }
  },
  removeItemById(arr, id) {
    for (let i = 0; i < arr.length; i++) {
      if (arr[i].id === id) {
        arr.splice(i, 1)
        return
      }
      if (arr[i].children && arr[i].children.length > 0) {
        this.removeItemById(arr[i].children, id)
      }
    }
  },
  removeItem() {
    this.removeItemById(this.contents, this.contentId)
  },
  resetItem() {
    setTimeout(() => {
      this.newItem = {
        id: null,
        text: '',
        icon: '',
        href: '',
        permission: '',
        target: '_self',
        deletable: true,
        children: []
      }
    }, 500)
  },
  findItemById(arr, id) {
    for (const item of arr) {
      if (item.id === id) {
        return item
      }
      if (item.children && item.children.length > 0) {
        const found = this.findItemById(item.children, id)
        if (found) return found
      }
    }
    return null
  }
})
