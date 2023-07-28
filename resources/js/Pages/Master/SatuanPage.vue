<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { SatuanTable } from '@/Components/Master/satuan-page';

// types
import { Satuan } from '@/types';

const breadcrumbs = [
  { label: 'Master', url: '#' },
  { label: 'Satuan', url: '#' }
];

defineProps<{
  satuan: Array<Satuan>;
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

    <satuan-table
      :rows="satuan"
    />

  </Layout>
</template>