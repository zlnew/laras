<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        color?: 'primary' | 'secondary' | 'danger' | 'success',
    }>(),
    {
        color: 'primary',
    }
);

const colorClasses = computed(() => {
    switch (props.color) {
        case 'primary': return 'text-primary';
        case 'secondary': return 'text-secondary';
        case 'success': return 'text-success';
        case 'danger': return 'text-danger';
    }
});
</script>

<template>
    <button type="button" :class="[colorClasses]"
        class="transition ease-in-out font-semibold hover:opacity-70">
        <slot></slot>
    </button>
</template>