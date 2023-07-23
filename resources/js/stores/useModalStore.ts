import { defineStore } from "pinia";
import { extend } from "@vue/shared";
import { markRaw } from "vue";

const component = extend({});
type VueComponent = InstanceType<typeof component>

export interface ModalPayload {
    component: VueComponent | null;
    props?: Object
}

interface ModalState {
    state: ModalPayload;
}

const defaultState = { component: null, props: {} };

export default defineStore("modal-store", {
    state: (): ModalState => ({ state: defaultState }),
    actions: {
        open(payload: ModalPayload) {
            markRaw(payload.component)

            this.state = payload;
        },
        close() {
            this.state = defaultState;
        },
    },
});

