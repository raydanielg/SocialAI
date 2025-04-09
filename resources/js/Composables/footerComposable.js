import { computed, ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import toast from '@/Composables/toastComposable'

export default () => {
  const footerCenter = computed(() => {
    return usePage().props.menus.find((item) => item.position.includes('footer-center')) || []
  })

  const footerRight = computed(() => {
    return usePage().props.menus.find((item) => item.position.includes('footer-right')) || []
  })

  const footerLeft = computed(() => {
    return usePage().props.menus.find((item) => item.position.includes('footer-left')) || []
  })

  const year = computed(() => {
    return new Date().getFullYear()
  })
  const socials = computed(() => {
    return usePage().props.primaryData['socials']
  })
  // newsletter
  const email = ref('')
  const subscribe = () => {
    if (email.value) {
      router.post(
        route('newsletter.subscribe'),
        { email: email.value },
        {
          preserveScroll: true,
          onSuccess: () => {
            email.value = ''
            toast.success('Subscribed successfully')
          }
        }
      )
    }
  }
  const NEWSLETTER_API = computed(() => usePage().props.newsletter_api)
  return {
    footerCenter,
    footerRight,
    footerLeft,
    year,
    socials,
    email,
    subscribe,
    NEWSLETTER_API
  }
}
