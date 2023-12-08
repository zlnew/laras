<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { type QTableColumn, useQuasar } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { can, isAdmin, isEditable } from '@/utils/permissions'
import { toFloat } from '@/utils/number'

// types
import { type DetailPenagihan, type Penagihan } from '@/types'

// comps
import {
  PenagihanItemCreateDialog,
  PenagihanItemEditDialog,
  PenagihanItemDeleteDialog
} from '@/Components/Keuangan/detail-penagihan-page'
import { useForm } from '@inertiajs/vue3'

interface Data {
  penagihan: Penagihan
}

const props = defineProps<{
  rows: DetailPenagihan[]
  data: Data
}>()

const totalAmount = computed(() => {
  const penagihan = props.rows.reduce((total, item) => {
    return total + (toFloat(item.harga_satuan_penagihan) * toFloat(item.volume_penagihan))
  }, 0)

  const pencairan = penagihan - toFloat(form.potongan_ppn) - toFloat(form.potongan_pph) - toFloat(form.potongan_lainnya) - toFloat(form.potongan_lainnya2) - toFloat(form.potongan_lainnya3)

  return {
    penagihan,
    pencairan
  }
})

const $q = useQuasar()

function createPenagihanItem () {
  $q.dialog({
    component: PenagihanItemCreateDialog,
    componentProps: {
      penagihan: props.data.penagihan
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function editPenagihanItem (data: DetailPenagihan) {
  $q.dialog({
    component: PenagihanItemEditDialog,
    componentProps: {
      detailPenagihan: data
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function deletePenagihanItem (id: DetailPenagihan['id_detail_penagihan']) {
  $q.dialog({
    component: PenagihanItemDeleteDialog,
    componentProps: {
      id_detail_penagihan: id
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
  { name: 'uraian', label: 'Uraian', field: 'uraian', align: 'left', sortable: true },
  { name: 'harga_satuan_penagihan', label: 'Harga Satuan', field: 'harga_satuan_penagihan', align: 'right', sortable: true },
  { name: 'volume_penagihan', label: 'Volume', field: 'volume_penagihan', align: 'right', sortable: true },
  { name: 'total_harga', label: 'Total Harga', field: 'total_harga', align: 'right', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const filter = ref('')
const selected = ref<DetailPenagihan[]>([])

const form = useForm({
  potongan_ppn: props.data.penagihan.potongan_ppn,
  potongan_pph: props.data.penagihan.potongan_pph,
  potongan_lainnya: props.data.penagihan.potongan_lainnya,
  potongan_lainnya2: props.data.penagihan.potongan_lainnya2,
  potongan_lainnya3: props.data.penagihan.potongan_lainnya3,
  keterangan_potongan_lainnya: props.data.penagihan.keterangan_potongan_lainnya,
  keterangan_potongan_lainnya2: props.data.penagihan.keterangan_potongan_lainnya2,
  keterangan_potongan_lainnya3: props.data.penagihan.keterangan_potongan_lainnya3
})

function saveTax () {
  form.put(route('penagihan.tax', props.data.penagihan.id_penagihan), {
    preserveScroll: true,
    onSuccess: () => {
      return true
    }
  })
}
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      row-key="id_detail_penagihan"
      :rows="rows"
      :columns="columns"
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
            v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
            no-caps
            label="Tambah Uraian"
            icon="add"
            color="primary"
            @click="createPenagihanItem"
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
              v-if="col.name === 'penerimaan'"
              v-model="props.selected"
              label="Penerimaan"
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

          <q-td key="harga_satuan_penagihan" :props="props">
            {{ toRupiah(toFloat(props.row.harga_satuan_penagihan)) }}
          </q-td>

          <q-td key="volume_penagihan" :props="props">
            {{ toFloat(props.row.volume_penagihan) }}
          </q-td>

          <q-td key="total_harga" :props="props">
            {{ toRupiah(toFloat(props.row.harga_satuan_penagihan) * toFloat(props.row.volume_penagihan)) }}
          </q-td>

          <q-td key="penerimaan" :props="props">
            <q-checkbox v-model="props.selected" />
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
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
                  <q-item clickable @click="editPenagihanItem(props.row)">
                    <q-item-section>
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />

                  <q-item clickable @click="deletePenagihanItem(props.row.id_detail_penagihan)">
                    <q-item-section class="text-red">
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
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Total Penagihan
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.penagihan) }}
          </q-td>
          <q-td style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Total Diterima
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(toFloat(data.penagihan.jumlah_diterima)) }}
          </q-td>
          <q-td style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Potongan PPN
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ toRupiah(toFloat(form.potongan_ppn)) }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model.number="form.potongan_ppn"
              v-slot="scope"
              title="Potongan PPN"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.potongan_ppn"
                :hint="toRupiah(toFloat(form.potongan_ppn))"
                :error="form.errors.potongan_ppn ? true : false"
                :error-message="form.errors.potongan_ppn"
                input-class="text-right"
                @keyup.enter="() => {
                  saveTax()
                  scope.set()
                }"
              />
            </q-popup-edit>
          </q-td>
          <q-td style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Potongan PPH
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ toRupiah(toFloat(form.potongan_pph)) }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model.number="form.potongan_pph"
              v-slot="scope"
              title="Potongan PPH"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.potongan_pph"
                :hint="toRupiah(toFloat(form.potongan_pph))"
                :error="form.errors.potongan_pph ? true : false"
                :error-message="form.errors.potongan_pph"
                input-class="text-right"
                @keyup.enter="() => {
                  saveTax()
                  scope.set()
                }"
              />
            </q-popup-edit>
          </q-td>
          <q-td style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Potongan Lainnya #1
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ toRupiah(toFloat(form.potongan_lainnya)) }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model.number="form.potongan_lainnya"
              v-slot="scope"
              title="Potongan Lainnya #1"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.potongan_lainnya"
                :hint="toRupiah(toFloat(form.potongan_lainnya))"
                :error="form.errors.potongan_lainnya ? true : false"
                :error-message="form.errors.potongan_lainnya"
                input-class="text-right"
                @keyup.enter="() => {
                  saveTax()
                  scope.set()
                }"
              />
            </q-popup-edit>
          </q-td>
          <q-td class="text-primary" style="cursor: pointer;">
            {{ form.keterangan_potongan_lainnya || 'Tambah Keterangan' }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model="form.keterangan_potongan_lainnya"
              title="Keterangan Potongan Lainnya #1"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autogrow
                autofocus
                hide-bottom-space
                v-model="form.keterangan_potongan_lainnya"
                :error="form.errors.keterangan_potongan_lainnya ? true : false"
                :error-message="form.errors.keterangan_potongan_lainnya"
              />
            </q-popup-edit>
          </q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Potongan Lainnya #2
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ toRupiah(toFloat(form.potongan_lainnya2)) }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model.number="form.potongan_lainnya2"
              v-slot="scope"
              title="Potongan Lainnya #2"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.potongan_lainnya2"
                :hint="toRupiah(toFloat(form.potongan_lainnya2))"
                :error="form.errors.potongan_lainnya2 ? true : false"
                :error-message="form.errors.potongan_lainnya2"
                input-class="text-right"
                @keyup.enter="() => {
                  saveTax()
                  scope.set()
                }"
              />
            </q-popup-edit>
          </q-td>
          <q-td class="text-primary" style="cursor: pointer;">
            {{ form.keterangan_potongan_lainnya2 || 'Tambah Keterangan' }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model="form.keterangan_potongan_lainnya2"
              title="Keterangan Potongan Lainnya #2"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autogrow
                autofocus
                hide-bottom-space
                v-model="form.keterangan_potongan_lainnya2"
                :error="form.errors.keterangan_potongan_lainnya2 ? true : false"
                :error-message="form.errors.keterangan_potongan_lainnya2"
              />
            </q-popup-edit>
          </q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Potongan Lainnya #3
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ toRupiah(toFloat(form.potongan_lainnya3)) }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model.number="form.potongan_lainnya3"
              v-slot="scope"
              title="Potongan Lainnya #3"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.potongan_lainnya3"
                :hint="toRupiah(toFloat(form.potongan_lainnya3))"
                :error="form.errors.potongan_lainnya3 ? true : false"
                :error-message="form.errors.potongan_lainnya3"
                input-class="text-right"
                @keyup.enter="() => {
                  saveTax()
                  scope.set()
                }"
              />
            </q-popup-edit>
          </q-td>
          <q-td class="text-primary" style="cursor: pointer;">
            {{ form.keterangan_potongan_lainnya3 || 'Tambah Keterangan' }}

            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
              v-model="form.keterangan_potongan_lainnya3"
              title="Keterangan Potongan Lainnya #3"
              @hide="saveTax"
            >
              <q-input
                flat
                dense
                autogrow
                autofocus
                hide-bottom-space
                v-model="form.keterangan_potongan_lainnya3"
                :error="form.errors.keterangan_potongan_lainnya3 ? true : false"
                :error-message="form.errors.keterangan_potongan_lainnya3"
              />
            </q-popup-edit>
          </q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="3" style="border: none;"></q-td>
          <q-td class="text-right">
            Total Pencairan/Netto
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.pencairan) }}
          </q-td>
          <q-td style="border: none;"></q-td>
        </q-tr>

      </template>
    </q-table>
  </div>
</template>
