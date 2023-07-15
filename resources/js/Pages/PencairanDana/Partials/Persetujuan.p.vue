<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { FormLabel, FormSelect, FormTextarea } from '@/Components/Form.vue';
import { PencairanDana } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  id_pencairan_dana: PencairanDana['id_pencairan_dana'];
}>();

const form = useForm({
  catatan: null,
  is_lunas: null,
});

function accept() {
  form.post(route('pencairan_dana.accept', props.id_pencairan_dana));
}

// function reject() {
//   form.post(route('pengajuan_dana.refuse', props.id_pencairan_dana));
// }
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Konfirmasi Penerimaan</h5>
      </div>
    </card-header>
    <card-body>
      <div class="w-full mb-4">
          <form-label id="is_lunas" value="Apakah sudah lunas?" />

          <form-select v-model="form.is_lunas"
            id="is_lunas"
            size="lg">
            <option value="">Pilih Opsi</option>
            <option value="false">Belum</option>
            <option value="true">Ya, sudah lunas</option>
          </form-select>
        </div>

        <div class="w-full mb-4">
          <form-label id="catatan" value="Catatan" />

          <form-textarea v-model="form.catatan"
            id="catatan"
            placeholder="Beri catatan"
          />
        </div>
  
        <div class="flex justify-end space-x-2">
          <form @submit.prevent="accept">
            <ease-button v-bind="{
              type: 'submit',
              text: 'Konfirmasi',
            }" />
          </form>
        </div>
    </card-body>
  </card-layout>
</template>