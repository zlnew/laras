<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm, usePage } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { Proyek } from "@/types";

const modal = useModalStore();

const page = usePage();

const queryParams = page.props.query as Proyek;

const statusProyek = [{
  statusName: 'Closed',
  statusCode: 400,
}, {
  statusName: 'On Progress',
  statusCode: 100,
}];

const form = useForm({
  nama_proyek: queryParams.nama_proyek,
  tahun_anggaran: queryParams.tahun_anggaran,
  pengguna_jasa: queryParams.pengguna_jasa,
  waktu_mulai: queryParams.waktu_mulai,
  waktu_selesai: queryParams.waktu_selesai,
  nilai_kontrak_min: queryParams.nilai_kontrak_min,
  nilai_kontrak_max: queryParams.nilai_kontrak_max,
  pic: queryParams.pic,
  status_proyek: queryParams.status_proyek,
});

function submit() {
  form.get(route('proyek'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="5xl">
      <modal-head title="Form Pencarian Proyek" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="nama_proyek" value="Nama Proyek" />

          <form-input v-model="form.nama_proyek"
            v-bind="{
              type: 'text',
              id: 'nama_proyek',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Proyek'
            }" />
        </div>
  
        <div class="w-full mb-4 grid grid-cols-3 gap-4">
          <div class="col-span-2">
            <form-label for="pengguna_jasa" value="Pengguna Jasa" />

            <form-input v-model="form.pengguna_jasa"
              v-bind="{
                type: 'text',
                id: 'pengguna_jasa',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Pengguna Jasa'
              }"
            />
          </div>
          <div>
            <form-label for="tahun_anggaran" value="Tahun Anggaran" />

            <form-input v-model="form.tahun_anggaran"
              v-bind="{
                type: 'text',
                id: 'tahun_anggaran',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Tahun Anggaran'
              }"
            />
          </div>
        </div>
  
        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="waktu_mulai" value="Tanggal Mulai" />

            <form-input v-model="form.waktu_mulai"
              v-bind="{
                type: 'date',
                id: 'waktu_mulai',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Tanggal Mulai'
              }"
            />
          </div>
          <div>
            <form-label for="waktu_selesai" value="Tanggal Selesai" />

            <form-input v-model="form.waktu_selesai"
              v-bind="{
                type: 'date',
                id: 'waktu_selesai',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Tanggal Selesai'
              }"
            />
          </div>
        </div>
  
        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="nilai_kontrak_min" value="Nilai Kontrak Min" />
            <small class="ml-1" v-show="form.nilai_kontrak_min">: {{ toRupiah(form.nilai_kontrak_min) }}</small>

            <form-input v-model="form.nilai_kontrak_min"
              v-bind="{
                type: 'number',
                id: 'nilai_kontrak_min',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nilai Kontrak Min'
              }"
            />
          </div>
          <div>
            <form-label for="nilai_kontrak_max" value="Nilai Kontrak Max" />
            <small class="ml-1" v-show="form.nilai_kontrak_max">: {{ toRupiah(form.nilai_kontrak_max) }}</small>

            <form-input v-model="form.nilai_kontrak_max"
              v-bind="{
                type: 'number',
                id: 'nilai_kontrak_max',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Nilai Kontrak Max'
              }"
            />
          </div>
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="pic" value="Penanggung Jawab" />

            <form-input v-model="form.pic"
              v-bind="{
                type: 'text',
                id: 'pic',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Penanggung Jawab'
              }"
            />
          </div>
          <div>
            <form-label for="status_proyek" value="Status Proyek" />
            <small class="ml-1" v-show="form.status_proyek">: {{ form.status_proyek }}</small>

            <form-select v-model="form.status_proyek"
              v-bind="{
                id: 'status_proyek',
                size: 'lg',
              }">
              <option value="">Cari berdasarkan status</option>
              <option
                v-for="status in statusProyek"
                :value="status.statusCode"
                >{{ status.statusName }}
              </option>
            </form-select>
          </div>
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
            text: 'Search',
            loading: form.processing,
            onLoading: () => ({
              text: 'Searching data...',
            })
          }"
        />
      </modal-footer>
    </modal-layout>
  </form>
</template>