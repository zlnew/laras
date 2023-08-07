<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { DashboardOverview } from '@/Components/Dashboard/dashboard-page';
import { ProyekTable } from '@/Components/Dashboard/KepalaDivisi/dashboard-kepala-divisi-page';

// types
import { Proyek } from '@/types';
import { OverviewProps } from '@/Components/Dashboard/DashboardOverview.vue';

const breadcrumbs = [
  { label: 'Dashboard', url: '#' },
  { label: 'Overview', url: '#' }
];

export interface JoinedWithProyek {
  nilai_kontrak: string;
  termin_sebelumnya: string;
  termin_dalam_proses: string;
  total_pencairan: string;
  sisa_penagihan: string;
}

defineProps<{
  proyek: Array<Proyek & JoinedWithProyek>;
  overview: OverviewProps[];
}>();
</script>

<template>
  <Head title="Dashboard" />
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

    <dashboard-overview
      :overview="overview"
    />

    <proyek-table
      :rows="proyek"
    />
  </layout>
</template>