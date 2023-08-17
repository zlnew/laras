<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { QTable } from 'quasar'

// utils
import { toFloat } from '@/utils/number'
import { toRupiah } from '@/utils/money'

// types
import type { QTableColumn } from 'quasar'
import type { ProyeksiKebutuhanDanaProyek } from '@/Pages/Dashboard/KeuanganPage.vue'

defineProps<{
  rows: ProyeksiKebutuhanDanaProyek[]
}>()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'total_pengajuan', label: 'Total Pengajuan', field: 'total_pengajuan', align: 'left', sortable: true },
  { name: 'jumlah_belum_dibayar', label: 'Jumlah Belum Dibayar', field: 'jumlah_belum_dibayar', align: 'right', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const table = ref<QTable>()

const totaAmount = computed(() => {
  const jumlahBelumDibayar = table.value?.computedRows.reduce((total, item) => {
    return (total as number) + toFloat((item.jumlah_belum_dibayar as string))
  }, 0)

  return {
    jumlahBelumDibayar
  }
})
</script>

<template>
  <q-table
    ref="table"
    flat
    bordered
    title="Proyeksi Kebutuhan Dana Proyek"
    :fullscreen="tableFullscreen"
    :rows="rows"
    :columns="columns"
    row-key="id_proyek"
    class="table"
  >
    <template v-slot:top-right>
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
      <q-tr :props="props">
        <q-td key="index" :props="props">
          {{ ++props.rowIndex }}
        </q-td>

        <q-td key="proyek" :props="props">
          {{ props.row.nama_proyek }}
        </q-td>

        <q-td key="total_pengajuan" :props="props">
          {{ props.row.total_pengajuan }} Pengajuan
        </q-td>

        <q-td key="jumlah_belum_dibayar" :props="props">
          {{ toRupiah(toFloat(props.row.jumlah_belum_dibayar)) }}
        </q-td>
      </q-tr>
    </template>

    <template v-slot:bottom-row>
      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="3">Total Belum Dibayar</q-td>
        <q-td>
          {{ toRupiah(totaAmount.jumlahBelumDibayar) }}
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
