<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        textAlign?: 'left' | 'right' | 'center',
        whitespace?: 'normal' | 'nowrap',
    }>(),
    {
        textAlign: 'left',
        whitespace: 'normal',
    }
);

const aligmentClasses = computed(() => {
    switch(props.textAlign) {
        case 'right': return 'text-right';
        case 'center': return 'text-center';
        default: return 'text-left';
    }
});
</script>

<template>
    <td
        :class="[aligmentClasses, { 'whitespace-nowrap': whitespace == 'nowrap' }]"
        class="px-6 py-3 text-sm align-middle bg-transparent shadow-transparent"
    >
        <slot></slot>
    </td>
</template>