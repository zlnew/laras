<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// utils
import { can } from '@/utils/permissions';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import {
  RABItemTable,
  RABSubmissionForm,
  RABApprovalForm,
  RABTopSection,
} from '@/Components/Main/detail-rab-page';

// types
import { DetailRAB, Proyek, RAB, Satuan, Timeline } from '@/types';

export interface FormOptions {
  satuan: Array<Partial<Satuan>>;
}

const props = defineProps<{
  detailRab: Array<DetailRAB>;
  formOptions: FormOptions;
  rab: RAB & Proyek;
  timeline: Array<Timeline>;
}>();

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'RAB', url: route('rab') },
  { label: props.rab.nama_proyek, url: '#' },
];
</script>

<template>
  <Head title="RAB" />
  <layout>
    
    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        />
      </q-breadcrumbs>
    </template>

    <RAB-top-section
      :data="{
        rab: rab,
        timeline: timeline
      }"
    />

    <RAB-item-table
      :rows="detailRab"
      :data="{
        rab: rab
      }"
      :form-options="formOptions"
    />

    <RAB-submission-form
      v-if="can('create & modify rab') && rab.status_aktivitas === 'Dibuat' && detailRab.length"
      :data="{
        id_rab: rab.id_rab,
      }"
    />

    <RAB-approval-form
      v-if="can('approve rab') && rab.status_aktivitas === 'Diajukan'"
      :data="{
        id_rab: rab.id_rab,
      }"
    />

  </layout>
</template>