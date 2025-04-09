import { defineStore } from 'pinia'

export const useModalStore = defineStore({
  id: 'modal',
  state: () => ({
    states: {}
  }),

  actions: {
    validateKey(key) {
      // Check if the key is a valid format
      if (/^[a-zA-Z0-9-]+$/.test(key)) {
        return key
      }
      // Convert the key to a valid format
      return key.replace(/[^a-zA-Z0-9-]/g, '-').toLowerCase()
    },
    open(key) {
      const validKey = this.validateKey(key)

      if (this.states.hasOwnProperty(validKey)) {
        return (this.states[validKey] = false)
      }

      this.states[validKey] = true
      document.body.style.overflow = 'hidden'
    },
    close() {
      document.body.style.overflow = ''
      this.$reset()
    }
  },
  getters: {
    getState: (state) => (key) => {
      let validKey = key

      if (!/^[a-zA-Z0-9-]+$/.test(validKey)) {
        validKey = key.replace(/[^a-zA-Z0-9-]/g, '-').toLowerCase()
      }

      return (state.states.hasOwnProperty(validKey) && state.states[validKey]) || false
    }
  }
})
