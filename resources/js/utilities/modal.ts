import useModalStore, { IModalProps } from "@/stores/useModalStore";

const pop = (component: IModalProps['component'], props: IModalProps['props'] = {}) => {
    const modal = useModalStore();
    
    modal.open({ component: component,
        props: props
    });
}

export const Modal = {
    pop
}