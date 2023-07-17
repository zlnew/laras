<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { FormLabel, FormTextarea } from '@/Components/Form.vue';
import { DetailPengajuanDana, PengajuanDana } from '@/types';
import { TotalAmountPengajuanDana } from '../Detail.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
  group_of_id_detail_pengajuan_dana: Array<DetailPengajuanDana['id_detail_pengajuan_dana']> | undefined;
  total_amount: TotalAmountPengajuanDana;
}>();

const form = useForm<{
  group_of_id_detail_pengajuan_dana?: number[] | undefined;
  catatan: string | null;
}>({
  group_of_id_detail_pengajuan_dana: undefined,
  catatan: null,
});

function addDataBeforeSubmit() {
  form.group_of_id_detail_pengajuan_dana = props.group_of_id_detail_pengajuan_dana;
}

function approve() {
  addDataBeforeSubmit();
  form.post(route('pengajuan_dana.approve', props.id_pengajuan_dana));
}

function refuse() {
  form.post(route('pengajuan_dana.refuse', props.id_pengajuan_dana));
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Approval</h5>
      </div>
    </card-header>
    <card-body>
      <div class="flex justify-between items-center space-x-4">
        <div class="w-full mb-4">
          <form-label value="Catatan" />
          <form-textarea v-model="form.catatan" placeholder="Beri catatan" />
        </div>
  
        <div class="flex justify-end space-x-2">
          <form @submit.prevent="refuse">
            <ease-button v-bind="{
              variant: 'danger',
              type: 'submit',
              text: 'Tolak',
              disabled: total_amount.disetujui !== undefined
            }" />
          </form>
  
          <form @submit.prevent="approve">
            <ease-button v-bind="{
              type: 'submit',
              text: 'Setujui',
              disabled: total_amount.disetujui === undefined
            }" />
          </form>
        </div>
      </div>
    </card-body>
  </card-layout>
</template>