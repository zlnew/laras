<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormError, FormInput, FormLabel } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";
import { Satuan } from '@/types';

const modal = useModalStore();

const props = defineProps<{
  satuan: Satuan,
}>();

const form = useForm({
  id_satuan: props.satuan.id_satuan,
  nama_satuan: props.satuan.nama_satuan,
});

function submit() {
  form.patch(route('satuan.update', props.satuan.id_satuan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout>
      <modal-head title="Form Ubah Satuan" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="nama_satuan" value="Nama Satuan" />

          <form-input v-model="form.nama_satuan"
            v-bind="{
              type: 'text',
              id: 'nama_satuan',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Satuan',
            }"
          />

          <form-error class="mt-2" :message="form.errors.nama_satuan" />
        </div>
      </modal-body>
        
      <modal-footer>
        <ease-button
          @click="modal.close"
          v-bind="{
            variant: 'transparent',
            type: 'button',
            text: 'Close',
          }"
        />
        <div class="space-x-2">
          <ease-button
            v-bind="{
              type: 'submit',
              text: 'Update',
              loading: form.processing,
              onLoading: () => ({
                text: 'Updating data...',
              })
            }"
          />
        </div>
      </modal-footer>
    </modal-layout>
  </form>
</template>