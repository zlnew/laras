import useToastStore, { ToastProps } from '@/stores/useToastStore';

function toast (
    message: ToastProps['message'],
    type: ToastProps['type'],
    duration: ToastProps['duration']
) {    
    useToastStore().open({
        message: message,
        type: type,
        duration: duration
    });
}

export default {
    success: (message: string, duration?: number) => toast(message, 'success', duration),
    error: (message: string, duration?: number) => toast(message, 'error', duration),
    warning: (message: string, duration?: number) => toast(message, 'warning', duration),
}