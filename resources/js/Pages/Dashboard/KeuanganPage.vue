<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { DashboardOverview } from '@/Components/Dashboard/dashboard-page'
import {
  SisaDanaRekeningTable,
  ProyeksiInvoiceProyekTable,
  ProyeksiKebutuhanDanaProyekTable,
  ProyeksiPiutangTable,
  ProyeksiUtangTable,
  ProyeksiSetoranModalTable,
  ProyeksiPenarikanTable
} from '@/Components/Dashboard/Keuangan/dashboard-keuangan-page'

// types
import type { OverviewProps } from '@/Components/Dashboard/DashboardOverview.vue'
import type { User } from '@/types'

const breadcrumbs = [
  { label: 'Dashboard', url: '#' },
  { label: 'Overview', url: '#' }
]

export interface SisaDanaRekening {
  id_rekening: string
  nama_bank: string
  nama_rekening: string
  nomor_rekening: string
  nilai_kontrak: string
  total_pengajuan_dana: string
  total_pencairan_dana: string
  total_penagihan: string
  total_penagihan_diterima: string
}

export interface ProyeksiInvoiceProyek {
  id_proyek: string
  nama_proyek: string
  invoice_sebelumnya: string
  invoice_saat_ini: string
  sisa_netto_kontrak: string
}

export interface ProyeksiKebutuhanDanaProyek {
  id_proyek: string
  nama_proyek: string
  total_pengajuan: string
  jumlah_belum_dibayar: string
}

export interface ProyeksiUtang {
  id_pencairan_dana: string
  nama_proyek: string
  keperluan: string
  jumlah_utang: string
}

export interface ProyeksiPiutang {
  id_pencairan_dana: string | undefined
  id_penagihan: string | undefined
  id_user: number
  nama_proyek: string
  pengguna_jasa: string
  keperluan: string
  jumlah_piutang: string
}

export interface ProyeksiSetoranModal {
  id_pencairan_dana: string
  nama_proyek: string
  keperluan: string
  jumlah_setoran_modal: string
}

export interface ProyeksiPenarikan {
  id_pencairan_dana: string
  nama_proyek: string
  keperluan: string
  jumlah_penarikan: string
}

export interface Options {
  pic: User[]
  penggunaJasa: string[]
}

defineProps<{
  sisaDanaRekening: SisaDanaRekening[]
  proyeksiInvoiceProyek: ProyeksiInvoiceProyek[]
  proyeksiKebutuhanDanaProyek: ProyeksiKebutuhanDanaProyek[]
  proyeksiUtang: ProyeksiUtang[]
  proyeksiPiutang: ProyeksiPiutang[]
  proyeksiSetoranModal: ProyeksiSetoranModal[]
  proyeksiPenarikan: ProyeksiPenarikan[]
  options: Options
  overview: OverviewProps[]
}>()
</script>

<template>
  <Head title="Dashboard" />
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

    <dashboard-overview
      :overview="overview"
    />

    <div class="q-pa-md">
      <div class="row q-col-gutter-md">
        <div class="col-12 col-md-6">
          <sisa-dana-rekening-table
            :rows="sisaDanaRekening"
          />
        </div>

        <div class="col-12 col-md-6">
          <proyeksi-kebutuhan-dana-proyek-table
            :rows="proyeksiKebutuhanDanaProyek"
          />
        </div>

        <div class="col-12">
          <proyeksi-invoice-proyek-table
            :rows="proyeksiInvoiceProyek"
          />
        </div>

        <div class="col-12 col-md-6">
          <proyeksi-utang-table
            :rows="proyeksiUtang"
            :options="options"
          />
        </div>

        <div class="col-12 col-md-6">
          <proyeksi-piutang-table
            :rows="proyeksiPiutang"
            :options="options"
          />
        </div>

        <div class="col-12 col-md-6">
          <proyeksi-setoran-modal-table
            :rows="proyeksiSetoranModal"
            :options="options"
          />
        </div>

        <div class="col-12 col-md-6">
          <proyeksi-penarikan-table
            :rows="proyeksiPenarikan"
            :options="options"
          />
        </div>
      </div>
    </div>
  </layout>
</template>
