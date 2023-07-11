<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError, FormSelect, FormTextarea } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailRAB, Satuan } from "@/types";

const props = defineProps<{
  detail_rab: DetailRAB;
  satuan: Array<Satuan>;
}>();

const modal = useModalStore();

const form = useForm({
  uraian: props.detail_rab.uraian,
  id_satuan: props.detail_rab.id_satuan,
  volume: props.detail_rab.volume,
  harga_satuan: props.detail_rab.harga_satuan,
  keterangan: props.detail_rab.keterangan,
});

function submit() {
  form.patch(route('detail_rab.update', props.detail_rab.id_detail_rab), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="lg">
      <modal-head title="Form Edit Uraian RAB" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="uraian" value="Uraian" />

          <form-input v-model="form.uraian"
            v-bind="{
              type: 'text',
              id: 'uraian',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Uraian'
            }"
          />

          <form-error class="mt-2" :message="form.errors.uraian" />
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <form-label for="volume" value="Volume" />

            <form-input v-model="form.volume"
              v-bind="{
                type: 'number',
                id: 'volume',
                size: 'lg',
                autocomplete: 'off',
                placeholder: 'Volume'
              }"
            />

            <form-error class="mt-2" :message="form.errors.volume" />
          </div>
          <div>
            <form-label for="id_satuan" value="Satuan" />

            <form-select v-model="form.id_satuan"
              v-bind="{
                id: 'id_satuan',
                size: 'lg'
              }">
              <option value="">Pilih Satuan</option>
              <option
                v-for="unit in satuan"
                :value="unit.id_satuan">
                {{ unit.nama_satuan }}
              </option>
            </form-select>

            <form-error class="mt-2" :message="form.errors.id_satuan" />
          </div>
        </div>

        <div class="w-full mb-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <form-label for="harga_satuan" value="Harga Satuan" />
              <small class="ml-1" v-show="form.harga_satuan">
                : {{ toRupiah(form.harga_satuan) }}
              </small>
            </div>
            <div v-show="form.harga_satuan">
              <form-label for="harga_satuan" value="Harga Total" />
              <small class="ml-1">:
                {{ toRupiah(form.harga_satuan * form.volume) }}
              </small>
            </div>
          </div>

          <form-input v-model="form.harga_satuan"
            v-bind="{
              type: 'number',
              id: 'harga_satuan',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Harga Satuan'
            }"
          />
          <form-error class="mt-2" :message="form.errors.harga_satuan" />
        </div>
        
        <div class="w-full">
          <form-label for="keterangan" value="Keterangan" />

          <form-textarea v-model="form.keterangan"
            v-bind="{
              type: 'text',
              id: 'keterangan',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Keterangan'
            }"
          />

          <form-error class="mt-2" :message="form.errors.keterangan" />
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