<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { RekeningTable } from '@/Components/Master/rekening-page';

// types
import { Rekening } from '@/types';

const breadcrumbs = [
  { label: 'Master', url: '#' },
  { label: 'Rekening', url: '#' }
];

export interface FormOptions {
  banks: string[];
  tujuanRekening: string[];
}

defineProps<{
  rekening: Array<Rekening>;
  formOptions: FormOptions;
}>();
</script>

<template>
  <Head title="Users" />
  <Layout>

    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        />
      </q-breadcrumbs>
    </template>

    <rekening-table
      :rows="rekening"
      :form-options="formOptions"
    />

  </Layout>
</template>