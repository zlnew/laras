<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import useModalStore from "@/stores/useModalStore";
import { DetailPengajuanDana } from "@/types";

const props = defineProps<{
  id_detail_pengajuan_dana: DetailPengajuanDana['id_detail_pengajuan_dana'],
}>();

console.log(props.id_detail_pengajuan_dana);


const modal = useModalStore();

const form = useForm({});

function destroy() {
  form.delete(route('pengajuan_dana.destroy', props.id_detail_pengajuan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <ModalLayout size="md">
    <ModalHead title="Konfirmasi Penghapusan Uraian RAP" />

    <ModalBody>
      <p>Apakah anda yakin ingin menghapus Uraian Pengajuan Dana ini? Semua data yang berkaitan dengan uraian ini akan hilang.</p>
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