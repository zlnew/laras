<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset',
        size?: 'sm' | 'base' | 'lg',
        color?: 'primary' | 'secondary' | 'danger' | 'success',
    }>(),
    {
        type: 'submit',
        size: 'base',
        color: 'primary',
    }
);

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm': return 'px-3 py-2'
        case 'lg': return 'px-5 py-4'
        default: return 'px-4 py-3'
    }
});

const colorClasses = computed(() => {
    switch (props.color) {
        case 'secondary': return 'bg-secondary'
        case 'success': return 'bg-success'
        case 'danger': return 'bg-danger'
        default: return 'bg-primary'
    }
});
</script>

<template>
    <button :type="type" :class="sizeClasses, colorClasses" class="inline-block align-middle rounded-lg shadow-md transition-all ease-in-out uppercase font-bold text-xs text-center text-white hover:drop-shadow-lg active:opacity-85">
        <slot></slot>
    </button>
</template>