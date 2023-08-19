<script setup lang="ts">
// cores
import { router, Link } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { QTable, useQuasar } from 'quasar'

// utils
import { isRejected } from '@/utils/permissions'
import { toRupiah } from '@/utils/money'
import { toFloat } from '@/utils/number'
import { createBody, tableToPdf } from '@/utils/pdf'
import { excelParser } from '@/utils/excel'

// types
import type { Penagihan, Proyek } from '@/types'
import type { QTableColumn } from 'quasar'
import type { FormOptions } from '@/Pages/Laporan/LaporanPenagihanPage.vue'

// comps
import { LaporanPenagihanSearchDialog } from '@/Components/Laporan/laporan-page'
import { ProyekDetailDialog } from '@/Components/Main/proyek-page'

const props = defineProps<{
  rows: Array<Penagihan & {
    jumlah_penagihan: string
    sisa_penagihan: string
  }>
  formOptions: FormOptions
}>()

const rows = computed(() => {
  return props.rows.map(row => {
    const status = row.status_penagihan === '400' ? 'Closed' : 'Open'

    return {
      ...row,
      status
    }
  })
})

const $q = useQuasar()

function detailProyek (data: Proyek) {
  $q.dialog({
    component: ProyekDetailDialog,
    componentProps: {
      proyek: data
    }
  })
}

function search () {
  $q.dialog({
    component: LaporanPenagihanSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  })
}

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'nama_proyek', label: 'Nama Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'tahun_anggaran', label: 'Tahun Anggaran', field: 'tahun_anggaran', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'jumlah_penagihan', label: 'Jumlah Penagihan', field: 'jumlah_penagihan', align: 'right', sortable: true },
  { name: 'jumlah_diterima', label: 'Jumlah Diterima', field: 'jumlah_diterima', align: 'right', sortable: true },
  { name: 'sisa_penagihan', label: 'Sisa Penagihan', field: 'sisa_penagihan', align: 'right', sortable: true },
  { name: 'status', label: 'Status', field: 'status_pencairan', align: 'left', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const table = ref<QTable>()
const pdfTable = ref()
const excelTable = ref()

onMounted(() => {
  pdfTable.value = {
    columns: table.value?.columns,
    body: {
      rows: table.value?.computedRows,
      props: ['index', 'nama_proyek', 'tahun_anggaran', 'keperluan', 'kas_masuk', 'jumlah_penagihan', 'jumlah_diterima', 'sisa_penagihan', 'status']
    }
  }

  excelTable.value = createBody({
    rows: (table.value?.computedRows as any[]),
    props: ['nama_proyek', 'tahun_anggaran', 'keperluan', 'kas_masuk', 'jumlah_penagihan', 'jumlah_diterima', 'sisa_penagihan', 'status']
  })
})
</script>

<template>
  <div class="q-pa-md">
    <q-table
      ref="table"
      flat
      bordered
      row-key="id_rab"
      title="Laporan Penagihan/Invoice"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-right>
        <div class="q-gutter-sm">
          <q-btn
            v-if="Object.keys($page.props.query).length"
            flat
            no-caps
            label="Clear Filter"
            icon="clear"
            color="secondary"
            @click="router.visit(route('laporan.penagihan'))"
          />

          <q-btn
            flat
            no-caps
            label="Pencarian"
            icon="search"
            color="primary"
            @click="search"
          />

          <q-btn
              flat dense
              label="xls"
              color="green"
              @click="excelParser().exportDataFromJSON({
                data: excelTable,
                name:'penagihan', type: 'xls'
              })"
            >
              <q-tooltip>Export to xls</q-tooltip>
          </q-btn>

          <q-btn
            flat dense
            label="pdf"
            color="red-8"
            @click="tableToPdf({
              filename: 'penagihan',
              header: 'Penagihan',
              columns: pdfTable.columns,
              body: pdfTable.body
            })"
          >
            <q-tooltip>Export to pdf</q-tooltip>
          </q-btn>

          <q-btn
            flat dense
            :icon="tableFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="toggleFullscreen"
            class="q-ml-md"
          />
        </div>
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            style="font-weight: bold"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="index" :props="props">
            {{ ++props.rowIndex }}
          </q-td>

          <q-td key="nama_proyek" :props="props">
            <q-btn
              flat
              no-caps
              dense
              color="primary"
              :ripple="false"
              :label="props.row.nama_proyek"
              @click="detailProyek(props.row)"
            >
              <q-tooltip anchor="bottom middle" self="top middle">
                Lihat Detail
              </q-tooltip>
          </q-btn>
          </q-td>

          <q-td key="tahun_anggaran" :props="props">
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td key="keperluan" :props="props">
            {{ props.row.keperluan }}
          </q-td>

          <q-td key="jumlah_penagihan" :props="props">
            {{ toRupiah(toFloat(props.row.jumlah_penagihan)) }}
          </q-td>

          <q-td key="jumlah_diterima" :props="props">
            {{ toRupiah(toFloat(props.row.jumlah_diterima)) }}
          </q-td>

          <q-td key="sisa_penagihan" :props="props">
            {{ toRupiah(toFloat(props.row.sisa_penagihan)) }}
          </q-td>

          <q-td key="status" :props="props">
            <q-btn
              v-if="isRejected(props.row.status_aktivitas)"
              flat
              dense
              round
              color="grey-6"
              icon="warning"
              size="sm"
            >
              <q-tooltip>Ditolak</q-tooltip>
            </q-btn>

            <Link :href="route('detail_penagihan', props.row.id_penagihan)">
              <q-badge
                :color="props.row.status_penagihan == 400 ? 'red' : 'primary'"
                :label="props.row.status_penagihan == 400 ? 'Closed' : 'Open'"
              />
            </Link>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
