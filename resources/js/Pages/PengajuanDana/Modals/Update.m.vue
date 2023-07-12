<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError, FormSelect } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailPengajuanDana, DetailRAP, Rekening } from "@/types";

const props = defineProps<{
  detail_pengajuan_dana: DetailPengajuanDana;
  detail_rap: Array<DetailRAP>;
  rekening: Array<Rekening>;
}>();

const modal = useModalStore();

const form = useForm({
  uraian: props.detail_pengajuan_dana.uraian,
  id_detail_rap: props.detail_pengajuan_dana.id_detail_rap,
  id_rekening: props.detail_pengajuan_dana.id_rekening,
  jenis_pembayaran: props.detail_pengajuan_dana.jenis_pembayaran,
  jumlah_pengajuan: props.detail_pengajuan_dana.jumlah_pengajuan,
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
  form.patch(route('pengajuan_dana.update', props.detail_pengajuan_dana.id_detail_pengajuan_dana), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="2xl">
      <modal-head title="Form Ubah Uraian Pengajuan dana" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="id_detail_rap" value="Uraian RAP" />

          <form-select v-model="form.id_detail_rap"
            @change="getRAPAmount($event.target.value)"
            v-bind="{
              id: 'id_detail_rap',
              size: 'lg'
            }">
            <option value="">Pilih Uraian</option>
            <option
              v-for="detail in detail_rap"
              :value="detail.id_detail_rap">
              {{ detail.uraian }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.id_detail_rap" />
        </div>

        <div class="w-full mb-4">
          <form-label for="uraian" value="Uraian Pengajuan Dana" />

          <form-input v-model="form.uraian"
            v-bind="{
              type: 'text',
              id: 'uraian',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Uraian Pengajuan Dana'
            }"
          />

          <form-error class="mt-2" :message="form.errors.uraian" />
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="jenis_pembayaran" value="Jenis Pembayaran" />

            <form-select v-model="form.jenis_pembayaran"
              id="jenis_pembayaran"
              size="lg">
              <option value="">Pilih Jenis Pembayaran</option>
              <option
                v-for="jenis in jenis_pembayaran"
                :value="jenis">
                {{ jenis }}
              </option>
            </form-select>

            <form-error class="mt-2" :message="form.errors.jenis_pembayaran" />
          </div>

          <div>
            <form-label for="jumlah_pengajuan" value="Jumlah Pengajuan" />
            <small class="ml-1" v-show="form.jumlah_pengajuan">: {{ toRupiah(form.jumlah_pengajuan) }}</small>

            <form-input v-model="form.jumlah_pengajuan"
              v-bind="{
                type: 'number',
                id: 'jumlah_pengajuan',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Jumlah Pengajuan'
              }"
            />

            <form-error class="mt-2" :message="form.errors.jumlah_pengajuan" />
          </div>
        </div>

        <div class="w-full mb-4">
          <form-label for="id_rekening" value="Rekening" />

          <form-select v-model="form.id_rekening"
            id="id_rekening"
            size="lg" >
            <option value="">Pilih Rekening</option>
            <option
              v-for="rek in rekening"
              :value="rek.id_rekening">
              {{ rek.nama_bank }} | {{ rek.nomor_rekening }} - {{ rek.nama_rekening }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.id_rekening" />
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
          text: 'Update',
          loading: form.processing,
          onLoading: () => ({
              text: 'Updating data...',
          })
        }" />
      </modal-footer>
    </modal-layout>
  </form>
</template>