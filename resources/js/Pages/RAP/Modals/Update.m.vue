<script setup lang="ts">
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import useModalStore from "@/stores/useModalStore";
import { useForm } from "@inertiajs/vue3";
import { FormInput, FormLabel, FormError, FormSelect, FormTextarea } from "@/Components/Form.vue";
import { toRupiah } from "@/utilities/number";
import { DetailRAP, Satuan } from "@/types";

const props = defineProps<{
  detail_rap: DetailRAP;
  satuan: Array<Satuan>;
}>();

const modal = useModalStore();

const form = useForm({
  uraian: props.detail_rap.uraian,
  id_satuan: props.detail_rap.id_satuan,
  volume: props.detail_rap.volume,
  harga_satuan: props.detail_rap.harga_satuan,
  keterangan: props.detail_rap.keterangan,
  status_uraian: props.detail_rap.status_uraian,
});

const status_uraian = ['Gaji', 'Sewa', 'Beli', 'Subkon/Vendor'];

function submit() {
  form.patch(route('rap.update', props.detail_rap.id_detail_rap), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <ModalLayout size="lg">
      <ModalHead title="Form Edit Uraian RAP" />

      <ModalBody>
        <div class="w-full mb-4">
          <FormLabel for="uraian" value="Uraian" />
          <FormInput v-model="form.uraian" v-bind="{
            type: 'text', id: 'uraian', size: 'lg', autocomplete: 'off', placeholder: 'Uraian'
          }" />
          <FormError class="mt-2" :message="form.errors.uraian" />
        </div>

        <div class="w-full mb-4 grid grid-cols-2 gap-4">
          <div>
            <FormLabel for="volume" value="Volume" />
            <FormInput v-model="form.volume" v-bind="{
              type: 'number', id: 'volume', size: 'lg', autocomplete: 'off', placeholder: 'Volume'
            }" />
            <FormError class="mt-2" :message="form.errors.volume" />
          </div>
          <div>
            <FormLabel for="id_satuan" value="Satuan" />
            <FormSelect v-model="form.id_satuan" v-bind="{
              id: 'id_satuan', size: 'lg'
            }">
              <option value="">Pilih Satuan</option>
              <option v-for="unit in satuan" :value="unit.id_satuan">{{ unit.nama_satuan }}</option>
            </FormSelect>
            <FormError class="mt-2" :message="form.errors.id_satuan" />
          </div>
        </div>

        <div class="w-full mb-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <FormLabel for="harga_satuan" value="Harga Satuan" />
              <small class="ml-1" v-show="form.harga_satuan">: {{ toRupiah(form.harga_satuan) }}</small>
            </div>
            <div v-show="form.harga_satuan">
              <FormLabel for="harga_satuan" value="Harga Total" />
              <small class="ml-1">: {{ toRupiah(form.harga_satuan * form.volume) }}</small>
            </div>
          </div>

          <FormInput v-model="form.harga_satuan" v-bind="{
            type: 'number', id: 'harga_satuan', size: 'lg', autocomplete: 'off', placeholder: 'Harga Satuan'
          }" />
          <FormError class="mt-2" :message="form.errors.harga_satuan" />
        </div>

        <div class="w-full mb-4">
          <FormLabel for="status_uraian" value="Status" />
          <FormSelect v-model="form.status_uraian" v-bind="{
            id: 'status_uraian', size: 'lg'
          }">
            <option value="">Pilih Status</option>
            <option v-for="status in status_uraian" :value="status">{{ status }}</option>
          </FormSelect>
          <FormError class="mt-2" :message="form.errors.status_uraian" />
        </div>
        
        <div class="w-full">
          <FormLabel for="keterangan" value="Keterangan" />
          <FormTextarea v-model="form.keterangan" v-bind="{
            type: 'text', id: 'keterangan', size: 'lg', autocomplete: 'off', placeholder: 'Keterangan'
          }" />
          <FormError class="mt-2" :message="form.errors.keterangan" />
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
          text: 'Update',
          loading: form.processing,
          onLoading: () => ({
              text: 'Updating data...',
          })
        }" />
      </ModalFooter>
    </ModalLayout>
  </form>
</template>