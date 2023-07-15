<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
        size?: 'sm' | 'md' | 'lg',
        modelValue: string | number | null | boolean | undefined,
    }>(),
    {
        size: 'md',
    }
);

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });

const baseClasses = [
    'ease-soft w-full transition rounded-lg shadow-sm',
    'font-normal text-sm text-dark bg-white',
    'border border-light',
    'focus:outline-none focus:border-primary',
    'focus:-outline-offset-1 focus:outline-primary'
];

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm': return 'px-3 py-1';
        case 'lg': return 'px-3 py-3';
        default: return 'px-3 py-2';
    }
});
</script>

<template>
    <select
        ref="input"
        :class="[sizeClasses, baseClasses]"
        :value="modelValue"
        @change="$emit('update:modelValue', ($event.target as HTMLSelectElement).value)">
      <slot></slot>
    </select>
</template>
