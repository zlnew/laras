<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { PenagihanTable } from '@/Components/Keuangan/penagihan-page'

// types
import type { Penagihan, Proyek } from '@/types'

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Penagihan/Invoice', url: '#' }
]

export interface FormOptions {
  proyek: Array<Partial<Proyek>>
  currentProyek: Proyek[]
}

defineProps<{
  penagihan: Penagihan[]
  formOptions: FormOptions
}>()
</script>

<template>
  <Head title="Penagihan/Invoice" />
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

    <penagihan-table
      :rows="penagihan"
      :form-options="formOptions"
    />

  </layout>
</template>
