<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { User } from "@/types";
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

const props = defineProps<{
  id: User['id'],
}>();

const form = useForm({});

function destroy() {
  form.delete(route('users.destroy', props.id), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <modal-layout size="md">
    <modal-head title="Konfirmasi Penghapusan User" />

    <modal-body>
      <p>Apakah anda yakin ingin menghapus user ini? Semua data yang berkaitan dengan user ini akan hilang.</p>
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