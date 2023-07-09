<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError, FormSelect } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailRAP, PengajuanDana } from "@/types";

const props = defineProps<{
  id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
  detail_rap: Array<DetailRAP>;
}>();

const modal = useModalStore();

const form = useForm({
  uraian: null,
  id_detail_rap: null,
  jenis_pembayaran: null,
  nama_rekening: null,
  nomor_rekening: null,
  nama_bank: null,
  jumlah_pengajuan: 0,
});

const jenis_pembayaran = ['Transfer', 'Cash'];

function getRAPAmount(selectedID: number) {
  const selectedDetailRAP = props.detail_rap.find(detail => detail.id_detail_rap == selectedID);

  if (selectedDetailRAP) {
    form.jumlah_pengajuan = selectedDetailRAP.harga_satuan;
  } else {
    form.reset("jumlah_pengajuan");
  }
}

function submit() {
  form.post(route('pengajuan_dana.store', props.id_pengajuan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="2xl">
      <modal-head title="Form Tambah Uraian Pengajuan dana" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="id_detail_rap" value="Uraian RAP" />

          <form-select v-model="form.id_detail_rap"
            @change="getRAPAmount($event.target.value)"
            v-bind="{
              id: 'id_detail_rap',
              size: 'lg'
            }">
            <option value="">Pilih Uraian RAP</option>
            <option
              v-for="detail in detail_rap"
              :value="detail.id_detail_rap"
              >{{ detail.uraian }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.id_detail_rap" />
        </div>

        <div class="w-full mb-4">
          <form-label for="uraian" value="Uraian Pengajuan Dana" />

          <form-input v-model="form.uraian" v-bind="{
            type: 'text',
            id: 'uraian',
            size: 'lg',
            autocomplete: 'off',
            placeholder: 'Uraian Pengajuan Dana'
          }" />

          <form-error class="mt-2" :message="form.errors.uraian" />
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="jenis_pembayaran" value="Jenis Pembayaran" />

            <form-select v-model="form.jenis_pembayaran" id="jenis_pembayaran" size="lg" >
              <option value="">Pilih Jenis Pembayaran</option>
              <option v-for="jenis in jenis_pembayaran" :value="jenis">{{ jenis }}</option>
            </form-select>

            <form-error class="mt-2" :message="form.errors.jenis_pembayaran" />
          </div>

          <div>
            <form-label for="nama_bank" value="Nama Bank" />

            <form-input v-model="form.nama_bank" v-bind="{
              type: 'text',
              id: 'nama_bank',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Bank'
            }" />

            <form-error class="mt-2" :message="form.errors.nama_bank" />
          </div>
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="nomor_rekening" value="Nomor Rekening" />

            <form-input v-model="form.nomor_rekening" v-bind="{
              type: 'number',
              id: 'nomor_rekening',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nomor Rekening'
            }" />

            <form-error class="mt-2" :message="form.errors.nomor_rekening" />
          </div>

          <div>
            <form-label for="nama_rekening" value="Nama Rekening" />

            <form-input v-model="form.nama_rekening" v-bind="{
              type: 'text',
              id: 'nama_rekening',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Rekening'
            }" />

            <form-error class="mt-2" :message="form.errors.nama_rekening" />
          </div>
        </div>

        <div class="w-full mb-4">
          <form-label for="jumlah_pengajuan" value="Jumlah Pengajuan" />
          <small class="ml-1" v-show="form.jumlah_pengajuan">: {{ toRupiah(form.jumlah_pengajuan) }}</small>

          <form-input v-model="form.jumlah_pengajuan" v-bind="{
            type: 'number',
            id: 'jumlah_pengajuan',
            size: 'lg',
            autocomplete: 'off',
            placeholder: 'Jumlah Pengajuan'
          }" />

          <form-error class="mt-2" :message="form.errors.jumlah_pengajuan" />
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