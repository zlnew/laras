<script setup lang="ts">
const fullYear: number = new Date().getFullYear();
</script>

<template>
    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
        <slot></slot>
    </main>
    <footer class="py-12">
        <div class="container">
            <div class="flex flex-wrap -mx-3">
                <div class="w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0">
                <p class="mb-0 text-slate-400">
                    Copyright © {{ fullYear }} Creatoku All Rights Reserved.
                </p>
                </div>
            </div>
        </div>
    </footer>
</template>
