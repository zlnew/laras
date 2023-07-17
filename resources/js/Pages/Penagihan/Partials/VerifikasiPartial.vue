<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { FormLabel, FormTextarea } from '@/Components/Form.vue';
import { DetailPenagihan, Penagihan } from '@/types';
import { TotalAmountPenagihan } from '../Detail.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
  id_penagihan: Penagihan['id_penagihan'];
  group_of_id_detail_penagihan: Array<DetailPenagihan['id_detail_penagihan']> | undefined;
  total_amount: TotalAmountPenagihan;
}>();

const disabled = computed(() => {
  if (props.total_amount.diterima !== undefined) {
    if (typeof props.group_of_id_detail_penagihan === undefined && props.group_of_id_detail_penagihan === undefined) {
      return true;
    }

    if (props.group_of_id_detail_penagihan instanceof Array && props.group_of_id_detail_penagihan.length) {
      return false;
    }
  }

  return true;
});

const form = useForm<{
  group_of_id_detail_penagihan?: number[] | undefined;
  catatan: string | null;
}>({
  group_of_id_detail_penagihan: undefined,
  catatan: null,
});

function addDataBeforeSubmit() {
  form.group_of_id_detail_penagihan = props.group_of_id_detail_penagihan;
}

function accept() {
  addDataBeforeSubmit();
  form.post(route('penagihan.accept', props.id_penagihan));
}

function decline() {
  form.post(route('penagihan.decline', props.id_penagihan));
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Verifikasi Penerimaan</h5>
      </div>
    </card-header>
    <card-body>
      <div class="flex justify-between items-center space-x-4">
        <div class="w-full mb-4">
          <form-label value="Catatan" />
          <form-textarea v-model="form.catatan" placeholder="Beri catatan" />
        </div>
      </div>

      <div class="flex justify-end space-x-2">
          <form @submit.prevent="decline">
            <ease-button v-bind="{
              variant: 'danger',
              type: 'submit',
              text: 'Tolak Penagihan',
              disabled: !disabled
            }" />
          </form>
  
          <form @submit.prevent="accept">
            <ease-button v-bind="{
              type: 'submit',
              text: 'Sudah diterima',
              disabled: disabled
            }" />
          </form>
      </div>
    </card-body>
  </card-layout>
</template>