<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { RABTable } from '@/Components/Main/rab-page'

// types
import type { Proyek, RAB } from '@/types'

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'RAB', url: '#' }
]

export interface FormOptions {
  proyek: Array<Partial<Proyek>>
  currentProyek: Proyek[]
}

defineProps<{
  rab: RAB[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="RAB" />
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

    <RAB-table
      :rows="rab"
      :form-options="formOptions"
    />

  </layout>
</template>
