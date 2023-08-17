<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { PencairanDanaTable } from '@/Components/Keuangan/pencairan-dana-page'

// types
import type { PencairanDana, Proyek } from '@/types'

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Pencairan Dana', url: '#' }
]

export interface FormOptions {
  currentProyek: Array<Partial<Proyek>>
}

defineProps<{
  pencairanDana: PencairanDana[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="Pencairan Dana" />
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

    <pencairan-dana-table
      :rows="pencairanDana"
      :form-options="formOptions"
    />

  </layout>
</template>
