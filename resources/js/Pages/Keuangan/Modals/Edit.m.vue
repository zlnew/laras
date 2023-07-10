<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { FormTextarea ,FormLabel, FormError } from "@/Components/Form.vue";
import useModalStore from "@/stores/useModalStore";
import { Keuangan } from "@/types";

const modal = useModalStore();

const props = defineProps<{
  id_keuangan: Keuangan['id_keuangan'],
  keperluan: Keuangan['keperluan'],
}>();

const form = useForm({
  keperluan: props.keperluan,
});

function submit() {
  form.patch(route('keuangan.update', props.id_keuangan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="5xl">
      <modal-head title="Form Ubah Keuangan Proyek" />
  
      <modal-body>
        <div class="w-full mb-4">
          <form-label for="keperluan" value="Keperluan" />

          <form-textarea v-model="form.keperluan"
            v-bind="{
              id: 'keperluan',
              placeholder: 'Tulis keperluan'
            }"
          />

          <form-error class="mt-2" :message="form.errors.keperluan" />
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