<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormError, FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";
import { Rekening } from '@/types';

const modal = useModalStore();

const props = defineProps<{
  rekening: Rekening;
}>();

const form = useForm({
  nama: props.rekening.nama,
  jabatan: props.rekening.jabatan,
  nama_bank: props.rekening.nama_bank,
  nomor_rekening: props.rekening.nomor_rekening,
  nama_rekening: props.rekening.nama_rekening
});

function submit() {
  form.patch(route('rekening.update', props.rekening.id_rekening), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="xl">
      <modal-head title="Form Ubah Rekening" />

      <modal-body>
        <div class="w-full grid grid-cols-2 gap-4 mb-4">
          <div>
            <form-label for="nama" value="Nama" />
  
            <form-input v-model="form.nama"
              v-bind="{
                type: 'text',
                id: 'nama',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nama',
              }"
            />
  
            <form-error class="mt-2" :message="form.errors.nama" />
          </div>
          <div>
            <form-label for="jabatan" value="Jabatan" />
  
            <form-input v-model="form.jabatan"
              v-bind="{
                type: 'text',
                id: 'jabatan',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nama Jabatan',
              }"
            />
  
            <form-error class="mt-2" :message="form.errors.jabatan" />
          </div>
        </div>
  
        <div class="w-full mb-4">
          <form-label for="nama_bank" value="Nama Bank" />

          <form-input v-model="form.nama_bank"
            v-bind="{
              type: 'text',
              id: 'nama_bank',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Bank'
            }"
          />

          <form-error class="mt-2" :message="form.errors.nama_bank" />
        </div>

        <div class="w-full grid grid-cols-2 gap-4 mb-4">
          <div>
            <form-label for="nomor_rekening" value="Nomor Rekening" />
  
            <form-input v-model="form.nomor_rekening"
              v-bind="{
                type: 'number',
                id: 'nomor_rekening',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nomor Rekening',
              }"
            />
  
            <form-error class="mt-2" :message="form.errors.nomor_rekening" />
          </div>
          <div>
            <form-label for="nama_rekening" value="Nama Rekening" />
  
            <form-input v-model="form.nama_rekening"
              v-bind="{
                type: 'text',
                id: 'nama_rekening',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nama Rekening',
              }"
            />
  
            <form-error class="mt-2" :message="form.errors.nama_rekening" />
          </div>
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