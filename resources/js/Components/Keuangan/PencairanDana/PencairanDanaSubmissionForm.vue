<script setup lang="ts">
// cores
import { useQuasar } from 'quasar'
import { useForm } from '@inertiajs/vue3'

// types
import { type PencairanDana } from '@/types'

const $q = useQuasar()

const props = defineProps<{
  data: {
    id_pencairan_dana: PencairanDana['id_pencairan_dana']
  }
}>()

const form = useForm({
  catatan: ''
})

function submit () {
  form.post(route('pencairan_dana.submit', props.data.id_pencairan_dana), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}

function submitPencairanDana () {
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
    form.catatan = payload
    submit()
  })
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-btn
      rounded
      color="primary"
      label="Submit"
      icon-right="check"
      @click="submitPencairanDana"
      class="q-pa-md"
    >
      <q-tooltip>Click to submit</q-tooltip>
    </q-btn>
  </q-page-sticky>
</template>
