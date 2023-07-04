<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormLabel, FormError, FormSelect, FormTextarea } from "@/Components/Form.vue";
import { Proyek } from "@/types";

defineProps<{
  proyek: Array<Proyek>;
}>();

const modal = useModalStore();

const form = useForm({
  id_rap: null,
  keterangan: null,
});

function submit() {
  form.post(route('keuangan.store'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <ModalLayout size="2xl">
      <ModalHead title="Form Tambah Keuangan Proyek" />

      <ModalBody>
        <div class="w-full mb-4">
          <FormLabel for="id_rap" value="Proyek" />
            <FormSelect v-model="form.id_rap" v-bind="{
              id: 'id_rap', size: 'lg'
            }">
              <option value="">Pilih Proyek</option>
              <option v-for="pry in proyek" :value="pry.id_rap">{{ pry.nama_proyek }} - {{ pry.tahun_anggaran }}</option>
            </FormSelect>
          <FormError class="mt-2" :message="form.errors.id_rap" />
        </div>

        <div class="w-full mb-4">
          <FormLabel for="keterangan" value="Keterangan Dana" />
            <FormTextarea v-model="form.keterangan" v-bind="{
              type: 'text', id: 'keterangan', size: 'lg', autocomplete: 'off', placeholder: 'Keterangan Dana'
            }" />
          <FormError class="mt-2" :message="form.errors.keterangan" />
        </div>
      </ModalBody>
        
      <ModalFooter>
        <EaseButton @click="modal.close" v-bind="{
          variant: 'transparent',
          type: 'button',
          text: 'Close',
        }" />
        <EaseButton v-bind="{
          type: 'submit',
          text: 'Create',
          loading: form.processing,
          onLoading: () => ({
              text: 'Creating data...',
          })
        }" />
      </ModalFooter>
    </ModalLayout>
  </form>
</template>