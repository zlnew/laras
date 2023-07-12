<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { FormSelect, FormLabel, FormError } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";
import { Proyek } from "@/types";

const modal = useModalStore();

defineProps<{
  daftar_proyek: Array<Proyek>;
}>();

const form = useForm({
  id_proyek: null,
});

function submit() {
  form.post(route('rab.store'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="5xl">
      <modal-head title="Form Tambah RAB" />
  
      <modal-body>
        <div class="w-full mb-4">
          <form-label for="id_proyek" value="Pilih Proyek" />

          <form-select v-model="form.id_proyek"
            v-bind="{
              id: 'id_proyek',
              size: 'lg'
            }">
            <option value="">Pilih</option>
            <option
              v-for="proyek in daftar_proyek"
              :value="proyek.id_proyek">
              {{ proyek.nama_proyek }} - {{ proyek.tahun_anggaran }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.id_proyek" />
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
      </modal-footer>
    </modal-layout>
  </form>
</template>