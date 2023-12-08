<script setup lang="ts">
// cores
import { ref, computed } from 'vue'
import { useQuasar } from 'quasar'
import { useForm } from '@inertiajs/vue3'

// utils
import { toRupiah } from '@/utils/money'
import { can, isAdmin, isEditable } from '@/utils/permissions'
import { toFloat } from '@/utils/number'

// types
import type { DetailRAB, RAB } from '@/types'
import type { FormOptions } from '@/Pages/Main/RABPage.vue'
import type { QTableColumn } from 'quasar'

// comps
import {
  RABItemImportDialog,
  RABItemCreateDialog,
  RABItemEditDialog,
  RABItemDeleteDialog
} from '@/Components/Main/detail-rab-page'

interface Data {
  rab: RAB
}

const props = defineProps<{
  rows: DetailRAB[]
  data: Data
  formOptions: FormOptions
}>()

const totalAmount = computed(() => {
  const dpp = props.rows.reduce((total, item) => {
    return total + (toFloat(item.harga_satuan) * toFloat(item.volume))
  }, 0)

  const ppn = (toFloat(form.tax) / 100) * dpp
  const pph = (toFloat(form.additional_tax) / 100) * dpp

  return {
    dpp,
    ppn,
    pph
  }
})

const form = useForm({
  tax: props.data.rab.tax,
  additional_tax: props.data.rab.additional_tax
})

function updateTax () {
  form.patch(route('rab.update_tax', props.data.rab.id_rab))
}

const $q = useQuasar()

function importRABItem () {
  $q.dialog({
    component: RABItemImportDialog,
    componentProps: {
      id_rab: props.data.rab.id_rab
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function createRABItem () {
  $q.dialog({
    component: RABItemCreateDialog,
    componentProps: {
      rab: props.data.rab,
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

function editRABItem (data: DetailRAB) {
  $q.dialog({
    component: RABItemEditDialog,
    componentProps: {
      detailRab: data,
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

function deleteRABItem (id: DetailRAB['id_detail_rab']) {
  $q.dialog({
    component: RABItemDeleteDialog,
    componentProps: {
      id_detail_rab: id
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
  { name: 'nama_satuan', label: 'Satuan', field: 'nama_satuan', align: 'left', sortable: true },
  { name: 'harga_satuan', label: 'Harga Satuan', field: 'harga_satuan', align: 'right', sortable: true },
  { name: 'volume', label: 'Volume', field: 'volume', align: 'left', sortable: true },
  { name: 'total_harga', label: 'Total Harga', field: '', align: 'right', sortable: true },
  { name: 'keterangan', label: 'Ket', field: 'keterangan', align: 'left', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}

const filter = ref('')
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      row-key="id_detail_rab"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
      :filter="filter"
    >
      <template v-slot:top-left>
        <div class="q-gutter-sm">
          <q-btn
            v-if="isAdmin() ? true : can('create & modify rab') && isEditable(data.rab)"
            no-caps
            label="Tambah Uraian RAB"
            icon="add"
            color="primary"
            @click="createRABItem"
          />
          <q-btn
            v-if="isAdmin() ? true : can('create & modify rab') && isEditable(data.rab)"
            no-caps
            label="Import dari CSV/XLS"
            icon="upload_file"
            color="green-8"
            @click="importRABItem"
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

          <q-td key="uraian" :props="props">
            {{ props.row.uraian }}
          </q-td>

          <q-td key="nama_satuan" :props="props">
            {{ props.row.nama_satuan }}
          </q-td>

          <q-td key="harga_satuan" :props="props">
            {{ toRupiah(props.row.harga_satuan) }}
          </q-td>

          <q-td key="volume" :props="props">
            {{ props.row.volume }}
          </q-td>

          <q-td key="total_harga" :props="props">
            {{ toRupiah(props.row.harga_satuan * props.row.volume) }}
          </q-td>

          <q-td key="keterangan" :props="props">
            {{ props.row.keterangan }}
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify rab') && isEditable(data.rab)"
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
                      @click="editRABItem(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />

                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteRABItem(props.row.id_detail_rab)"
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
          <q-td colspan="4" style="border: none"></q-td>
          <q-td class="text-right">
            PPN
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ form.tax }} %
            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify rab') && isEditable(data.rab)"
              v-model.number="form.tax"
              v-slot="scope"
              title="PPN"
              @hide="updateTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.tax"
                :error="form.errors.tax ? true : false"
                :error-message="form.errors.tax"
                input-class="text-right"
                @keyup.enter="() => {
                  updateTax()
                  scope.set()
                }"
              >
                <template #append>%</template>
              </q-input>
            </q-popup-edit>
            <span v-else>{{ data.rab.tax }}%</span>
          </q-td>
          <q-td colspan="2" style="border: none"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="4" style="border: none"></q-td>
          <q-td class="text-right">
            PPH
          </q-td>
          <q-td class="text-right text-weight-bold text-primary" style="cursor: pointer;">
            {{ form.additional_tax }} %
            <q-popup-edit
              v-if="isAdmin() ? true : can('create & modify rab') && isEditable(data.rab)"
              v-model.number="form.additional_tax"
              v-slot="scope"
              title="PPH"
              @hide="updateTax"
            >
              <q-input
                flat
                dense
                autofocus
                hide-bottom-space
                v-model="form.additional_tax"
                :error="form.errors.additional_tax ? true : false"
                :error-message="form.errors.additional_tax"
                input-class="text-right"
                @keyup.enter="() => {
                  updateTax()
                  scope.set()
                }"
              >
                <template #append>%</template>
              </q-input>
            </q-popup-edit>
            <span v-else>{{ data.rab.additional_tax }}%</span>
          </q-td>
          <q-td colspan="2" style="border: none"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="4" style="border: none"></q-td>
          <q-td class="text-right">
            Total RAB
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.dpp) }}
          </q-td>
          <q-td colspan="2" style="border: none"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="4" style="border: none"></q-td>
          <q-td class="text-right">
            Nilai Kontrak
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.dpp + totalAmount.ppn) }}
          </q-td>
          <q-td colspan="2" style="border: none"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="4" style="border: none"></q-td>
          <q-td class="text-right">
            Netto
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.dpp - totalAmount.pph) }}
          </q-td>
          <q-td colspan="2" style="border: none"></q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
