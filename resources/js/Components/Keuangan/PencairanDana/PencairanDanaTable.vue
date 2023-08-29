<script setup lang="ts">
// cores
import { router, Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { QTable, type QTableColumn, useQuasar } from 'quasar'

// utils
import { isRejected } from '@/utils/permissions'

// types
import { type PencairanDana, type Proyek } from '@/types'
import { type FormOptions } from '@/Pages/Keuangan/PencairanDanaPage.vue'

// comps
import {
  PencairanDanaSearchDialog
} from '@/Components/Keuangan/pencairan-dana-page'
import { ProyekDetailDialog } from '@/Components/Main/proyek-page'

const props = defineProps<{
  rows: PencairanDana[]
  formOptions: FormOptions
}>()

const rows = computed(() => {
  return props.rows.map(row => {
    const status = row.status_pencairan === '400' ? 'Closed' : 'Open'

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

function searchPencairanDana () {
  $q.dialog({
    component: PencairanDanaSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  })
}

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  {
    name: 'nama_proyek',
    label: 'Nama Proyek',
    field: 'nama_proyek',
    align: 'left',
    sortable: true
  },
  { name: 'tahun_anggaran', label: 'Tahun Anggaran', field: 'tahun_anggaran', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'jenis_transaksi', label: 'Jenis Transaksi', field: 'jenis_transaksi', align: 'left', sortable: true },
  { name: 'status', label: 'Status', field: 'status', align: 'left', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}
</script>

<template>
  <div class="q-pa-md">
    <q-table
      ref="table"
      flat
      bordered
      row-key="id_rap"
      title="List Pencairan Dana"
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
            @click="router.visit(route('pencairan_dana'))"
          />

          <q-btn
            flat
            no-caps
            label="Pencarian"
            icon="search"
            color="primary"
            @click="searchPencairanDana"
          />

          <q-btn
            flat dense
            :icon="tableFullscreen ? 'fullscreen_exit' : 'fullscreen'"
            @click="toggleFullscreen"
          >
            <q-tooltip>Fullscreen Mode</q-tooltip>
          </q-btn>
        </div>
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            style="font-weight: bold;"
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

          <q-td
            key="tahun_anggaran"
            :props="props"
            @click.prevent="router.visit(route('detail_pencairan_dana', props.row.id_pencairan_dana))"
            style="cursor: pointer;"
          >
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td
            key="keperluan"
            :props="props"
            @click.prevent="router.visit(route('detail_pencairan_dana', props.row.id_pencairan_dana))"
            style="cursor: pointer;"
          >
            {{ props.row.keperluan }}
          </q-td>

          <q-td
            key="jenis_transaksi"
            :props="props"
            @click.prevent="router.visit(route('detail_pencairan_dana', props.row.id_pencairan_dana))"
            style="cursor: pointer;"
          >
            {{ props.row.jenis_transaksi }}
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

            <Link :href="route('detail_pencairan_dana', props.row.id_pencairan_dana)">
              <q-badge
                :color="props.row.status_pencairan == 400 ? 'red' : 'primary'"
                :label="props.row.status_pencairan == 400 ? 'Closed' : 'Open'"
              />
            </Link>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
