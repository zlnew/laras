<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        isContentTable?: boolean
    }>(),
    {
        isContentTable: false,
    }
)

const spacingClasses = computed(() => {
    return props.isContentTable ? 'p-0 pt-3' : 'px-6 py-3';
});
</script>

<template>
    <div class="flex-auto px-0 pt-0 pb-2">
        <div :class="spacingClasses" class="overflow-x-auto">
            <slot></slot>
        </div>
    </div>
</template>