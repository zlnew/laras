<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { DetailRAB } from "@/types";

const props = defineProps<{
  id_detail_rab: DetailRAB['id_detail_rab'],
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
  form.delete(route('detail_rab.destroy', props.id_detail_rab), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <modal-layout size="md">
    <modal-head title="Konfirmasi Penghapusan Uraian RAB" />

    <modal-body>
      <p>Apakah anda yakin ingin menghapus Uraian RAB ini? Semua data yang berkaitan dengan uraian ini akan hilang.</p>
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