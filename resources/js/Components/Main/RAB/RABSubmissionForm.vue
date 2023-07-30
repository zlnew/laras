<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';
import { useForm } from '@inertiajs/vue3';

// types
import { RAB } from '@/types';

const $q = useQuasar();

const props = defineProps<{
  data: {
    id_rab: RAB['id_rab'];
  }
}>();

const form = useForm({
  catatan: ''
});

function submit() {
  form.post(route('rab.submit', props.data.id_rab), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top',
      });
    }
  });
}

function submitRAB() {
  $q.dialog({
    title: 'Submission Confirmation',
    message: 'Are you sure want to submit this data?',
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
    submit();
  });
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-btn
      rounded
      color="primary"
      label="Submit"
      icon-right="check"
      @click="submitRAB"
    >
      <q-tooltip>Click to submit</q-tooltip>
    </q-btn>
  </q-page-sticky>
</template>