<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { type QTableColumn, useQuasar } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { can, isAdmin, isEditable } from '@/utils/permissions'
import { toFloat } from '@/utils/number'

// types
import { type DetailPencairanDana, type DetailPengajuanDana, type PencairanDana, type PengajuanDana } from '@/types'
import { type JoinedWithDetailPengajuanDana } from '@/Pages/Keuangan/DetailPencairanDanaPage.vue'

// comps
import { router } from '@inertiajs/vue3'

interface Data {
  pencairanDana: PencairanDana
  pengajuanDana: PengajuanDana
  detailPencairanDana: DetailPencairanDana[]
}

const props = defineProps<{
  rows: Array<DetailPengajuanDana & JoinedWithDetailPengajuanDana>
  data: Data
}>()

const rows = computed(() => {
  return props.rows.map(pg => {
    pg.pembayaran_lalu = '0'
    pg.pembayaran_saat_ini = '0'

    // eslint-disable-next-line @typescript-eslint/strict-boolean-expressions
    if (props.data.detailPencairanDana) {
      // eslint-disable-next-line array-callback-return
      props.data.detailPencairanDana.map(pc => {
        // eslint-disable-next-line eqeqeq
        const itemMatched = pc.id_detail_pengajuan_dana == pg.id_detail_pengajuan_dana

        if (itemMatched) {
          if (pc.status_pembayaran === '100') {
            pg.pembayaran_saat_ini = (toFloat(pg.pembayaran_saat_ini) + toFloat(pc.jumlah_pencairan)).toString()
          }

          if (pc.status_pembayaran === '400') {
            pg.pembayaran_lalu = (toFloat(pg.pembayaran_lalu) + toFloat(pc.jumlah_pencairan)).toString()
          }
        }
      })
    }

    // eslint-disable-next-line @typescript-eslint/naming-convention
    const total_pembayaran = toFloat(pg.pembayaran_lalu) + toFloat(pg.pembayaran_saat_ini)
    // eslint-disable-next-line @typescript-eslint/naming-convention
    const belum_dibayarkan = toFloat(pg.jumlah_pengajuan) - total_pembayaran

    return {
      ...pg,
      belum_dibayarkan
    }
  })
})

const totalAmount = computed(() => {
  const pengajuan = props.rows.reduce((total, item) => {
    return (total as number) + toFloat(item.jumlah_pengajuan)
  }, 0)

  const pembayaranLalu = rows.value.reduce((total, item) => {
    return (total as number) + toFloat(item.pembayaran_lalu)
  }, 0)

  const pembayaranSaatIni = rows.value.reduce((total, item) => {
    return (total as number) + toFloat(item.pembayaran_saat_ini)
  }, 0)

  const belumDibayarkan = rows.value.reduce((total, item) => {
    return (total as number) + (item.belum_dibayarkan as number)
  }, 0)

  return {
    pengajuan,
    pembayaranLalu,
    pembayaranSaatIni,
    belumDibayarkan
  }
})

const $q = useQuasar()

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  {
    name: 'uraian',
    label: 'Uraian',
    field: 'uraian',
    align: 'left',
    sortable: true
  },
  { name: 'pos', label: 'POS', field: 'pos', align: 'left', sortable: true },
  { name: 'jenis_pembayaran', label: 'Jenis Pembayaran', field: 'jenis_pembayaran', align: 'left', sortable: true },
  { name: 'bank', label: 'Bank', field: 'nama_bank', align: 'left', sortable: true },
  { name: 'rekening', label: 'Rekening', field: 'nomor_rekening', align: 'left', sortable: true },
  { name: 'jumlah', label: 'Jumlah Pengajuan', field: 'jumlah_pengajuan', align: 'right', sortable: true },
  { name: 'pembayaran_lalu', label: 'Pembayaran Lalu', field: '', align: 'right', sortable: true },
  { name: 'pembayaran_saat_ini', label: 'Pembayaran Saat Ini', field: '', align: 'right', sortable: true },
  { name: 'belum_dibayarkan', label: 'Belum Dibayarkan', field: '', align: 'right', sortable: true }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const filter = ref('')

function save (amount: string, id: number) {
  const data = {
    id_detail_pengajuan_dana: id,
    jumlah_pencairan: toFloat(amount)
  }

  router.post(route('detail_pencairan_dana.store', props.data.pencairanDana.id_pencairan_dana), data, {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}
</script>

<template>
  <q-table
    flat
    bordered
    row-key="id_detail_pengajuan_dana"
    title="Pencairan Dana"
    :rows="rows"
    :columns="columns"
    :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
    :fullscreen="tableFullscreen"
    :filter="filter"
    class="no-border"
  >
    <template v-slot:top-right>
      <q-input
        dense
        debounce="300"
        v-model="filter"
        placeholder="Search"
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>

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

        <q-td key="uraian" :props="props">
          {{ props.row.uraian }}
        </q-td>

        <q-td key="pos" :props="props">
          {{ props.row.pos }}
        </q-td>

        <q-td key="jenis_pembayaran" :props="props">
          {{ props.row.jenis_pembayaran }}
        </q-td>

        <q-td key="bank" :props="props">
          {{ props.row.nama_bank }}
        </q-td>

        <q-td key="rekening" :props="props">
          {{ props.row.nomor_rekening }} - {{ props.row.nama_rekening }}
        </q-td>

        <q-td key="jumlah" :props="props">
          {{ toRupiah(props.row.jumlah_pengajuan) }}
        </q-td>

        <q-td key="pembayaran_lalu" :props="props">
          {{ toRupiah(props.row.pembayaran_lalu) }}
        </q-td>

        <q-td key="pembayaran_saat_ini" :props="props">
          <div
            v-if="isAdmin() ? true : can('create & modify pencairan dana') && isEditable(data.pencairanDana)"
            class="text-primary"
            style="cursor: pointer;"
          >
            {{ toRupiah(props.row.pembayaran_saat_ini) }}

            <q-tooltip>Click to edit</q-tooltip>

            <q-popup-edit
              v-model.number="props.row.pembayaran_saat_ini"
              title="Pembayaran Saat Ini"
              v-slot="scope"
            >
              <q-input
                dense
                autofocus
                v-model="scope.value"
                :hint="toRupiah(scope.value)"
              >
                <template v-slot:after>
                  <q-btn
                    flat dense color="negative" icon="cancel"
                    @click.stop.prevent="scope.cancel"
                  />
                  <q-btn
                    flat dense color="positive" icon="check_circle"
                    :disable="scope.validate(scope.value) === false || scope.initialValue === scope.value"
                    @click.stop.prevent="save(scope.value, props.row.id_detail_pengajuan_dana)"
                    @click="scope.set"
                  />
                </template>
              </q-input>
            </q-popup-edit>
          </div>

          <div v-else>{{ toRupiah(props.row.pembayaran_saat_ini) }}</div>
        </q-td>

        <q-td key="belum_dibayarkan" :props="props">
          {{ toRupiah(props.row.belum_dibayarkan) }}
        </q-td>
      </q-tr>
    </template>

    <template v-if="rows.length" v-slot:bottom-row>
      <q-tr no-hover>
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Pengajuan
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.pengajuan) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr no-hover>
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Pembayaran Lalu
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.pembayaranLalu) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr no-hover>
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Pembayaran Saat Ini
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.pembayaranSaatIni) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr no-hover>
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Belum Dibayarkan
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.belumDibayarkan) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>
    </template>
  </q-table>
</template>
