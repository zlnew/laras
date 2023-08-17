<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

// utils
import { can, isEditable, isSubmitted } from '@/utils/permissions'
import { fullDate } from '@/utils/date'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import {
  PencairanDanaItemTable,
  PencairanDanaSubmissionForm,
  PencairanDanaApprovalForm
} from '@/Components/Keuangan/detail-pencairan-dana-page'
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue'
import { FilesTable } from '@/Components/Files/files-page'

// types
import type { DetailPencairanDana, DetailPengajuanDana, File, PencairanDana, PengajuanDana, Proyek, Timeline } from '@/types'

export interface JoinedWithDetailPengajuanDana {
  pembayaran_lalu: string
  pembayaran_saat_ini: string
  belum_dibayarkan: string
}

const props = defineProps<{
  pencairanDana: PencairanDana & Proyek
  pengajuanDana: PengajuanDana
  detailPencairanDana: DetailPencairanDana[]
  detailPengajuanDana: Array<DetailPengajuanDana & JoinedWithDetailPengajuanDana>
  dokumenPenunjang: File[]
  timeline: Timeline[]
}>()

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Pencairan Dana', url: route('pencairan_dana') },
  { label: props.pencairanDana.nama_proyek, url: '#' }
]

const tab = ref('uraian')
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
        >
        </q-breadcrumbs-el>
      </q-breadcrumbs>
    </template>

    <module-top-section
      title="Pencairan Dana"
      timeline-title="Timeline Pencairan Dana"
      :data="{
        proyek: pencairanDana,
        status: pencairanDana.status_pencairan,
        timeline: timeline
      }"
    />

    <div class="q-px-md q-pt-md">
      <q-card flat bordered style="max-width: 500px">
        <q-card-section>
          <div class="row">
            <div class="col-4 text-caption">
              Keperluan
            </div>
            <div class="col-8 text-subtitle2">
              : {{ pengajuanDana.keperluan }}
            </div>

            <div class="col-4 text-caption">
              Tanggal Pengajuan
            </div>
            <div class="col-8 text-subtitle2">
              : {{ fullDate(pengajuanDana.tanggal_pengajuan) || '-' }}
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>

    <div class="q-px-md q-pt-md">
      <q-card flat bordered>
        <q-tabs
          v-model="tab"
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab no-caps name="uraian" label="Uraian" />
          <q-tab no-caps name="dokumen" label="Dokumen Penunjang" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab">
          <q-tab-panel class="q-pa-none" name="uraian">
            <pencairan-dana-item-table
              :rows="detailPengajuanDana"
              :data="{
                pencairanDana: pencairanDana,
                pengajuanDana: pengajuanDana,
                detailPencairanDana: detailPencairanDana
              }"
            />
          </q-tab-panel>

          <q-tab-panel class="q-pa-none" name="dokumen">
            <files-table
              :rows="dokumenPenunjang"
              :data="{
                model_id: pencairanDana.id_pencairan_dana,
                permissions: 'create & modify pencairan dana',
                status_aktivitas: pencairanDana.status_aktivitas
              }"
            />
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>

    <pencairan-dana-submission-form
      v-if="can('create & modify pencairan dana') && isEditable(pencairanDana) && detailPencairanDana.length"
      :data="{
        id_pencairan_dana: pencairanDana.id_pencairan_dana,
      }"
    />

    <pencairan-dana-approval-form
      v-if="can('confirm pencairan dana') && isSubmitted(pencairanDana)"
      :data="{
        id_pencairan_dana: pencairanDana.id_pencairan_dana,
      }"
    />

  </layout>
</template>
