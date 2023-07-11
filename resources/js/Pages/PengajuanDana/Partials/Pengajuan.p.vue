<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { FormLabel, FormTextarea } from '@/Components/Form.vue';
import { PengajuanDana } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
  detail_pengajuan_dana_length: number;
}>();

const form = useForm({
  catatan: null,
});

function submit() {
  form.post(route('pengajuan_dana.submit', props.id_pengajuan_dana));
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl">Submit</h5>
      </div>
    </card-header>
    <card-body>
      <div class="flex justify-between items-center space-x-4">
        <div class="w-full mb-4">
          <form-label value="Catatan" />
          <form-textarea v-model="form.catatan" placeholder="Beri catatan" />
        </div>
  
        <div class="flex justify-end space-x-2">  
          <form @submit.prevent="submit">
            <ease-button v-bind="{
              type: 'submit',
              text: 'Submit',
              disabled: detail_pengajuan_dana_length < 1,
            }" />
          </form>
        </div>
      </div>
    </card-body>
  </card-layout>
</template>