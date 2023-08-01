<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';

// comps
import { PengajuanDanaEvaluationDialog } from '@/Components/Keuangan/detail-pengajuan-dana-page';

// types
import { DetailPengajuanDana, PengajuanDana } from '@/types';
import { Evaluasi } from '@/Pages/Keuangan/DetailPengajuanDanaPage.vue';
import { ApprovedPengajuanSaatIni } from './PengajuanDanaItem/PengajuanDanaItemTable.vue';

const $q = useQuasar();

const props = defineProps<{
  data: {
    id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
    selected_ids_detail_pengajuan_dana: Array<DetailPengajuanDana['id_detail_pengajuan_dana']> | undefined;
    approvedPengajuanSaatIni: Array<ApprovedPengajuanSaatIni> | undefined;
    evaluasi: Array<Evaluasi>;
  }
}>();

function lembarEvaluasi() {
  $q.dialog({
    component: PengajuanDanaEvaluationDialog,
    componentProps: {
      data: props.data
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}
</script>

<template>
  <q-page-sticky position="bottom-right" :offset="[18, 18]">
    <q-btn
      rounded
      label="Evaluasi"
      color="green"
      icon="keyboard_arrow_left"
      @click="lembarEvaluasi"
    >
      <q-tooltip>Evaluasi Pengajuan</q-tooltip>
    </q-btn>
  </q-page-sticky>
</template>