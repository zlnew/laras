<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';
import { useForm } from '@inertiajs/vue3';

// types
import { RAP } from '@/types';

const $q = useQuasar();

const props = defineProps<{
  data: {
    id_rap: RAP['id_rap'];
  }
}>();

const form = useForm({
  catatan: ''
});

function submit() {
  form.post(route('rap.submit', props.data.id_rap), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top',
      });
    }
  });
}

function submitRAP() {
  $q.dialog({
    title: 'Submission Confirmation',
    message: 'Are you sure want to submit this data?',
    prompt: {
      outlined: true,
      autogrow: true,
      model: '',
      type: 'text',
      placeholder: 'Tambahkan Catatan'
    },
    color: 'primary',
    cancel: true,
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
      @click="submitRAP"
    >
      <q-tooltip>Click to submit</q-tooltip>
    </q-btn>
  </q-page-sticky>
</template>