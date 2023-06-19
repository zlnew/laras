<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";

const props = defineProps<{
    id_proyek: string,
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
    form.delete(route('proyek.destroy', props.id_proyek), {
        onSuccess: () => {
            modal.close();
        }
    });
}
</script>

<template>
    <ModalLayout size="md">
        <ModalHead title="Konfirmasi Penghapusan Proyek" />
    
        <ModalBody>
            <p>Apakah anda yakin ingin menghapus proyek ini? Semua data yang berkaitan dengan proyek ini akan hilang.</p>
        </ModalBody>
        
        <ModalFooter>
            <EaseButton @click="modal.close" v-bind="{type: 'button', text: 'Close', variant: 'transparent'}" />
            <EaseButton @click.prevent="destroy" v-bind="{
                type: 'submit',
                variant: 'danger-transparent',
                text: 'Yes, delete it!',
                loading: form.processing,
                onLoading: () => ({
                    text: 'Deleting data...',
                })
            }" />
        </ModalFooter>
    </ModalLayout>
</template>