<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { DashboardOverview } from '@/Components/Dashboard/dashboard-page'
import { ProyekTable, PiutangTable } from '@/Components/Dashboard/KepalaDivisi/dashboard-kepala-divisi-page'

// types
import type { Proyek } from '@/types'
import type { OverviewProps } from '@/Components/Dashboard/DashboardOverview.vue'

const breadcrumbs = [
  { label: 'Dashboard', url: '#' },
  { label: 'Overview', url: '#' }
]

export interface JoinedWithProyek {
  nilai_kontrak: string
  termin_sebelumnya: string
  termin_dalam_proses: string
  total_pencairan: string
  sisa_penagihan: string
}

export interface Piutang {
  id_penagihan: string
  keperluan: string
  pengguna_jasa: string
  id_user: number
  jumlah_piutang: string
}

export interface Options {
  pic: Array<{
    id: number
    name: string
  }>
  penggunaJasa: string[]
}

defineProps<{
  proyek: Array<Proyek & JoinedWithProyek>
  piutang: Piutang[]
  overview: OverviewProps[]
  options: Options
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

    <piutang-table
      :rows="piutang"
      :options="options"
    />
  </layout>
</template>
