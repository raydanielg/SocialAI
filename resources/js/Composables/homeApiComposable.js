import { ref, toValue } from 'vue'

const categories = ref([])
const categoriesFetched = ref(false)

const services = ref([])
const servicesFetched = ref(false)

export function useHomeApiComposable() {
  const getCategories = async () => {
    if (!categoriesFetched.value) {
      await fetchCategories()
    }
    return categories.value
  }

  const fetchCategories = async () => {
    const url = route('api.home-categories')

    await fetch(toValue(url))
      .then((res) => res.json())
      .then((json) => {
        categories.value = json
        categoriesFetched.value = true
      })
      .catch((err) => console.log(err))
  }

  const getServices = async () => {
    if (!servicesFetched.value) {
      await fetchCategories()
    }
    return services.value
  }

  const fetchServices = async () => {
    const url = route('api.home-services')

    await fetch(toValue(url))
      .then((res) => res.json())
      .then((json) => {
        services.value = json
        categories.value = true
      })
      .catch((err) => console.log(err))
  }

  return {
    getCategories,
    getServices
  }
}
