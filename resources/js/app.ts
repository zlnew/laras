import './bootstrap';

// cores
import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

// laravel configuration
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// plugins
import pinia from '@/plugins/pinia';
import Quasar from '@/plugins/quasar';

// directives
import inertiaLink from '@/directives/inertia-link';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(Quasar, {
                plugins: {}
            })
            .directive('inLink', inertiaLink)
            .mount(el);
    },
    progress: { color: '#0284c7' },
});