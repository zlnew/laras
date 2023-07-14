<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormError, FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

const form = useForm({
  nama: null,
  jabatan: null,
  nama_bank: null,
  nomor_rekening: null,
  nama_rekening: null
});

function submit() {
  form.post(route('rekening.store'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="xl">
      <modal-head title="Form Tambah Rekening" />

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
              text: 'Create',
              loading: form.processing,
              onLoading: () => ({
                text: 'Creating data...',
              })
            }"
          />
        </div>
      </modal-footer>
    </modal-layout>
  </form>
</template>