<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';

// types
import { DetailPengajuanDana, PengajuanDana } from '@/types';
import { useForm } from '@inertiajs/vue3';

const $q = useQuasar();

const props = defineProps<{
  data: {
    id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
    selected_ids_detail_pengajuan_dana: Array<DetailPengajuanDana['id_detail_pengajuan_dana']> | undefined;
  }
}>();

const form = useForm({
  catatan: ''
});

function approve() {
  form
  .transform(form => ({
    ...form,
    selected_ids_detail_pengajuan_dana: props.data.selected_ids_detail_pengajuan_dana
  }))
  .post(route('pengajuan_dana.approve', props.data.id_pengajuan_dana), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top',
      });
    }
  });
}

function reject() {
  form.post(route('pengajuan_dana.reject', props.data.id_pengajuan_dana), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top',
      });
    }
  });
}

function approvePengajuanDana() {
  $q.dialog({
    title: 'Approval Confirmation',
    message: 'Are you sure want to approve this data?',
    prompt: {
      model: form.catatan,
      type: 'text',
      placeholder: 'Tambahkan Catatan',
      autogrow: true
    },
    cancel: {
      flat: true,
      color: 'secondary'
    },
    ok: 'Confirm',
    persistent: true
  }).onOk((payload) => {
    form.catatan = payload;
    approve();
  });
}

function rejectPengajuanDana() {
  $q.dialog({
    title: 'Rejection Confirmation',
    message: 'Are you sure want to reject this data?',
    prompt: {
      model: form.catatan,
      type: 'text',
      placeholder: 'Tambahkan Catatan',
      autogrow: true
    },
    cancel: {
      flat: true,
      color: 'secondary'
    },
    ok: 'Confirm',
    persistent: true
  }).onOk((payload) => {
    form.catatan = payload;
    reject();
  });
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-fab color="primary" icon="keyboard_arrow_left" direction="left">
      <template v-slot:label="{ opened }">
        <div :class="{ 'example-fab-animate--hover': opened !== true }">
          {{ opened !== true ? 'Approval' : 'Close' }}
        </div>
      </template>

      <q-fab-action
        color="green"
        label="Setujui"
        icon="check"
        :disable="data.selected_ids_detail_pengajuan_dana?.length ? false : true"
        @click="approvePengajuanDana"
      />
      <q-fab-action
        color="red"
        label="Tolak"
        icon="clear"
        :disable="data.selected_ids_detail_pengajuan_dana?.length ? true : false"
        @click="rejectPengajuanDana"
      />
    </q-fab>
  </q-page-sticky>
</template>