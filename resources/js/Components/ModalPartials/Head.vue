<script setup lang="ts">
defineProps<{
    title: string,
}>()
</script>

<template>
    <h1 class="text-xl font-bold text-primary">{{ title }}</h1>
</template>