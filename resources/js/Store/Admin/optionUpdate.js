import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { defineStore } from 'pinia'

export const useOptionUpdateStore = defineStore('optionUpdate', () => {
    const processing = ref(false)
    function submit(key, fData, files = []) {
        processing.value = true

        files?.forEach((property) => {
            if (!(fData[property] instanceof File)) {
                fData[property] = null
            }
        })

        router.post(route('admin.page-settings.update', key), fData, {
            onFinish: () => (processing.value = false)
        })
    }

    return { processing, submit }
})
