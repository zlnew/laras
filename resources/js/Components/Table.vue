<script lang="ts">
export { default as THead } from "@/Components/TablePartials/Head.vue";
export { default as TBody } from "@/Components/TablePartials/Body.vue";
export { default as TRow } from "@/Components/TablePartials/Row.vue";
export { default as THeadCell } from "@/Components/TablePartials/HeadCell.vue";
export { default as TBodyCell } from "@/Components/TablePartials/BodyCell.vue";
export { default as TableLayout } from "@/Components/Table.vue";

export default {}
</script>

<template>
    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
        <slot></slot>
    </table>
</template>