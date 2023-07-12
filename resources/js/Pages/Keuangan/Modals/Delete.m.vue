<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { Keuangan } from "@/types";

const modal = useModalStore();

const props = defineProps<{
  id_keuangan: Keuangan['id_keuangan'],
}>();

const form = useForm({});

function destroy() {
  form.delete(route('keuangan.destroy', props.id_keuangan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <modal-layout size="md">
    <modal-head title="Konfirmasi Penghapusan Keuangan Proyek" />

    <modal-body>
      <p>Apakah anda yakin ingin menghapus Keuangan proyek ini? Semua data yang berkaitan dengan Keuangan ini akan hilang.</p>
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