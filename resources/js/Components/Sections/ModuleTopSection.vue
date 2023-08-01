<script setup lang="ts">
// cores
import { useQuasar } from 'quasar';

// utils
import { isRejected, isApproved, isSubmitted, isEvaluated } from '@/utils/permissions';

// comps
import { ProyekDetailDialog } from '@/Components/Main/proyek-page';
import TimelineDialog from '@/Components/Dialogs/TimelineDialog.vue';

// types
import { Proyek, Timeline } from '@/types';

interface JoinedWithProyek {
  status_aktivitas: Timeline['status_aktivitas'];
}

const props = defineProps<{
  data: {
    proyek: Proyek & JoinedWithProyek;
    timeline: Array<Timeline>;
    status: 100 | 400;
  },
  title: string;
  timelineTitle: string;
}>();

const $q = useQuasar();

function detailProyek() {
  $q.dialog({
    component: ProyekDetailDialog,
    componentProps: {
      proyek: props.data.proyek,
    }
  });
}

function timeline() {
  $q.dialog({
    component: TimelineDialog,
    componentProps: {
      title: props.timelineTitle,
      timeline: props.data.timeline,
    }
  });
}
</script>

<template>
  <div class="q-px-md q-pt-md">
    <q-card flat bordered>
      <div class="row justify-between items-center">
        <q-card-section class="col-6">
          <q-btn flat no-caps dense @click="detailProyek">
            <div class="text-h6 line-clamp">
              {{ title }} - {{ data.proyek.nama_proyek }}
            </div>
            <q-tooltip>{{ data.proyek.nama_proyek }}</q-tooltip>
          </q-btn>
        </q-card-section>

        <q-card-section class="q-gutter-x-sm">
          <q-btn
            v-if="isRejected(data.proyek)"
            flat
            dense
            round
            color="grey-6"
            icon="warning"
          >
            <q-tooltip>Ditolak</q-tooltip>
          </q-btn>

          <q-btn
            v-if="isApproved(data.proyek)"
            flat
            dense
            round
            color="grey"
            icon="done_all"
          >
            <q-tooltip>Telah Disetujui</q-tooltip>
          </q-btn>

          <q-btn
            v-if="isSubmitted(data.proyek) || isEvaluated(data.proyek)"
            flat
            dense
            round
            color="grey"
            icon="rotate_right"
          >
            <q-tooltip>Menunggu Persetujuan</q-tooltip>
          </q-btn>

          <q-btn
            rounded
            icon-right="expand_more"
            :label="data.status == 400 ? 'Closed' : 'Open'"
            :color="data.status == 400 ? 'red' : 'primary'"
            @click="timeline"
          >
            <q-tooltip>Lihat Timeline {{ title }}</q-tooltip>
          </q-btn>
        </q-card-section>
      </div>
    </q-card>
  </div>
</template>