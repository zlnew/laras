import useToastStore, { IToastProps } from '@/stores/useToastStore';

export const Toastify = (message: IToastProps['message'], type: IToastProps['type'], duration: IToastProps['duration'] = 5000) => {
    const toast = useToastStore();
    toast.open({ message: message, type: type, duration: duration });
}