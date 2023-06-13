import useToastStore, { IToastProps } from '@/stores/useToastStore';

const Toastify = (message: IToastProps['message'], type: IToastProps['type'], duration: IToastProps['duration']) => {
    const toast = useToastStore();
    
    toast.open({ message: message, type: type, duration: duration ?? 5000 });
}

export const Toast = {
    success: (message: string, duration?: number) => Toastify(message, 'success', duration),
    error: (message: string, duration?: number) => Toastify(message, 'error', duration),
}