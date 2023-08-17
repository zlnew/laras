import './bootstrap'
import '../css/app.css'

// cores
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

// laravel configuration
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

// plugins
import { quasar, plugins } from '@/plugins/quasar'

// directives
import InertiaLink from '@/directives/inertia-link'

const titleElement = window.document.getElementsByTagName('title')[0]
const appName = titleElement?.innerText !== undefined ? titleElement?.innerText : 'Laravel'

await createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: async (name) => await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup ({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(quasar, { plugins })
      .directive('in-link', InertiaLink)
      .mount(el)
  },
  progress: { color: '#0284c7' }
})
