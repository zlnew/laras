<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailPencairanDana, DetailPengajuanDana, PencairanDana } from "@/types";

const props = defineProps<{
  id_pencairan_dana: PencairanDana['id_pencairan_dana'];
  detail_pengajuan_dana: DetailPengajuanDana;
  jumlah_pencairan: DetailPencairanDana['jumlah_pencairan'];
}>();

const modal = useModalStore();

const form = useForm({
  id_detail_pengajuan_dana: props.detail_pengajuan_dana.id_detail_pengajuan_dana,
  jumlah_pencairan: 0,
});

function submit() {  
  form.post(route('pencairan_dana.store', props.id_pencairan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="2xl">
      <modal-head title="Form Pembayaran" />

      <modal-body>
        <div class="w-full mb-4">
          <table>
            <tbody>
              <tr>
                <td>Uraian</td>
                <td class="pl-6 pr-3">:</td>
                <td>
                  <span class="font-medium text-primary">
                    {{ detail_pengajuan_dana.uraian }}
                  </span>
                </td>
              </tr>
              <tr>
                <td>Jumlah Pengajuan</td>
                <td class="pl-6 pr-3">:</td>
                <td>
                  <span class="font-medium text-primary">
                    {{ toRupiah(detail_pengajuan_dana.jumlah_pengajuan) }}
                  </span>
                </td>
              </tr>
              <tr>
                <td>Jumlah Sudah Dibayar</td>
                <td class="pl-6 pr-3">:</td>
                <td>
                  <span class="font-medium text-primary">
                    {{ toRupiah(detail_pengajuan_dana.jumlah_pencairan) }}
                  </span>
                </td>
              </tr>
              <tr>
                <td>Jumlah Belum Dibayar</td>
                <td class="pl-6 pr-3">:</td>
                <td>
                  <span class="font-medium text-primary">
                    {{ toRupiah(detail_pengajuan_dana.jumlah_pengajuan - detail_pengajuan_dana.jumlah_pencairan) }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="w-full">
          <form-label for="jumlah_pencairan" value="Jumlah Pembayaran" />
          <small class="ml-1" v-show="form.jumlah_pencairan">: {{ toRupiah(form.jumlah_pencairan) }}</small>

          <form-input v-model="form.jumlah_pencairan"
            v-bind="{
              type: 'number',
              id: 'jumlah_pencairan',
              size: 'lg',
              min: '1',
              max: detail_pengajuan_dana.jumlah_pengajuan - detail_pengajuan_dana.jumlah_pencairan,
              autocomplete: 'off',
              placeholder: 'Jumlah Pembayaran'
            }"
          />

          <form-error class="mt-2" :message="form.errors.jumlah_pencairan" />
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