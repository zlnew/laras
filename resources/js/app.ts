import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from "pinia";
import { EaseButton, useEaseButton } from 'ease-button-ui';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { fas } from '@fortawesome/free-solid-svg-icons';

library.add(fas)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('FasIcon', FontAwesomeIcon)
            .component('EaseButton', EaseButton)
            .use(pinia)
            .mount(el);
            
        const easeButton = useEaseButton();
        
        easeButton.defaultStyle({
            bgColor: '#172554',
            borderRadius: '0.5rem',
            outlineColor: '#172554',
            classes: 'transition ease-in-out',
        });

        easeButton.addVariant({
            transparent: {
                color: '#172554',
                bgColor: 'transparent',
            },
            'success-transparent': {
                color: '#22c55e',
                bgColor: 'transparent',
            },
            'danger-transparent': {
                color: '#ef4444',
                bgColor: 'transparent',
            }
        });
    },
    progress: { color: '#172554' },
});