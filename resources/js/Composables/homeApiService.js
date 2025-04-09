import { ref, toValue } from 'vue'

const properties = ref({
  categories: {
    apiUrl: route('api.home-categories')
  },

  featuredCategories: {
    apiUrl: route('api.home-featured-categories')
  },
  
  featuredServices: {
    apiUrl: route('api.home-featured-services')
  },

  popularCategories: {
    apiUrl: route('api.home-popular-categories')
  },

  services: {
    apiUrl: route('api.home-services')
  },
  experts: {
    apiUrl: route('api.home-experts')
  },

  features: {
    apiUrl: route('api.home-features')
  },
  feedbacks: {
    apiUrl: route('api.home-feedbacks')
  },
  brands: {
    apiUrl: route('api.home-brands')
  },
  blogs: {
    apiUrl: route('api.home-blogs')
  },
  faqs: {
    apiUrl: route('api.home-faqs')
  },
  companies: {
    apiUrl: route('api.home-companies')
  },
  jobList: {
    apiUrl: route('api.home-jobs-list')
  },
  totalJobsCount: {
    apiUrl: route('api.total-jobs-count')
  },
  countries: {
    apiUrl: route('api.locations')
  }
})

const get = async propertyKey => {
  let module = properties.value[propertyKey]
  if (!module) {
    console.error(`The module: ${propertyKey} is not supported for lazyApiService`)
    return false
  }
  if (!module.apiUrl) {
    console.error(`The module: ${propertyKey}.apiUrl is not set for lazyApiService`)
    return false
  }

  // now we have valid module and apiURL
  if (!module.isFetched) {
    await fetch(toValue(module.apiUrl))
      .then(res => res.json())
      .then(json => {
        module.items = json
        module.isFetched = true
      })
      .catch(err => console.error(err))
  }
  return module.items
}

export default {
  get
}
