<script lang="ts">
export { default as CardHeader } from "@/Components/CardPartials/Header.vue";
export { default as CardBody } from "@/Components/CardPartials/Body.vue";
export { default as CardLayout } from "@/Components/Card.vue";

export default {}
</script>

<template>
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <slot></slot>
    </div>
</template>