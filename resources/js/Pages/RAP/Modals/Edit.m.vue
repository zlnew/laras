<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { FormSelect, FormLabel, FormError } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";
import { Proyek, RAP } from "@/types";

const modal = useModalStore();

const props = defineProps<{
  id_rap: RAP['id_rap'],
  id_proyek: Proyek['id_proyek'],
  nama_proyek: Proyek['nama_proyek'],
  daftar_proyek: Array<Proyek>;
}>();

const form = useForm({
  id_proyek: props.id_proyek,
});

function submit() {
  form.patch(route('rap.update', props.id_rap), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="5xl">
      <modal-head title="Form Ubah RAP" />
  
      <modal-body>
        <div class="w-full mb-4">
          <form-label for="id_proyek" value="Pilih Proyek" />

          <form-select v-model="form.id_proyek"
            v-bind="{
              id: 'id_proyek',
              size: 'lg'
            }">
            <option value="">Pilih</option>
            <option :value="id_proyek">{{ nama_proyek }}</option>
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
              text: 'Update',
              loading: form.processing,
              onLoading: () => ({
                  text: 'Updating data...',
              })
            }"
          />
      </modal-footer>
    </modal-layout>
  </form>
</template>