import { defineStore } from "pinia";

export interface IToastState {
    state: string | number | boolean | null | undefined;
}

const basicState = null;

export default defineStore("value-store", {
    state: (): IToastState => ({ state: basicState }),
    actions: {
        set(payload: IToastState['state']) {
            this.state = payload;
        },
    },
});