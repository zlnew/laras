<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        size?: 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | 'full',
    }>(), {
        size: 'md',
    }
);

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm': return 'w-[24rem]';
        case 'md': return 'w-[28rem]';
        case 'lg': return 'w-[32rem]';
        case 'xl': return 'w-[36rem]';
        case '2xl': return 'w-[42rem]';
        case '3xl': return 'w-[48rem]';
        case '4xl': return 'w-[56rem]';
        case '5xl': return 'w-[64rem]';
        case 'full': return 'w-full';
    }
});
</script>

<template>
    <div :class="[sizeClasses]"
        class="relative sm:m-10 m-4 sm:p-6 space-y-10 p-5 rounded-2xl bg-white">
        <slot></slot>
    </div>
</template>