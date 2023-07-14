<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import { Rekening } from '@/types';
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

const page = usePage();

const queryParams = page.props.query as Rekening;

defineProps<{
  banks: Array<Partial<Rekening>>;
}>();

const form = useForm({
  nama_bank: queryParams.nama_bank,
  nomor_rekening: queryParams.nomor_rekening,
  nama_rekening: queryParams.nama_rekening
});

function submit() {
  form.get(route('rekening'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="xl">
      <modal-head title="Form Pencarian Rekening" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="nomor_rekening" value="Nomor Rekening" />

          <form-input v-model="form.nomor_rekening"
            v-bind="{
              type: 'number',
              id: 'nomor_rekening',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Cari berdasarkan nomor rekening'
            }" />
        </div>
  
        <div class="w-full mb-4">
          <form-label for="nama_rekening" value="Nama Rekening" />

          <form-input v-model="form.nama_rekening"
            v-bind="{
              type: 'text',
              id: 'nama_rekening',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Cari berdasarkan nama rekening'
            }"
          />
        </div>

        <div class="w-full mb-4">
          <form-label for="nama_bank" value="Bank" />

          <form-select v-model="form.nama_bank"
            v-bind="{
              id: 'nama_bank',
              size: 'lg',
            }">
            <option value="">Semua Bank</option>
            <option
              v-for="bank in banks"
              :value="bank.nama_bank">
              {{ bank.nama_bank }}
            </option>
          </form-select>
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
              text: 'Search',
              loading: form.processing,
              onLoading: () => ({
                text: 'Searching data...',
              })
            }"
          />
        </div>
      </modal-footer>
    </modal-layout>
  </form>
</template>