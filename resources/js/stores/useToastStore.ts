import { defineStore } from "pinia";

export interface IToastProps {
    message: string | null;
    type?: 'success' | 'error' | null;
    duration?: number | null,
}

export interface IToastState {
    state: IToastProps;
}

const basicState = { message: null, type: null, duration: null };

export default defineStore("toast-store", {
    state: (): IToastState => ({ state: basicState }),
    actions: {
        open(payload: IToastProps) {
            const { message, type, duration } = payload;
            
            this.state = { message, type, duration };

            if (duration) {
                setTimeout(() => {
                    this.close();
                }, duration);
            }
        },
        close() {
            this.state = basicState;
        },
    },
    getters: {},
});

