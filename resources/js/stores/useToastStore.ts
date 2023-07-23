import { defineStore } from "pinia";

export interface ToastProps {
    message: string;
    type?: 'success' | 'error' | 'warning';
    duration?: number,
}

interface ToastState {
    state: ToastProps;
}

const defaultState: ToastProps = {
    message: '',
    type: 'success',
    duration: 5000
};

export default defineStore("toast-store", {
    state: (): ToastState => ({ state: defaultState }),
    actions: {
        open(props: ToastProps) {            
            this.state = props;

            if (props.duration) {
                setTimeout(() => {
                    this.close();
                },props.duration);
            }
        },
        close() {
            this.state = defaultState;
        },
    }
});

