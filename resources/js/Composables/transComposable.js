import { ref } from 'vue'

const file = ref(null)

if (!file.value) {
    const data = document.querySelector('meta[name="app-translations"]')?.content
    file.value = JSON.parse(data ?? '{}')
}

export default function trans(key) {
    if (file.value.hasOwnProperty(key)) {
        return file.value[key]
    }

    return key
}
