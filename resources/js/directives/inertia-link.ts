import { router } from '@inertiajs/vue3'

function visit (path: string, method: 'get' | 'post' | 'put' | 'delete' = 'get') {
  router.visit(path, { method })
}

const InertiaLink = {
  mounted (el: unknown, binding: any) {
    if (el instanceof HTMLElement) {
      el.style.cursor = 'pointer'
      el.addEventListener('click', () => {
        visit(binding.value, binding.arg)
      })
    }
  },
  unmounted (el: unknown, binding: any) {
    if (el instanceof HTMLElement) {
      el.removeEventListener('click', () => {
        visit(binding.value, binding.arg)
      })
    }
  }
}

export default InertiaLink
