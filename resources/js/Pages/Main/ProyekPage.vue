<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { ProyekTable } from '@/Components/Main/proyek-page';
import { Proyek } from '@/types';

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'Proyek', url: '#' }
];

export interface ProyekFilterOptions {
  pengguna_jasa: string[];
  tahun_anggaran: string[];
  pic: string[];
}

defineProps<{
  proyek: Array<Proyek>;
  filterOptions: ProyekFilterOptions;
}>();
</script>

<template>
  <Head title="Proyek" />
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

    <proyek-table :rows="proyek" :filter-options="filterOptions" />

  </layout>
</template>