<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormLabel, FormError, FormSelect, FormTextarea } from "@/Components/Form.vue";
import { PengajuanDana, Proyek } from "@/types";

const props = defineProps<{
  pengajuan_dana: PengajuanDana;
  proyek: Array<Proyek>;
}>();

const modal = useModalStore();

const form = useForm({
  id_rap: props.pengajuan_dana.id_rap,
  keterangan: props.pengajuan_dana.keterangan,
});

function submit() {
  form.patch(route('keuangan.update', props.pengajuan_dana.id_pengajuan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <ModalLayout size="2xl">
      <ModalHead title="Form Ubah Keuangan Proyek" />

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
          text: 'Update',
          loading: form.processing,
          onLoading: () => ({
              text: 'Updating data...',
          })
        }" />
      </ModalFooter>
    </ModalLayout>
  </form>
</template>