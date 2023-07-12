<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        value?: string,
        textAlign?: 'left' | 'right' | 'center',
    }>(),
    {
        value: '',
        textAlign: 'left',
    }
);

const aligmentClasses = computed(() => {
    switch(props.textAlign) {
        case 'right': return 'text-right';
        case 'center': return 'text-center';
        default: return 'text-left';
    }
})
</script>

<template>
    <th :class="[aligmentClasses]"
        class="px-6 py-3
            text-xxs font-bold text-primary
            uppercase align-middle
            bg-transparent border-b border-light
            shadow-none border-b-solid tracking-none
            whitespace-nowrap
            opacity-70">
        {{ value }}
    </th>
</template>