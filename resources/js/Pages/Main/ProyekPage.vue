<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { ProyekTable } from '@/Components/Main/proyek-page';

// types
import { Proyek, Rekening } from '@/types';

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'Proyek', url: '#' }
];

export interface ProyekFilterOptions {
  pengguna_jasa: string[];
  tahun_anggaran: string[];
  pic: string[];
  rekening: Array<Rekening>;
}

defineProps<{
  proyek: Array<Proyek>;
  rekening: Array<Rekening>;
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

    <proyek-table
      :rows="proyek"
      :rekening="rekening"
      :filter-options="filterOptions"
    />

  </layout>
</template>