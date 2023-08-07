<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';

// comps
import { PenagihanShallowAcceptDialog } from '../detail-penagihan-page';

// types
import { Penagihan } from '@/types';
import { useForm } from '@inertiajs/vue3';

const $q = useQuasar();

const props = defineProps<{
  data: {
    id_penagihan: Penagihan['id_penagihan'];
    jumlah_diterima: Penagihan['jumlah_diterima'];
  }
}>();

const form = useForm({
  catatan: null,
});

function accept() {
  form.post(route('penagihan.confirm', props.data.id_penagihan), {
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
  form.post(route('penagihan.reject', props.data.id_penagihan), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top',
      });
    }
  });
}

function acceptPenagihan() {
  $q.dialog({
    title: 'Action Confirmation',
    message: 'Are you sure want to perform this action?',
    prompt: {
      outlined: true,
      autogrow: true,
      model: '',
      type: 'text',
      placeholder: 'Tambahkan Catatan'
    },
    color: 'positive',
    cancel: true,
    persistent: true
  }).onOk((payload) => {
    form.catatan = payload;
    accept();
  });
}

function shallowAcceptPenagihan() {
  $q.dialog({
    component: PenagihanShallowAcceptDialog,
    componentProps: {
      id_penagihan: props.data.id_penagihan,
      jumlah_diterima: props.data.jumlah_diterima
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function rejectPenagihan() {
  $q.dialog({
    title: 'Action Confirmation',
    message: 'Are you sure want to perform this action?',
    prompt: {
      outlined: true,
      autogrow: true,
      model: '',
      type: 'text',
      placeholder: 'Tambahkan Catatan'
    },
    color: 'negative',
    cancel: true,
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
          {{ opened !== true ? 'Verifikasi Penerimaan' : 'Close' }}
        </div>
      </template>

      <q-fab-action
        color="green-7"
        label="Sudah Diterima"
        icon="done_all"
        @click="acceptPenagihan"
      />
      <q-fab-action
        color="secondary"
        label="Diterima Bertahap"
        icon="check"
        @click="shallowAcceptPenagihan"
      />
      <q-fab-action
        color="red"
        label="Tolak"
        icon="clear"
        @click="rejectPenagihan"
      />
    </q-fab>
  </q-page-sticky>
</template>