import { reactive } from 'vue'

export default reactive({
  position: 'position-top-right',
  items: [],
  set({ type, message }, position) {
    if (!this.position) {
      this.position = 'position-top-right'
    }
    if (position) {
      this.position = position
    }
    this.items.unshift({
      key: Symbol(),
      type,
      message
    })
  },
  setSessionToast(toast) {
    if (sessionStorage.getItem('backNavigation')) {
      sessionStorage.removeItem('backNavigation')
      return
    }

    if (toast && Object.keys(toast).length > 0) {
      for (const [key, value] of Object.entries({ ...toast })) {
        if (Array.isArray(value)) {
          value.forEach((msg) => setTimeout(() => this.set({ type: key, message: msg })), 0)
        } else {
          setTimeout(() => this.set({ type: key, message: value }), 0)
        }
      }
    }
  },
  success(message, position) {
    this.set({ type: 'success', message: message }, position)
  },
  danger(message, position) {
    this.set({ type: 'danger', message: message }, position)
  },
  warning(message, position) {
    this.set({ type: 'warning', message: message }, position)
  },
  info(message, position) {
    this.set({ type: 'info', message: message }, position)
  },
  remove(index) {
    this.items.splice(index, 1)
  }
})

window.addEventListener('popstate', () => {
  sessionStorage.setItem('backNavigation', 'true')
})
