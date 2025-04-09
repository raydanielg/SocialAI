import { reactive } from 'vue'
import sharedComposable from '@/Composables/sharedComposable'

export default reactive({
  status: '',
  message: '',
  checkPlan(planKey, resourceCount) {
    const { authUser } = sharedComposable()
    if (!authUser.value.plan_data || !authUser.value.will_expire) {
      this.status = 'danger'
      this.message = 'You have not purchased a plan.'
      return
    }

    const expirationDate = new Date(authUser.value.will_expire)
    if (expirationDate < new Date()) {
      this.status = 'danger'
      this.message = 'Your plan has expired. Please renew your plan!'
      return
    }

    const planValue = authUser.value?.plan_data[planKey]?.value

    if (planValue === -1) {
      this.status = 'success'
      return
    }
    if (typeof planValue === 'boolean') {
      if (!planValue) {
        this.status = 'danger'
        this.message = 'The feature is not available in your plan. Please upgrade your plan.'
      } else {
        this.status = 'success'
      }
    }
    if (planValue !== -1 && resourceCount >= planValue) {
      this.status = 'danger'
      this.message = `You have reached your ${planKey} limit. Please upgrade your plan.`
    } else {
      this.status = 'success'
    }
  }
})
