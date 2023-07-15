wZ<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    name: string,
    icon: string,
    href: string,
    active?: boolean,
}>();

const classes = computed(() => {
    const baseClasses = [
        'my-0 mx-4 py-2.7 px-4 text-sm',
        'ease-nav-brand',
        'flex items-center',
        'rounded-lg whitespace-nowrap transition'
    ];

    const activeClasses = [
        'font-bold',
        'text-dark bg-white',
        'shadow-soft-xl'
    ];

    const unactiveClasses = [
        'font-medium',
        'text-dark/70'
    ];

    return [
        props.active ? activeClasses : unactiveClasses,
        ...baseClasses
    ];
});

const iconBgClasses = computed(() => {
    const baseClasses = [
        'mr-2 h-8 w-8 xl:p-2.5',
        'flex items-center justify-center',
        'bg-center text-center stroke-0',
        'shadow-soft-2xl rounded-md',
    ];

    const activeClasses = [
        'bg-gradient-to-tr from-primary to-secondary',
    ];

    const unactiveClasses = [
        'bg-white'
    ];

    return [
        props.active ? activeClasses : unactiveClasses,
        ...baseClasses
    ];    
});

const iconClasses = computed(() => props.active ? 'text-white' : '');
</script>

<template>
    <Link :href="href" :class="classes">
        <div :class="iconBgClasses"><FasIcon :icon="icon" :class="iconClasses" /></div>
        {{ name }}
    </Link>
</template>