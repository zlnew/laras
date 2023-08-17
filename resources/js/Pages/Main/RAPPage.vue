<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { RAPTable } from '@/Components/Main/rap-page'

// types
import type { Proyek, RAP } from '@/types'

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'RAP', url: '#' }
]

export interface FormOptions {
  proyek: Array<Partial<Proyek>>
  currentProyek: Proyek[]
}

defineProps<{
  rap: RAP[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="RAPP" />
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

    <RAP-table
      :rows="rap"
      :form-options="formOptions"
    />

  </layout>
</template>
