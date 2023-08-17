<script setup lang="ts">
// cores
import { useQuasar } from 'quasar'
import { useForm } from '@inertiajs/vue3'

// types
import type { RAB } from '@/types'

const $q = useQuasar()

const props = defineProps<{
  data: {
    id_rab: RAB['id_rab']
  }
}>()

const form = useForm({
  catatan: ''
})

function approve () {
  form.post(route('rab.approve', props.data.id_rab), {
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
  form.post(route('rab.reject', props.data.id_rab), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}

function approveRAB () {
  $q.dialog({
    title: 'Approval Confirmation',
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
    approve()
  })
}

function rejectRAB () {
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
          {{ opened !== true ? 'Approval' : 'Close' }}
        </div>
      </template>

      <q-fab-action color="green-5" label="Setujui" icon="check" @click="approveRAB" />
      <q-fab-action color="red" label="Tolak" icon="clear" @click="rejectRAB" />
    </q-fab>
  </q-page-sticky>
</template>
