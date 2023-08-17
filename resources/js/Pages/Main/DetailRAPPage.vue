<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// utils
import { can, isApprovable, isEditable } from '@/utils/permissions'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import {
  RAPItemTable,
  RAPSubmissionForm,
  RAPApprovalForm
} from '@/Components/Main/detail-rap-page'
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue'

// types
import type { DetailRAB, DetailRAP, Proyek, RAB, RAP, Satuan, Timeline } from '@/types'

export interface FormOptions {
  satuan: Array<Partial<Satuan>>
}

const props = defineProps<{
  rap: RAP & Proyek
  detailRap: DetailRAP[]
  rab: RAB
  detailRab: DetailRAB[]
  formOptions: FormOptions
  timeline: Timeline[]
}>()

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'RAP', url: route('rap') },
  { label: props.rap.nama_proyek, url: '#' }
]
</script>

<template>
  <Head title="RAPP" />
  <layout>

    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :key="breadcrumb.label"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        />
      </q-breadcrumbs>
    </template>

    <module-top-section
      title="RAP"
      timeline-title="Timeline Pengajuan RAP"
      :data="{
        proyek: rap,
        status: rap.status_rap,
        timeline: timeline
      }"
    />

    <RAP-item-table
      :rows="detailRap"
      :data="{
        rap: rap,
        rab: rab,
        detailRab: detailRab
      }"
      :form-options="formOptions"
    />

    <RAP-submission-form
      v-if="can('create & modify rap') && isEditable(rap) && detailRap.length"
      :data="{
        id_rap: rap.id_rap,
      }"
    />

    <RAP-approval-form
      v-if="can('approve rap') && isApprovable(rap)"
      :data="{
        id_rap: rap.id_rap,
      }"
    />

  </layout>
</template>
