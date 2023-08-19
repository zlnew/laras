<script setup lang="ts">
// cores
import { useQuasar } from 'quasar'

// comps
import { PenagihanConfirmDialog } from '../detail-penagihan-page'

// types
import { type Penagihan } from '@/types'
import type { Evaluasi } from '@/Pages/Keuangan/DetailPenagihanPage.vue'

const $q = useQuasar()

const props = defineProps<{
  data: {
    id_penagihan: Penagihan['id_penagihan']
    jumlah_diterima: Penagihan['jumlah_diterima']
    evaluasi: Evaluasi[]
  }
}>()

function confirm () {
  $q.dialog({
    component: PenagihanConfirmDialog,
    componentProps: {
      data: props.data
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-btn
      rounded
      label="Konfirmasi Penerimaan"
      color="primary"
      icon="keyboard_arrow_left"
      @click="confirm"
      class="q-pa-md"
    >
      <q-tooltip>Konfirmasi Penerimaan</q-tooltip>
    </q-btn>
  </q-page-sticky>
</template>
