<script setup lang="ts">
withDefaults(
    defineProps<{
        last?: boolean,
    }>(),
    {
        last: false,
    }
);
</script>

<template>
    <tr :class="[{'border-b': !last}]"><slot></slot></tr>
</template>