<script setup lang="ts">
// cores
import { useQuasar } from 'quasar'

// types
import { type PencairanDana } from '@/types'
import { useForm } from '@inertiajs/vue3'

const $q = useQuasar()

const props = defineProps<{
  data: {
    id_pencairan_dana: PencairanDana['id_pencairan_dana']
  }
}>()

const form = useForm({
  catatan: ''
})

function accept () {
  form.post(route('pencairan_dana.confirm', props.data.id_pencairan_dana), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}

function shallowAccept () {
  form
    .transform(form => ({
      ...form,
      bertahap: true
    }))
    .post(route('pencairan_dana.confirm', props.data.id_pencairan_dana), {
      onSuccess: (page) => {
        $q.notify({
          type: 'positive',
          message: page.props.flash.success,
          position: 'top'
        })
      }
    })
}

function reject () {
  form.post(route('pencairan_dana.reject', props.data.id_pencairan_dana), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}

function acceptPengajuanDana () {
  $q.dialog({
    title: 'Receipt Confirmation',
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
    form.catatan = payload
    accept()
  })
}

function shallowAcceptPengajuanDana () {
  $q.dialog({
    title: 'Receipt Confirmation',
    message: 'Are you sure want to perform this action?',
    prompt: {
      outlined: true,
      autogrow: true,
      model: '',
      type: 'text',
      placeholder: 'Tambahkan Catatan'
    },
    color: 'secondary',
    cancel: true,
    persistent: true
  }).onOk((payload) => {
    form.catatan = payload
    shallowAccept()
  })
}

function rejectPengajuanDana () {
  $q.dialog({
    title: 'Rejection Confirmation',
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
    form.catatan = payload
    reject()
  })
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-fab color="primary" icon="keyboard_arrow_left" direction="left">
      <template v-slot:label="{ opened }">
        <div :class="{ 'example-fab-animate--hover': opened !== true }">
          {{ opened !== true ? 'Konfirmasi Penerimaan' : 'Close' }}
        </div>
      </template>

      <q-fab-action
        color="green"
        label="Terima Lunas"
        icon="check"
        @click="acceptPengajuanDana"
      />
      <q-fab-action
        color="secondary"
        label="Terima Bertahap"
        icon="check"
        @click="shallowAcceptPengajuanDana"
      />
      <q-fab-action
        color="red"
        label="Tolak"
        icon="clear"
        @click="rejectPengajuanDana"
      />
    </q-fab>
  </q-page-sticky>
</template>
