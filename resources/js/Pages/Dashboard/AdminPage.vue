<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { DashboardOverview } from '@/Components/Dashboard/dashboard-page';

const breadcrumbs = [
  { label: 'Dashboard', url: '#' },
  { label: 'Overview', url: '#' }
];
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

    <dashboard-overview />
  </layout>
</template>