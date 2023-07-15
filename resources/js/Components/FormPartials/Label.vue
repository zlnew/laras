<script setup lang="ts">
defineProps<{
    value: string,
}>();
</script>

<template>
    <label class="mb-2 font-bold text-xs text-dark/80">{{ value }}</label>
</template>