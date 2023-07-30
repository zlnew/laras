<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';

// comps
import { ProyekDetailDialog } from '@/Components/Main/proyek-page';
import { RABTimeline } from '@/Components/Main/detail-rab-page';

// types
import { Proyek, RAB, Timeline } from '@/types';

const props = defineProps<{
  data: {
    rab: RAB & Proyek;
    timeline: Array<Timeline>;
  }
}>();

const $q = useQuasar();

function detailProyek() {
  $q.dialog({
    component: ProyekDetailDialog,
    componentProps: {
      proyek: props.data.rab,
    }
  });
}

function timelineRAB() {
  $q.dialog({
    component: RABTimeline,
    componentProps: {
      timeline: props.data.timeline,
    }
  });
}
</script>

<template>
  <div class="q-px-md">
    <q-card flat bordered>
      <div class="row justify-between items-center">
        <q-card-section class="flex items-center">
          <div class="text-h6">RAB - {{ data.rab.nama_proyek }}</div>
          <q-btn
            flat
            round
            color="secondary"
            icon="info"
            @click="detailProyek"
            class="q-ml-sm"
          >
            <q-tooltip>Detail Proyek</q-tooltip>
          </q-btn>
        </q-card-section>

        <q-card-section>
          <q-btn
            rounded
            :label="data.rab.status_rab == 400 ? 'Closed' : 'Open'"
            :color="data.rab.status_rab == 400 ? 'red' : 'primary'"
            icon="expand_more"
            @click="timelineRAB"
          >
            <q-tooltip>Lihat Status RAB</q-tooltip>
          </q-btn>
        </q-card-section>
      </div>
    </q-card>
  </div>
</template>