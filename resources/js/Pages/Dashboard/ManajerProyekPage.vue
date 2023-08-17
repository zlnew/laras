<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { DashboardOverview } from '@/Components/Dashboard/dashboard-page'
import { ProyekTable, ReminderTable } from '@/Components/Dashboard/ManajerProyek/dashboard-manajer-proyek-page'

// types
import type { Proyek } from '@/types'
import type { OverviewProps } from '@/Components/Dashboard/DashboardOverview.vue'

const breadcrumbs = [
  { label: 'Dashboard', url: '#' },
  { label: 'Overview', url: '#' }
]

export interface JoinedWithProyek {
  nilai_kontrak: string
  rab: string
  pengajuan_sebelumnya: string
  pengajuan_dalam_proses: string
  total_pengajuan: string
  sisa_anggaran: string
  estimasi_laba: string
  persentase_laba: string
}

export interface Reminder {
  id_pengajuan_dana: string
  nama_proyek: string
  keperluan: string
  status_pengajuan: '100' | '400'
  catatan: string
}

defineProps<{
  proyek: Array<Proyek & JoinedWithProyek>
  reminder: Reminder[]
  overview: OverviewProps[]
}>()
</script>

<template>
  <Head title="Dashboard" />
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

    <dashboard-overview
      :overview="overview"
    />

    <proyek-table
      :rows="proyek"
    />

    <reminder-table
      v-if="reminder.length"
      :rows="reminder"
    />
  </layout>
</template>
