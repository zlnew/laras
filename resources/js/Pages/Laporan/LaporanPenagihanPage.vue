<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { LaporanPenagihanTable } from '@/Components/Laporan/laporan-page';

// types
import { Penagihan, Proyek } from '@/types';

const breadcrumbs = [
  { label: 'Reports', url: '#' },
  { label: 'Penagihan/Invoice', url: '#' }
];

export interface FormOptions {
  proyek: Array<Proyek>;
}

defineProps<{
  penagihan: Array<Penagihan & {
    jumlah_penagihan: string, sisa_penagihan: string
  }>;
  formOptions: FormOptions;
}>();
</script>

<template>
  <Head title="Laporan Penagihan/Invoice" />
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

    <laporan-penagihan-table
      :rows="penagihan"
      :form-options="formOptions"
    />

  </layout>
</template>