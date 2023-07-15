<script setup lang="ts">
withDefaults(
    defineProps<{
        first?: string,
        second: string,
        current: string | number,
    }>(),
    {
        first: 'Pages',
    }
);
</script>

<template>
    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
        <li class="text-sm leading-normal">
            <a class="opacity-50 text-dark" href="javascript:;">{{ first }}</a>
        </li>
        <li class="text-sm pl-2 capitalize leading-normal text-dark before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">
            {{ second }}
        </li>
    </ol>
    <h6 class="mb-0 font-bold capitalize text-dark">{{ current }}</h6>
</template>