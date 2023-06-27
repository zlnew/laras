import { defineStore } from "pinia";
import { extend } from "@vue/shared";
import { markRaw } from "vue";

const component = extend({});
type VueComponent = InstanceType<typeof component>

export interface ErrorBags {
    errors?: Object;
}

export interface IModalProps {
    component: null | VueComponent;
    props?: {
        errors?: Object;
        [key: string]: Object | undefined;
    }
}

export interface IModalState {
    state: IModalProps;
}

const basicState = { component: null, props: {} };

export default defineStore("modal-store", {
    state: (): IModalState => ({ state: basicState }),
    actions: {
        open(payload: IModalProps) {
            const { props, component } = payload;
            const body = document.body;

            if (body) body.style.overflow = "hidden";

            markRaw(component)
            
            this.state = { component, props: props || {} };
        },
        close() {
            this.state = basicState;

            const body = document.body;

            if(body) body.style.overflow = "auto";
        },
    },
    getters: {},
});

