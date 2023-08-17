<script setup lang="ts">
// utils
import { toFloat } from '@/utils/number'
import { toRupiah } from '@/utils/money'

// types
import type { Proyek } from '@/types'
import type { JoinedWithProyek } from '@/Pages/Dashboard/KepalaDivisiPage.vue'
import type { QTableColumn } from 'quasar'

defineProps<{
  rows: Proyek[] & JoinedWithProyek[]
}>()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'nilai_kontrak', label: 'Nilai Kontrak', field: 'nilai_kontrak', align: 'right', sortable: true },
  { name: 'termin_sebelumnya', label: 'Termin Sebelumnya', field: 'termin_sebelumnya', align: 'right', sortable: true },
  { name: 'termin_dalam_proses', label: 'Termin Dalam Proses', field: 'termin_dalam_proses', align: 'right', sortable: true },
  { name: 'total_pencairan', label: 'Total Pencairan', field: 'total_pencairan', align: 'right', sortable: true },
  { name: 'sisa_penagihan', label: 'Sisa Penagihan', field: 'sisa_penagihan', align: 'right', sortable: true }
]
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      title="Proyek"
      :rows="rows"
      :columns="columns"
      row-key="id_proyek"
    >
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

          <q-td key="nilai_kontrak" :props="props">
            {{ toRupiah(toFloat(props.row.nilai_kontrak)) }}
          </q-td>

          <q-td key="termin_sebelumnya" :props="props">
            {{ toRupiah(toFloat(props.row.termin_sebelumnya)) }}
          </q-td>

          <q-td key="termin_dalam_proses" :props="props">
            {{ toRupiah(toFloat(props.row.termin_dalam_proses)) }}
          </q-td>

          <q-td key="total_pencairan" :props="props">
            {{ toRupiah(toFloat(props.row.total_pencairan)) }}
          </q-td>

          <q-td key="sisa_penagihan" :props="props">
            {{ toRupiah(toFloat(props.row.sisa_penagihan)) }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
