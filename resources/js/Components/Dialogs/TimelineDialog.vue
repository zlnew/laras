<script setup lang="ts">
// cores
import { useDialogPluginComponent } from 'quasar';

// utils
import { fullDate } from '@/utils/date';

// types
import { Timeline } from '@/types';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogCancel, onDialogHide } = useDialogPluginComponent();

interface JoinedWithTimeline {
  user_name: string;
  user_role: string;
}

defineProps<{
  title: string;
  timeline: Array<Timeline & JoinedWithTimeline>;
}>();

const icon = (status: Timeline['status_aktivitas']) => {
   switch (status) {
    case 'Dibuat': return 'commit';
    case 'Diajukan': return 'send';
    case 'Ditolak': return 'priority_high';
    case 'Dievaluasi': return 'done';
    case 'Diperiksa': return 'done';
    case 'Disetujui': return 'done_all';
   }
};

const color = (status: Timeline['status_aktivitas']) => {
   switch (status) {
    case 'Dibuat': return 'secondary';
    case 'Diajukan': return 'primary';
    case 'Ditolak': return 'red';
    case 'Dievaluasi': return 'green';
    case 'Diperiksa': return 'green';
    case 'Disetujui': return 'green';
   }
};
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">{{ title }}</div>
          <q-space />
          <q-btn
            flat
            round
            dense
            icon="close"
            @click="onDialogCancel"
          />
        </q-card-section>

      <q-separator />

      <q-card-section class="scroll">
        <div class="q-px-lg q-py-md">
          <q-timeline layout="comfortable" color="secondary">
            <q-timeline-entry
              v-for="tl in timeline"
              :key="tl.id_timeline"
              :subtitle="(fullDate(tl.created_at) as string)"
              :body="tl.catatan"
              :color="color(tl.status_aktivitas)"
              :icon="icon(tl.status_aktivitas)"
            >
              <template v-slot:title>
                <div class="text-subtitle1">{{ tl.status_aktivitas }}</div>
                <div class="text-caption text-grey-8">
                  Oleh
                  <span class="text-weight-bold">{{ tl.user_name }}</span>
                  -
                  <span class="text-capitalize">{{ tl.user_role }}</span>
                </div>
              </template>
            </q-timeline-entry>
          </q-timeline>
        </div>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>