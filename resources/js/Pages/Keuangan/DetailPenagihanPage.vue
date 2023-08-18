<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// utils
import { can, isEditable, isSubmitted } from '@/utils/permissions'
import { fullDate } from '@/utils/date'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import {
  PenagihanItemTable,
  PenagihanSubmissionForm,
  PenagihanApprovalForm
} from '@/Components/Keuangan/detail-penagihan-page'
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue'

// types
import type { DetailPenagihan, DetailRAB, Penagihan, Proyek, Timeline } from '@/types'
import { toRupiah } from '@/utils/money'
import { toFloat } from '@/utils/number'

export interface FormOptions {
  detailRab: DetailRAB[]
}

interface JoinedWithPenagihan {
  id_rekening_pg: string
  nama_bank_pg: string
  nomor_rekening_pg: string
  nama_rekening_pg: string
}

export interface Evaluasi {
  id_proyek: string
  nama_proyek: string
  nilai_kontrak: string
  invoice_sebelumnya: string
  invoice_saat_ini: string
  sisa_netto_kontrak: string
}

const props = defineProps<{
  penagihan: Penagihan & Proyek & JoinedWithPenagihan
  detailPenagihan: DetailPenagihan[]
  evaluasi: Evaluasi[]
  formOptions: FormOptions
  timeline: Timeline[]
}>()

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Penagihan/Invoice', url: route('penagihan') },
  { label: props.penagihan.nama_proyek, url: '#' }
]
</script>

<template>
  <Head title="Penagihan" />
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
      title="Penagihan"
      timeline-title="Timeline Penagihan"
      :data="{
        proyek: penagihan,
        status: penagihan.status_penagihan,
        timeline: timeline
      }"
    />

    <div class="q-px-md q-pt-md">
      <div class="row q-col-gutter-md">
        <div class="col-12 col-md-6">
          <q-card flat bordered>
            <q-card-section>
              <div class="row">
                <div class="col-4 text-caption">
                  Keperluan
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ penagihan.keperluan }}
                </div>

                <div class="col-4 text-caption">
                  Tanggal Pengajuan
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ fullDate(penagihan.tanggal_pengajuan) || '-' }}
                </div>

                <div class="col-4 text-caption">
                  Nomor Rekening Tujuan
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ penagihan.nama_bank_pg }} | {{ penagihan.nomor_rekening_pg }} - {{ penagihan.nama_rekening_pg }}
                </div>

                <div class="col-4 text-caption">
                  Nomor SP2D
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ penagihan.nomor_sp2d || '-' }}
                </div>

                <div class="col-4 text-caption">
                  Tanggal SP2D
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ fullDate(penagihan.tanggal_sp2d) || '-' }}
                </div>

                <div class="col-4 text-caption">
                  Tanggal Terbit
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ fullDate(penagihan.tanggal_terbit) || '-' }}
                </div>

                <div class="col-4 text-caption">
                  Tanggal Cair
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ fullDate(penagihan.tanggal_cair) || '-' }}
                </div>

                <div class="col-4 text-caption">
                  Nilai Netto
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ toRupiah(toFloat(penagihan.nilai_netto)) }}
                </div>

                <div class="col-4 text-caption">
                  Faktur
                </div>
                <div class="col-8 text-subtitle2">
                  :
                  <q-btn
                    v-if="penagihan.faktur"
                    flat
                    dense
                    no-caps
                    label="Lihat Faktur"
                    color="primary"
                    :href="penagihan.faktur"
                    target="_blank"
                  />
                  <span v-else>-</span>
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>

    <penagihan-item-table
      :rows="detailPenagihan"
      :data="{
        penagihan: penagihan,
      }"
      :form-options="formOptions"
    />

    <penagihan-submission-form
      v-if="can('create & modify penagihan') && isEditable(penagihan) && detailPenagihan.length"
      :data="{
        id_penagihan: penagihan.id_penagihan,
      }"
    />

    <penagihan-approval-form
      v-if="can('confirm penagihan') && isSubmitted(penagihan)"
      :data="{
        id_penagihan: penagihan.id_penagihan,
        jumlah_diterima: penagihan.jumlah_diterima
      }"
    />

  </layout>
</template>
