<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { QTable } from 'quasar'

// utils
import { toFloat } from '@/utils/number'
import { toRupiah } from '@/utils/money'

// types
import type { QTableColumn } from 'quasar'
import type { ProyeksiInvoiceProyek } from '@/Pages/Dashboard/DirekturUtamaPage.vue'

defineProps<{
  rows: ProyeksiInvoiceProyek[]
}>()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'invoice_sebelumnya', label: 'Invoice Sebelumnya', field: 'invoice_sebelumnya', align: 'right', sortable: true },
  { name: 'invoice_saat_ini', label: 'Invoice Saat Ini', field: 'invoice_saat_ini', align: 'right', sortable: true },
  { name: 'sisa_netto_kontrak', label: 'Sisa Netto Kontrak', field: 'sisa_netto_kontrak', align: 'right', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const table = ref<QTable>()

const totaAmount = computed(() => {
  const invoiceSebelumnya = table.value?.computedRows.reduce((total, item) => {
    return (total as number) + toFloat((item.invoice_sebelumnya as string))
  }, 0)

  const invoiceSaatIni = table.value?.computedRows.reduce((total, item) => {
    return (total as number) + toFloat((item.invoice_saat_ini as string))
  }, 0)

  const sisaNettoKontrak = table.value?.computedRows.reduce((total, item) => {
    return (total as number) + toFloat((item.sisa_netto_kontrak as string))
  }, 0)

  return {
    invoiceSebelumnya,
    invoiceSaatIni,
    sisaNettoKontrak
  }
})
</script>

<template>
  <q-table
    ref="table"
    flat
    bordered
    title="Proyeksi Invoice Proyek"
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

        <q-td key="invoice_sebelumnya" :props="props">
          {{ toRupiah(toFloat(props.row.invoice_sebelumnya)) }}
        </q-td>

        <q-td key="invoice_saat_ini" :props="props">
          {{ toRupiah(toFloat(props.row.invoice_saat_ini)) }}
        </q-td>

        <q-td key="sisa_netto_kontrak" :props="props">
          {{ toRupiah(toFloat(props.row.sisa_netto_kontrak)) }}
        </q-td>
      </q-tr>
    </template>

    <template v-slot:bottom-row>
      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="4">Total Invoice Sebelumnya</q-td>
        <q-td>
          {{ toRupiah(totaAmount.invoiceSebelumnya) }}
        </q-td>
      </q-tr>

      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="4">Total Invoice Saat Ini</q-td>
        <q-td>
          {{ toRupiah(totaAmount.invoiceSaatIni) }}
        </q-td>
      </q-tr>

      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="4">Total Sisa Netto Kontrak</q-td>
        <q-td>
          {{ toRupiah(totaAmount.sisaNettoKontrak) }}
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
