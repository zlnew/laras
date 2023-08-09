<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// utils
import { can, isApprovable, isEditable } from '@/utils/permissions';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import {
  RABItemTable,
  RABSubmissionForm,
  RABApprovalForm,
} from '@/Components/Main/detail-rab-page';
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue';

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

    <module-top-section
      title="RAB"
      timeline-title="Timeline Pengajuan RAB"
      :data="{
        proyek: rab,
        status: rab.status_rab,
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
      v-if="can('create & modify rab') && isEditable(rab) && detailRab.length"
      :data="{
        id_rab: rab.id_rab,
      }"
    />

    <RAB-approval-form
      v-if="can('approve rab') && isApprovable(rab)"
      :data="{
        id_rab: rab.id_rab,
      }"
    />

  </layout>
</template>