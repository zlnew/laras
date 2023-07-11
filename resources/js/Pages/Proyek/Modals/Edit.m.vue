<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { Proyek } from "@/types";
import useModalStore from "@/stores/useModalStore";

const props = defineProps<{
  proyek: Proyek,
}>();

const modal = useModalStore();

const form = useForm({
  nama_proyek: props.proyek.nama_proyek,
  tahun_anggaran: props.proyek.tahun_anggaran,
  pengguna_jasa: props.proyek.pengguna_jasa,
  waktu_mulai: props.proyek.waktu_mulai,
  waktu_selesai: props.proyek.waktu_selesai,
  nilai_kontrak: props.proyek.nilai_kontrak,
  pic: props.proyek.pic,
});

function update() {
  form.patch(route('proyek.update', props.proyek.id_proyek), {
    onSuccess:() => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="update">
    <modal-layout size="5xl">
      <modal-head title="Form Edit Proyek" />
  
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
            }"
          />

          <form-error class="mt-2" :message="form.errors.nama_proyek" />
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

            <form-error class="mt-2" :message="form.errors.pengguna_jasa" />
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

            <form-error class="mt-2" :message="form.errors.tahun_anggaran" />
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
  
              <form-error class="mt-2" :message="form.errors.waktu_mulai" />
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
  
              <form-error class="mt-2" :message="form.errors.waktu_selesai" />
            </div>
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
            <div>
              <form-label for="nilai_kontrak" value="Nilai Kontrak" />
              <small class="ml-1" v-show="form.nilai_kontrak">: {{ toRupiah(form.nilai_kontrak) }}</small>
              
              <form-input v-model="form.nilai_kontrak"
                v-bind="{
                  type: 'number',
                  id: 'nilai_kontrak',
                  size: 'lg',
                  autocomplete: 'off',
                  placeholder: 'Nilai Kontrak'
                }" />
  
              <form-error class="mt-2" :message="form.errors.nilai_kontrak" />
            </div>
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

              <form-error class="mt-2" :message="form.errors.pic" />
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