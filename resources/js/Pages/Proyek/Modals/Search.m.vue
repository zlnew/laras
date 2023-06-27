<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";

const modal = useModalStore();

const statusProyek = [{
  statusName: 'Closed',
  statusCode: 400,
}, {
  statusName: 'On Progress',
  statusCode: 100,
}];

const form = useForm({
  nama_proyek: null,
  tahun_anggaran: null,
  pengguna_jasa: null,
  waktu_mulai: null,
  waktu_selesai: null,
  nilai_kontrak_min: null,
  nilai_kontrak_max: null,
  pic: null,
  status_proyek: null,
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
    <ModalLayout size="5xl">
      <ModalHead title="Form Pencarian Proyek" />

      <ModalBody>
        <div class="w-full mb-4">
          <FormLabel for="nama_proyek" value="Nama Proyek" />
          <FormInput v-model="form.nama_proyek" v-bind="{
            type: 'text', id: 'nama_proyek', size: 'lg', autocomplete: 'off', placeholder: 'Nama Proyek'
          }" />
        </div>
  
        <div class="w-full mb-4 grid grid-cols-3 gap-4">
          <div class="col-span-2">
            <FormLabel for="pengguna_jasa" value="Pengguna Jasa" />
            <FormInput v-model="form.pengguna_jasa" v-bind="{
              type: 'text', id: 'pengguna_jasa', size: 'lg', autocomplete: 'off', placeholder: 'Pengguna Jasa'
            }" />
          </div>
          <div>
            <FormLabel for="tahun_anggaran" value="Tahun Anggaran" />
            <FormInput v-model="form.tahun_anggaran" v-bind="{
              type: 'text', id: 'tahun_anggaran', size: 'lg', autocomplete: 'off', placeholder: 'Tahun Anggaran'
            }" />
          </div>
        </div>
  
        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <FormLabel for="waktu_mulai" value="Tanggal Mulai" />
            <FormInput v-model="form.waktu_mulai" v-bind="{
              type: 'date', id: 'waktu_mulai', size: 'lg', autocomplete: 'off', placeholder: 'Tanggal Mulai'
            }" />
          </div>
          <div>
            <FormLabel for="waktu_selesai" value="Tanggal Selesai" />
            <FormInput v-model="form.waktu_selesai" v-bind="{
              type: 'date', id: 'waktu_selesai', size: 'lg', autocomplete: 'off', placeholder: 'Tanggal Selesai'
            }" />
          </div>
        </div>
  
        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <FormLabel for="nilai_kontrak_min" value="Nilai Kontrak Min" />
            <small class="ml-1" v-show="form.nilai_kontrak_min">: {{ toRupiah(form.nilai_kontrak_min) }}</small>
            <FormInput v-model="form.nilai_kontrak_min" v-bind="{
              type: 'number', id: 'nilai_kontrak_min', size: 'lg', autocomplete: 'off', placeholder: 'Nilai Kontrak Min'
            }" />
          </div>
          <div>
            <FormLabel for="nilai_kontrak_max" value="Nilai Kontrak Max" />
            <small class="ml-1" v-show="form.nilai_kontrak_max">: {{ toRupiah(form.nilai_kontrak_max) }}</small>
            <FormInput v-model="form.nilai_kontrak_max" v-bind="{
              type: 'number', id: 'nilai_kontrak_max', size: 'lg', autocomplete: 'off', placeholder: 'Nilai Kontrak Max'
            }" />
          </div>
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <FormLabel for="pic" value="Penanggung Jawab" />
            <FormInput v-model="form.pic" v-bind="{
              type: 'text', id: 'pic', size: 'lg', autocomplete: 'off', placeholder: 'Penanggung Jawab'
            }" />
          </div>
          <div>
            <FormLabel for="status_proyek" value="Status Proyek" />
            <small class="ml-1" v-show="form.status_proyek">: {{ form.status_proyek }}</small>
            <FormSelect v-model="form.status_proyek" v-bind="{
              id: 'status_proyek',
              size: 'lg',
            }">
              <option value="">Cari berdasarkan status</option>
              <option v-for="status in statusProyek" :value="status.statusCode">{{ status.statusName }}</option>
            </FormSelect>
          </div>
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
          text: 'Search',
          loading: form.processing,
          onLoading: () => ({
            text: 'Searching data...',
          })
        }" />
      </ModalFooter>
    </ModalLayout>
  </form>
</template>