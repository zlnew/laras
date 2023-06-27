<style scoped>
.toast-fade-enter-from,
.toast-fade-leave-to {
  opacity: 0;
}
.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: 0.25s ease all;
}
</style>

<script setup lang="ts">
import useToastStore from '@/stores/useToastStore';
import { computed } from 'vue';

const toast = useToastStore();

const colorClasses = computed(() => {
    switch (toast.state.type) {
        case 'success': return 'bg-success text-white';
        case 'error': return 'bg-danger text-white';
    }
});

const iconClasses = computed(() => {
    switch (toast.state.type) {
        case 'success': return 'fa-solid fa-check-circle';
        case 'error': return 'fa-solid fa-times-circle';
    }
});
</script>

<template>
    <Teleport to="body">
        <Transition name="toast-fade">
            <div v-if="toast.state?.message" :class="colorClasses"
                class="fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-soft-lg">
                <div class="flex justify-between items-center space-x-2">
                    <FasIcon :icon="iconClasses" /> 
                    <span>{{ toast.state.message }}</span>
                    <button><FasIcon @click="toast.close" icon="fa-solid fa-times" /></button>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>