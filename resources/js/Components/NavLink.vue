<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    name: string,
    icon: string,
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors'
        : 'py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors'
);

const iconBgClasses = computed(() => 
    props.active
        ? 'bg-primary shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5'
        : 'bg-white shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5'
);

const iconClasses = computed(() => 
    props.active
        ? 'text-white'
        : ''
);
</script>

<template>
    <Link :href="href" :class="classes">
        <div :class="iconBgClasses"><FasIcon :icon="icon" :class="iconClasses" /></div>
        {{ name }}
    </Link>
</template>
