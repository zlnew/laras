<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { LaporanPencairanDanaTable } from '@/Components/Laporan/laporan-page'

// types
import type { PencairanDana, Proyek } from '@/types'

const breadcrumbs = [
  { label: 'Reports', url: '#' },
  { label: 'Pencairan Dana', url: '#' }
]

export interface FormOptions {
  proyek: Proyek[]
}

defineProps<{
  pencairanDana: PencairanDana[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="Laporan Pengajuan Dana" />
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

    <laporan-pencairan-dana-table
      :rows="pencairanDana"
      :form-options="formOptions"
    />

  </layout>
</template>
