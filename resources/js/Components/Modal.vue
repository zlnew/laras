<style scoped>
.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: 0.25s ease all;
}
</style>

<script lang="ts">
export { default as ModalLayout } from "@/Components/ModalPartials/Layout.vue";
export { default as ModalHead } from "@/Components/ModalPartials/Head.vue";
export { default as ModalBody } from "@/Components/ModalPartials/Body.vue";
export { default as ModalFooter } from "@/Components/ModalPartials/Footer.vue";
export { default as ModalWindow } from "@/Components/Modal.vue";

export default {}
</script>

<script setup lang="ts">
import useModalStore from '@/stores/useModalStore';
import { onMounted, onUnmounted } from 'vue';

const modal = useModalStore();

function keydownListener(event: KeyboardEvent) {
  if (event.key === "Escape") modal.close();
}

onMounted(() => {
  document.addEventListener("keydown", keydownListener);
});

onUnmounted(() => {
  document.removeEventListener("keydown", keydownListener);
});
</script>

<template>
    <Teleport to="body">
        <Transition name="modal-fade">
            <div @click.self="modal.close" v-if="modal.state?.component" class="absolute z-[999] h-full inset-0 flex justify-center items-start bg-gray-600/50">
                <component
                    :is="modal.state?.component"
                    v-bind="modal.state?.props"
                />
            </div>
        </Transition>
    </Teleport>
</template>