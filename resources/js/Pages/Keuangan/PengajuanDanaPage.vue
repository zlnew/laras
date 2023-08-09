<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { PengajuanDanaTable } from '@/Components/Keuangan/pengajuan-dana-page';

// types
import { PengajuanDana, Proyek } from '@/types';

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Pengajuan Dana', url: '#' }
];

export interface FormOptions {
  proyek: Array<Partial<Proyek>>;
  currentProyek: Array<Proyek>;
}

defineProps<{
  pengajuanDana: Array<PengajuanDana>;
  formOptions: FormOptions;
}>();
</script>

<template>
  <Head title="Pengajuan Dana" />
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

    <pengajuan-dana-table
      :rows="pengajuanDana"
      :form-options="formOptions"
    />

  </layout>
</template>