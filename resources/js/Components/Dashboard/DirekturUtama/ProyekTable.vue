<script setup lang="ts">
// cores
import { router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

// utils
import { toFloat } from '@/utils/number'
import { toRupiah } from '@/utils/money'
import { filterOptions } from '@/utils/options'

// types
import type { QTableColumn } from 'quasar'
import type { Proyek } from '@/types'
import type { JoinedWithProyek, Options } from '@/Pages/Dashboard/DirekturUtamaPage.vue'

const props = defineProps<{
  rows: Proyek[] & JoinedWithProyek[]
  options: Options
}>()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'penyedia_jasa', label: 'Penyedia Jasa', field: 'penyedia_jasa', align: 'left', sortable: true },
  { name: 'nilai_kontrak', label: 'Nilai Kontrak', field: 'nilai_kontrak', align: 'right', sortable: true },
  { name: 'rap', label: 'RAP', field: 'rap', align: 'right', sortable: true },
  { name: 'pengajuan_sebelumnya', label: 'Pengajuan Sebelumnya', field: 'pengajuan_sebelumnya', align: 'right', sortable: true },
  { name: 'pengajuan_dalam_proses', label: 'Pengajuan Dalam Proses', field: 'pengajuan_dalam_proses', align: 'right', sortable: true },
  { name: 'total_pengajuan', label: 'Total Pengajuan', field: 'total_pengajuan', align: 'right', sortable: true },
  { name: 'sisa_anggaran', label: 'Sisa Anggaran', field: 'sisa_anggaran', align: 'right', sortable: true },
  { name: 'estimasi_laba', label: 'Estimasi Laba', field: 'estimasi_laba', align: 'right', sortable: true }
]

const tahunAnggaranOptionsRef = ref(props.options.tahunAnggaran)

function tahunAnggaranFilter (val: string, update: any) {
  update(() => {
    tahunAnggaranOptionsRef.value = filterOptions(val, props.options.tahunAnggaran)
  })
}

const page = usePage()
const params = page.props.query as { tahun_anggaran: string }

const tahunAnggaran = ref(params.tahun_anggaran)

function filter (tahunAnggaran: string) {
  router.get(route('dashboard.direktur_utama', {
    proyek_query: 'true',
    proyek_tahun_anggaran: tahunAnggaran
  }), undefined, {
    preserveScroll: true,
    preserveState: true
  })
}
</script>

<template>
  <q-table
    flat
    bordered
    title="Proyek Aktif"
    :rows="rows"
    :columns="columns"
    row-key="id_proyek"
  >
    <template v-slot:top-right>
      <div class="row items-center q-col-gutter-sm">
        <div class="text-caption">Filter by</div>
        <q-select
          dense
          filled
          use-input
          input-debounce="500"
          label="Tahun Anggaran"
          v-model="tahunAnggaran"
          :options="tahunAnggaranOptionsRef"
          @filter="tahunAnggaranFilter"
          @update:model-value="filter"
        >
          <template v-slot:no-option>
            <q-item>
              <q-item-section class="text-grey">
                No results
              </q-item-section>
            </q-item>
          </template>
        </q-select>
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

        <q-td key="proyek" :props="props">
          {{ props.row.nama_proyek }}
        </q-td>

        <q-td key="penyedia_jasa" :props="props">
          {{ props.row.penyedia_jasa }}
        </q-td>

        <q-td key="nilai_kontrak" :props="props">
          {{ toRupiah(toFloat(props.row.nilai_kontrak)) }}
        </q-td>

        <q-td key="rap" :props="props">
          {{ toRupiah(toFloat(props.row.rap)) }}
        </q-td>

        <q-td key="pengajuan_sebelumnya" :props="props">
          {{ toRupiah(toFloat(props.row.pengajuan_sebelumnya)) }}
        </q-td>

        <q-td key="pengajuan_dalam_proses" :props="props">
          {{ toRupiah(toFloat(props.row.pengajuan_dalam_proses)) }}
        </q-td>

        <q-td key="total_pengajuan" :props="props">
          {{ toRupiah(toFloat(props.row.total_pengajuan)) }}
        </q-td>

        <q-td key="sisa_anggaran" :props="props">
          {{ toRupiah(toFloat(props.row.sisa_anggaran)) }}
        </q-td>

        <q-td key="estimasi_laba" :props="props">
          {{ toRupiah(toFloat(props.row.estimasi_laba)) }}
          ({{ toFloat(props.row.persentase_laba).toFixed(2) }} %)
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>
