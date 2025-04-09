import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import trans from '@/Composables/transComposable'

export const modal = reactive({
  state: false,
  link: null,
  method: 'delete',
  data: null,
  confirm_text: null,
  message: null,
  accept_btn_text: null,
  reject_btn_text: null,
  callback: null,

  init(link = null, { method, data = {}, options = {}, callback }) {
    this.link = link
    this.message = options?.message || this.message
    this.confirm_text = options?.confirm_text || trans('Are you sure?')
    this.accept_btn_text = options?.accept_btn_text || 'Yes, Confirm!'
    this.reject_btn_text = options?.reject_btn_text || 'No, Cancel!'

    if (callback instanceof Function) {
      this.callback = callback
    }

    if (method && data) {
      this.method = method
      this.data = data
    }
    this.state = true
  },

  initCallback(callFn, options = {}) {
    this.init(null, { callback: callFn, options })
  },

  async accept() {
    const validMethods = ['post', 'put', 'patch', 'delete']
    const { method, link, data, callback } = this

    if (link && validMethods.includes(method)) {
      if (method == 'delete') {
        router.delete(link)
      } else {
        router[method](link, data)
      }
    }

    if (link && !validMethods.includes(method)) {
      router.delete(link)
    }

    if (callback instanceof Function) {
      callback()
    }

    this.state = false
  },

  reset() {
    Object.assign(this, {
      link: null,
      state: false,
      method: 'delete',
      data: null,
      message: 'You want to delete this?',
      confirm_text: trans('Are you sure?'),
      accept_btn_text: 'Yes, delete it!',
      reject_btn_text: 'No, Cancel!'
    })
  }
})
