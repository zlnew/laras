<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { DashboardOverview } from '@/Components/dashboard-page';
</script>

<template>
  <Head title="Dashboard" />
  <layout>
    <dashboard-overview />
  </layout>
</template>