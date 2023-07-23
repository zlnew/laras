import useModalStore, { ModalPayload } from "@/stores/useModalStore";

function open (
    component: ModalPayload['component'],
    props: ModalPayload['props']
) {    
    useModalStore().open({
        component: component,
        props: props
    });
}

function close () {
    useModalStore().close();
}

export const modal = {
    open,
    close
}