<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { DetailRAP } from "@/types";

const props = defineProps<{
  id_detail_rap: DetailRAP['id_detail_rap'],
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
  form.delete(route('detail_rap.destroy', props.id_detail_rap), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <modal-layout size="md">
    <modal-layout title="Konfirmasi Penghapusan Uraian RAB" />

    <modal-body>
      <p>Apakah anda yakin ingin menghapus Uraian RAP ini? Semua data yang berkaitan dengan uraian ini akan hilang.</p>
    </modal-body>
    
    <modal-footer>
      <ease-button
        @click="modal.close"
        v-bind="{
          type: 'button',
          text: 'Close',
          variant: 'transparent'
        }"
      />
      <ease-button
        @click.prevent="destroy"
        v-bind="{
          type: 'submit',
          variant: 'danger-transparent',
          text: 'Yes, delete it!',
          loading: form.processing,
          onLoading: () => ({
              text: 'Deleting data...',
          })
        }"
      />
    </modal-footer>
  </modal-layout>
</template>