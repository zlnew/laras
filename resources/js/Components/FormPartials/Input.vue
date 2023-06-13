<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
        size?: 'sm' | 'md' | 'lg',
        modelValue: string | number | null,
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

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm': return 'px-3 py-1';
        case 'lg': return 'px-3 py-3';
        default: return 'px-3 py-2';
    }
});
</script>

<template>
    <input
        :class="sizeClasses"
        class="ease-soft block w-full transition-all rounded-lg shadow-sm
            font-normal text-sm text-gray-700 bg-white
            border border-solid border-light
            focus:drop-shadow focus:border-primary"
        :value="modelValue" @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" ref="input"
    />
</template>
