<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { DetailPenagihan } from "@/types";

const props = defineProps<{
  id_detail_penagihan: DetailPenagihan['id_detail_penagihan'],
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
  form.delete(route('penagihan.destroy', props.id_detail_penagihan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <ModalLayout size="md">
    <ModalHead title="Konfirmasi Penghapusan Uraian Penagihan" />

    <ModalBody>
      <p>Apakah anda yakin ingin menghapus Uraian Penagihan ini? Semua data yang berkaitan dengan uraian ini akan hilang.</p>
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