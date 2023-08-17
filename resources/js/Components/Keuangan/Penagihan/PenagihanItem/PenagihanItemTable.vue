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
import { type FormOptions } from '@/Pages/Keuangan/DetailPenagihanPage.vue'

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
  formOptions: FormOptions
}>()

const totalAmount = computed(() => {
  const penagihan = props.rows.reduce((total, item) => {
    return total + (toFloat(item.harga_satuan_penagihan) * toFloat(item.volume_penagihan))
  }, 0)

  const pencairan = penagihan - toFloat(form.potongan_ppn) - toFloat(form.potongan_pph) - toFloat(form.potongan_lainnya)

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
      penagihan: props.data.penagihan,
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

function editPenagihanItem (data: DetailPenagihan) {
  $q.dialog({
    component: PenagihanItemEditDialog,
    componentProps: {
      detailPenagihan: data,
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
  { name: 'harga_satuan', label: 'Harga Satuan', field: 'harga_satuan', align: 'right', sortable: true },
  { name: 'volume', label: 'Volume', field: 'volume', align: 'right', sortable: true },
  { name: 'total_harga', label: 'Total Harga', field: 'total_harga', align: 'right', sortable: true },
  // { name: 'penerimaan', label: 'Penerimaan', field: '', align: 'left' },
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
  keterangan_potongan_lainnya: props.data.penagihan.keterangan_potongan_lainnya
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

        <q-td key="harga_satuan" :props="props">
          {{ toRupiah(toFloat(props.row.harga_satuan_penagihan)) }}
        </q-td>

        <q-td key="volume" :props="props">
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
                <q-item clickable>
                  <q-item-section
                    @click="editPenagihanItem(props.row)"
                  >
                    Edit
                  </q-item-section>
                </q-item>

                <q-separator />

                <q-item clickable>
                  <q-item-section
                    class="text-red"
                    @click="deletePenagihanItem(props.row.id_detail_penagihan)"
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
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(toFloat(form.potongan_ppn)) }}

          <q-popup-edit
            v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
            v-model.number="form.potongan_ppn"
            v-slot="scope"
          >
            <q-input
              flat
              dense
              hide-bottom-space
              reverse-fill-mask
              mask="#.##"
              fill-mask="0"
              v-model="form.potongan_ppn"
              :hint="toRupiah(toFloat(form.potongan_ppn))"
              :error="form.errors.potongan_ppn ? true : false"
              :error-message="form.errors.potongan_ppn"
              input-class="text-right"
            >
              <template v-slot:after>
                <q-btn
                  flat dense color="negative" icon="cancel"
                  @click.stop.prevent="scope.cancel"
                />
                <q-btn
                  flat dense color="positive" icon="check_circle"
                  :disable="!form.isDirty"
                  @click.stop.prevent="saveTax()"
                  @click="scope.set"
                />
              </template>
            </q-input>
          </q-popup-edit>
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr no-hover>
        <q-td colspan="3" style="border: none;"></q-td>
        <q-td class="text-right">
          Potongan PPH
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(toFloat(form.potongan_pph)) }}

          <q-popup-edit
            v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
            v-model.number="form.potongan_pph"
            v-slot="scope"
          >
            <q-input
              flat
              dense
              hide-bottom-space
              reverse-fill-mask
              mask="#.##"
              fill-mask="0"
              v-model="form.potongan_pph"
              :hint="toRupiah(toFloat(form.potongan_pph))"
              :error="form.errors.potongan_pph ? true : false"
              :error-message="form.errors.potongan_pph"
              input-class="text-right"
            >
              <template v-slot:after>
                <q-btn
                  flat dense color="negative" icon="cancel"
                  @click.stop.prevent="scope.cancel"
                />
                <q-btn
                  flat dense color="positive" icon="check_circle"
                  :disable="!form.isDirty"
                  @click.stop.prevent="saveTax()"
                  @click="scope.set"
                />
              </template>
            </q-input>
          </q-popup-edit>
        </q-td>
        <q-td style="border: none;"></q-td>
      </q-tr>

      <q-tr no-hover>
        <q-td colspan="3" style="border: none;"></q-td>
        <q-td class="text-right">
          Potongan Lainnya
        </q-td>
        <q-td class="text-right text-weight-bold">
          {{ toRupiah(toFloat(form.potongan_lainnya)) }}

          <q-popup-edit
            v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
            v-model.number="form.potongan_lainnya"
            v-slot="scope"
          >
            <q-input
              flat
              dense
              hide-bottom-space
              reverse-fill-mask
              mask="#.##"
              fill-mask="0"
              v-model="form.potongan_lainnya"
              :hint="toRupiah(toFloat(form.potongan_lainnya))"
              :error="form.errors.potongan_lainnya ? true : false"
              :error-message="form.errors.potongan_lainnya"
              input-class="text-right"
            >
              <template v-slot:after>
                <q-btn
                  flat dense color="negative" icon="cancel"
                  @click.stop.prevent="scope.cancel"
                />
                <q-btn
                  flat dense color="positive" icon="check_circle"
                  :disable="!form.isDirty"
                  @click.stop.prevent="saveTax()"
                  @click="scope.set"
                />
              </template>
            </q-input>
          </q-popup-edit>
        </q-td>
        <q-td>
          {{ form.keterangan_potongan_lainnya || 'Tambah Keterangan' }}

          <q-popup-edit
            v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(data.penagihan)"
            v-model="form.keterangan_potongan_lainnya"
            v-slot="scope"
          >
            <q-input
              flat
              dense
              autogrow
              hide-bottom-space
              label="Tambah Keterangan"
              v-model="form.keterangan_potongan_lainnya"
              :error="form.errors.keterangan_potongan_lainnya ? true : false"
              :error-message="form.errors.keterangan_potongan_lainnya"
            >
              <template v-slot:after>
                <q-btn
                  flat dense color="negative" icon="cancel"
                  @click.stop.prevent="scope.cancel"
                />
                <q-btn
                  flat dense color="positive" icon="check_circle"
                  :disable="!form.isDirty"
                  @click.stop.prevent="saveTax()"
                  @click="scope.set"
                />
              </template>
            </q-input>
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
</template>
