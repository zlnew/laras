<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset',
        size?: 'sm' | 'base' | 'lg',
        color?: 'primary' | 'secondary' | 'danger' | 'success' | 'light' | 'transparent',
        disabled?: boolean
        loading?: boolean,
    }>(),
    {
        type: 'submit',
        size: 'base',
        color: 'primary',
    }
);

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm': return 'px-3 py-2 text-xxs';
        case 'base': return 'px-4 py-3 text-xs';
        case 'lg': return 'px-5 py-4 text-sm';
    }
});

const colorClasses = computed(() => {
    switch (props.color) {
        case 'primary': return 'bg-primary text-white shadow';
        case 'secondary': return 'bg-secondary text-white shadow';
        case 'success': return 'bg-success text-white shadow';
        case 'danger': return 'bg-danger text-white shadow';
        case 'light': return 'bg-light text-primary';
        case 'transparent': return 'bg-transparent text-primary hover:bg-light';
    }
});
</script>

<template>
    <button :type="type"
        :class="[sizeClasses, colorClasses]" :disabled="loading"
        class="inline-block align-middle rounded-lg transition-all ease-in-out uppercase font-bold text-center hover:opacity-90 disabled:cursor-wait disabled:opacity-50">
        <slot></slot>
    </button>
</template>