<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3'
import { computed, ref, onMounted } from 'vue'
import { useQuasar, QTable } from 'quasar'

// utils
import { toFloat } from '@/utils/number'
import { toRupiah } from '@/utils/money'

// comps
import PiutangFilterDialog from '@/Components/Dialogs/PiutangFilterDialog.vue'

// types
import type { QTableColumn } from 'quasar'
import type { Options, ProyeksiPiutang } from '@/Pages/Dashboard/DirekturUtamaPage.vue'
import { createBody, tableToPdf } from '@/utils/pdf'
import { excelParser } from '@/utils/excel'

const props = defineProps<{
  rows: ProyeksiPiutang[]
  options: Options
}>()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'nama_proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'jumlah_piutang', label: 'Jumlah Piutang', field: 'jumlah_piutang', align: 'right', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const table = ref<QTable>()
const pdfTable = ref()
const excelTable = ref()

const totaAmount = computed(() => {
  const piutang = table.value?.computedRows.reduce((total, item) => {
    return (total as number) + toFloat((item.jumlah_piutang as string))
  }, 0)

  return {
    piutang
  }
})

const $q = useQuasar()

function search () {
  $q.dialog({
    component: PiutangFilterDialog,
    componentProps: {
      options: props.options,
      data: {
        route: route('dashboard.direktur_utama')
      }
    }
  })
}

onMounted(() => {
  pdfTable.value = {
    columns: table.value?.columns,
    body: {
      rows: table.value?.computedRows,
      props: ['index', 'nama_proyek', 'keperluan', 'jumlah_piutang']
    }
  }

  excelTable.value = createBody({
    rows: (table.value?.computedRows as any[]),
    props: ['nama_proyek', 'keperluan', 'jumlah_piutang']
  })
})
</script>

<template>
  <q-table
    ref="table"
    flat
    bordered
    title="Proyeksi Piutang"
    :fullscreen="tableFullscreen"
    :rows="rows"
    :columns="columns"
    class="table"
  >
    <template v-slot:top-right>
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
          name:'proyeksi-piutang',
          type: 'xls'
        })"
      >
        <q-tooltip>Export to xls</q-tooltip>
      </q-btn>

      <q-btn
        flat dense
        label="pdf"
        color="red-8"
        @click="tableToPdf({
          filename: 'proyeksi_piutang',
          header: 'Proyeksi Piutang',
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
      <q-tr
        :props="props"
        @click="router.visit(
          props.row.id_penagihan
            ? route('detail_penagihan', props.row.id_penagihan)
            : route('detail_pencairan_dana', props.row.id_pencairan_dana)
        )"
        style="cursor: pointer"
      >
        <q-td key="index" :props="props">
          {{ ++props.rowIndex }}
        </q-td>

        <q-td key="nama_proyek" :props="props">
          {{ props.row.nama_proyek }}
        </q-td>

        <q-td key="keperluan" :props="props">
          {{ props.row.keperluan }}
        </q-td>

        <q-td key="jumlah_piutang" :props="props">
          {{ toRupiah(toFloat(props.row.jumlah_piutang)) }}
        </q-td>

        <q-tooltip>Lihat Detail</q-tooltip>
      </q-tr>
    </template>

    <template v-slot:bottom-row>
      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="3">Total</q-td>
        <q-td>
          {{ toRupiah(totaAmount.piutang) }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<style lang="sass">
.table

  td:last-child
    background-color: #fff

  tr th
    position: sticky
    z-index: 2
    background: #fff

  thead tr:last-child th
    top: 48px
    z-index: 3

  thead tr:first-child th
    top: 0
    z-index: 1

  tr:last-child th:last-child
    z-index: 3

  td:last-child
    z-index: 1

  td:last-child, th:last-child
    position: sticky
    right: 0

  tbody
    scroll-margin-top: 48px
</style>
