<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { Satuan } from "@/types";
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

const props = defineProps<{
  id_satuan: Satuan['id_satuan'],
}>();

const form = useForm({});

function destroy() {
  form.delete(route('satuan.destroy', props.id_satuan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <modal-layout size="md">
    <modal-head title="Konfirmasi Penghapusan Satuan" />

    <modal-body>
      <p>Apakah anda yakin ingin menghapus satuan ini? Semua data yang berkaitan dengan satuan ini akan hilang.</p>
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
          variant: 'danger-transparent',
          type: 'submit',
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