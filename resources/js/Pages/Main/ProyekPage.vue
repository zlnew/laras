<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { ProyekTable } from '@/Components/Main/proyek-page'

// types
import type { Proyek, Rekening, User } from '@/types'

const breadcrumbs = [
  { label: 'Main', url: '#' },
  { label: 'Proyek', url: '#' }
]

export interface FormOptions {
  penggunaJasa: string[]
  penyediaJasa: string[]
  tahunAnggaran: string[]
  pic: User[]
  currentPic: User[]
  rekening: Rekening[]
}

defineProps<{
  proyek: Proyek[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="Proyek" />
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

    <proyek-table
      :rows="proyek"
      :form-options="formOptions"
    />

  </layout>
</template>
