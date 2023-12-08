<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { type QTableColumn, useQuasar } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { can, isAdmin, isEditable, isSubmitted } from '@/utils/permissions'
import { toFloat } from '@/utils/number'

// types
import { type DetailPengajuanDana, type PengajuanDana } from '@/types'
import { type FormOptions } from '@/Pages/Keuangan/DetailPengajuanDirectPage.vue'

// comps
import {
  PengajuanDirectItemCreateDialog,
  PengajuanDirectItemEditDialog,
  PengajuanDanaItemDeleteDialog
} from '@/Components/Keuangan/detail-pengajuan-dana-page'

interface Data {
  pengajuanDana: PengajuanDana
}

const props = defineProps<{
  rows: DetailPengajuanDana[]
  data: Data
  formOptions: FormOptions
}>()

const totalAmount = computed(() => {
  const pengajuan = props.rows.reduce((total, item) => {
    return total + toFloat(item.jumlah_pengajuan)
  }, 0)

  const disetujui = props.rows.reduce((total, item) => {
    if (selectedIds.value.includes(item.id_detail_pengajuan_dana)) {
      return total + toFloat(item.jumlah_pengajuan)
    }

    return total
  }, 0)

  const ditolak = pengajuan - disetujui

  return {
    pengajuan,
    disetujui,
    ditolak
  }
})

const $q = useQuasar()

function createPengajuanDanaItem () {
  $q.dialog({
    component: PengajuanDirectItemCreateDialog,
    componentProps: {
      pengajuanDana: props.data.pengajuanDana,
      options: props.formOptions
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function editPengajuanDanaItem (data: DetailPengajuanDana) {
  $q.dialog({
    component: PengajuanDirectItemEditDialog,
    componentProps: {
      detailPengajuanDana: data,
      options: props.formOptions
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function deletePengajuanDanaItem (id: DetailPengajuanDana['id_detail_pengajuan_dana']) {
  $q.dialog({
    component: PengajuanDanaItemDeleteDialog,
    componentProps: {
      id_detail_pengajuan_dana: id
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  {
    name: 'uraian',
    label: 'Uraian',
    field: 'uraian',
    align: 'left',
    sortable: true
  },
  { name: 'jenis_pembayaran', label: 'Jenis Pembayaran', field: 'jenis_pembayaran', align: 'left', sortable: true },
  { name: 'bank', label: 'Bank', field: 'nama_bank', align: 'left', sortable: true },
  { name: 'rekening', label: 'Rekening', field: 'nomor_rekening', align: 'left', sortable: true },
  { name: 'jumlah', label: 'Jumlah Pengajuan', field: 'jumlah_pengajuan', align: 'right', sortable: true },
  { name: 'persetujuan', label: 'Approval', field: '', align: 'left' },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
]

const visibleColumn = () => {
  const column = [] as string[]

  if (can('approve pengajuan dana') && isSubmitted(props.data.pengajuanDana)) {
    columns.map(col => {
      return column.push(col.name)
    })
  } else {
    // eslint-disable-next-line array-callback-return
    columns.map(col => {
      if (col.name !== 'persetujuan') {
        return column.push(col.name)
      }
    })
  }

  return column
}

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const filter = ref('')
const selected = ref<DetailPengajuanDana[]>([])

const selectedIds = computed(() => {
  const ids = [] as Array<DetailPengajuanDana['id_detail_pengajuan_dana']>

  // eslint-disable-next-line @typescript-eslint/strict-boolean-expressions
  if (selected.value) {
    selected.value.map(item => {
      return ids.push(item.id_detail_pengajuan_dana)
    })
  }

  return ids
})

export interface ApprovedPengajuanSaatIni {
  id_detail_rap: DetailPengajuanDana['id_detail_rap']
  jumlah_pengajuan: number
};

const approvedPengajuanSaatIni = computed(() => {
  // eslint-disable-next-line @typescript-eslint/strict-boolean-expressions
  if (!selected.value) {
    return []
  }

  const groupedData = selected.value.reduce<ApprovedPengajuanSaatIni[]>((result, item) => {
    const matchedItem = result.find((group) => group.id_detail_rap === item.id_detail_rap)

    if (matchedItem != null) {
      matchedItem.jumlah_pengajuan += toFloat(item.jumlah_pengajuan)
    } else {
      result.push({
        id_detail_rap: item.id_detail_rap,
        jumlah_pengajuan: toFloat(item.jumlah_pengajuan)
      })
    }

    return result
  }, [])

  return groupedData
})

defineExpose({
  selectedIds,
  approvedPengajuanSaatIni
})
</script>

<template>
  <q-table
    flat
    bordered
    row-key="id_detail_pengajuan_dana"
    :rows="rows"
    :columns="columns"
    :visible-columns="visibleColumn()"
    :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
    :fullscreen="tableFullscreen"
    :filter="filter"
    selection="multiple"
    v-model:selected="selected"
    class="no-border"
  >
    <template v-slot:top-left>
      <div class="q-gutter-sm">
        <q-btn
          v-if="isAdmin() ? true : can('create & modify pengajuan dana') && isEditable(data.pengajuanDana)"
          no-caps
          label="Tambah Uraian"
          icon="add"
          color="primary"
          @click="createPengajuanDanaItem"
        />
      </div>
    </template>

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
          <q-checkbox
            v-if="col.name === 'persetujuan'"
            v-model="props.selected"
            label="Approval"
          />

          <span v-else>
            {{ col.label }}
          </span>
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

        <q-td key="persetujuan" :props="props">
          <q-checkbox v-model="props.selected" />
        </q-td>

        <q-td key="actions" :props="props">
          <q-btn
            v-if="isAdmin() ? true : can('create & modify pengajuan dana') && isEditable(data.pengajuanDana)"
            dense
            flat
            color="blue-grey"
            icon="more_vert"
          >
            <q-menu
              auto-close
              transition-show="scale"
              transition-hide="scale"
            >
              <q-list dense style="min-width: 100px">
                <q-item clickable>
                  <q-item-section
                    @click="editPengajuanDanaItem(props.row)"
                  >
                    Edit
                  </q-item-section>
                </q-item>

                <q-separator />

                <q-item clickable>
                  <q-item-section
                    class="text-red"
                    @click="deletePengajuanDanaItem(props.row.id_detail_pengajuan_dana)"
                  >
                    Delete
                  </q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>

          <q-btn
            v-else
            dense
            flat
            color="grey-6"
            icon="block"
          >
            <q-tooltip>Required permission</q-tooltip>
          </q-btn>
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

      <q-tr
        v-if="visibleColumn().includes('persetujuan')"
        no-hover
      >
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Disetujui
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.disetujui) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr
        v-if="visibleColumn().includes('persetujuan')"
        no-hover
      >
        <q-td colspan="5" style="border: none;"></q-td>
        <q-td class="text-right">
          Total Ditolak
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(totalAmount.ditolak) }}
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>
    </template>
  </q-table>
</template>
