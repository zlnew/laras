<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError, FormSelect } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailRAB, DetailRAP, Penagihan, PengajuanDana, Rekening } from "@/types";

const props = defineProps<{
  id_penagihan: Penagihan['id_penagihan'];
  detail_rab: Array<DetailRAB>;
}>();

const modal = useModalStore();

const form = useForm<{
  id_detail_rab: string | null;
  volume_penagihan: number;
  harga_satuan: number;
}>({
  id_detail_rab: null,
  volume_penagihan: 0,
  harga_satuan: 0
});

function getRABAmount(selectedID: number) {
  const selectedDetailRAB = props.detail_rab.find(detail => detail.id_detail_rab == selectedID);

  if (selectedDetailRAB) {
    form.harga_satuan = selectedDetailRAB.harga_satuan;
  } else {
    form.reset("harga_satuan");
  }
}

function submit() {
  form.post(route('penagihan.store', props.id_penagihan), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="2xl">
      <modal-head title="Form Tambah Uraian Penagihan" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="id_detail_rab" value="Uraian RAB" />

          <form-select v-model="form.id_detail_rab"
            @change="getRABAmount($event.target.value)"
            v-bind="{
              id: 'id_detail_rab',
              size: 'lg'
            }">
            <option value="">Pilih Uraian</option>
            <option
              v-for="detail in detail_rab"
              :value="detail.id_detail_rab">
              {{ detail.uraian }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.id_detail_rab" />
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="volume_penagihan" value="Volume" />

            <form-input v-model="form.volume_penagihan"
              v-bind="{
                type: 'number',
                id: 'volume_penagihan',
                size: 'lg',
                placeholder: 'Volume Penagihan'
              }"
            />

            <form-error class="mt-2" :message="form.errors.volume_penagihan" />
          </div>

          <div>
            <form-label for="harga_satuan" value="Harga Satuan" />

            <form-input v-model="form.harga_satuan"
              v-bind="{
                type: 'text',
                id: 'harga_satuan',
                size: 'lg',
                readonly: true
              }"
            />
          </div>
        </div>

        <div v-if="form.volume_penagihan > 0" class="w-full mb-4">
            <form-label for="jumlah_penagihan" value="Jumlah Penagihan" />
            <p id="jumlah_penagihan" class="mt-2">{{ toRupiah(form.volume_penagihan * form.harga_satuan) }}</p>
          </div>
      </modal-body>
        
      <modal-footer>
        <ease-button @click="modal.close" v-bind="{
          variant: 'transparent',
          type: 'button',
          text: 'Close',
        }" />

        <ease-button v-bind="{
          type: 'submit',
          text: 'Create',
          loading: form.processing,
          onLoading: () => ({
            text: 'Creating data...',
          })
        }" />
      </modal-footer>
    </modal-layout>
  </form>
</template>