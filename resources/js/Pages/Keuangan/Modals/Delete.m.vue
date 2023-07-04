<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { PengajuanDana } from "@/types";

const props = defineProps<{
  id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'],
}>();

const modal = useModalStore();

const form = useForm({});

function destroy() {
  form.delete(route('keuangan.destroy', props.id_pengajuan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <ModalLayout size="md">
    <ModalHead title="Konfirmasi Penghapusan Keuangan Proyek" />

    <ModalBody>
      <p>Apakah anda yakin ingin menghapus Keuangan Proyek ini? Semua data yang berkaitan dengan keuangan ini akan hilang.</p>
    </ModalBody>
    
    <ModalFooter>
      <EaseButton @click="modal.close" v-bind="{type: 'button', text: 'Close', variant: 'transparent'}" />
      <EaseButton @click.prevent="destroy" v-bind="{
        type: 'submit',
        variant: 'danger-transparent',
        text: 'Yes, delete it!',
        loading: form.processing,
        onLoading: () => ({
            text: 'Deleting data...',
        })
      }" />
    </ModalFooter>
  </ModalLayout>
</template>