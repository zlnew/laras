import { router } from '@inertiajs/vue3';

function visit(path: string, method: 'get' | 'post' | 'put' | 'delete' = 'get') {
  router.visit(path, {
    method: method
  });
}

const inertiaLink =  {
  mounted(el: unknown, binding: any) {
    if (el instanceof HTMLElement) {
      el.style.cursor = 'pointer';    
  
      el.addEventListener('click', () => {
        visit(binding.value, binding.arg);
      });
    }
  },
  unmounted(el: unknown) {
    if (el instanceof HTMLElement) {
      el.removeEventListener('click', () => {
        visit
      });
    }
  }
}

export default inertiaLink;