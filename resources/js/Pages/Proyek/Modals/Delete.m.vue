<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import Button from "@/Components/Button.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
    id_proyek: string,
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
    form.delete(route('proyek.destroy', props.id_proyek));
}
</script>

<template>
    <ModalLayout size="md">
        <ModalHead title="Konfirmasi Penghapusan Proyek" />
    
        <ModalBody>
            <p>Apakah anda yakin ingin menghapus proyek ini? Semua data yang berkaitan dengan proyek ini akan hilang.</p>
        </ModalBody>
        
        <ModalFooter>
            <Button @click="modal.close" type="button" color="light">Close</Button>
            <Button @click.prevent="destroy" type="submit" color="danger">Delete</Button>
        </ModalFooter>
    </ModalLayout>
</template>