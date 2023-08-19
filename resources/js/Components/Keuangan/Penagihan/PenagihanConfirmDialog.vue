<script setup lang="ts">
// cores
import { useDialogPluginComponent, type QTableColumn } from 'quasar'
import { useForm } from '@inertiajs/vue3'

// utils
import { toRupiah } from '@/utils/money'
import { toFloat } from '@/utils/number'

// types
import type { Penagihan } from '@/types'
import type { Evaluasi } from '@/Pages/Keuangan/DetailPenagihanPage.vue'
import { ref } from 'vue'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  data: {
    id_penagihan: Penagihan['id_penagihan']
    evaluasi: Evaluasi[]
    jumlah_diterima: string
  }
}>()

const penerimaanOptions = ['Diterima', 'Diterima Sebagian', 'Tolak']
const penerimaanOptionsRef = ref(penerimaanOptions)
const penerimaan = ref(null)

const form = useForm({
  id_penagihan: props.data.id_penagihan,
  jumlah_diterima: props.data.jumlah_diterima,
  catatan: null
})

function confirmAction () {
  if (penerimaan.value === 'Diterima') {
    confirm()
  } else if (penerimaan.value === 'Diterima Sebagian') {
    shallowConfirm()
  } else if (penerimaan.value === 'Tolak') {
    reject()
  }
}

function confirm () {
  form.transform((form) => ({
    ...form,
    bertahap: false,
    jumlah_diterima: 1
  })).post(route('penagihan.confirm', props.data.id_penagihan), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
}

function shallowConfirm () {
  form.transform((form) => ({
    ...form,
    bertahap: true
  })).post(route('penagihan.confirm', props.data.id_penagihan), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
}

function reject () {
  form.post(route('penagihan.reject', props.data.id_penagihan), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
}

const columns: QTableColumn[] = [
  { name: 'nilai_kontrak', label: 'Nilai Kontrak', field: 'nilai_kontrak', align: 'right', sortable: true },
  { name: 'invoice_sebelumnya', label: 'Invoice Sebelumnya', field: 'invoice_sebelumnya', align: 'right', sortable: true },
  { name: 'invoice_saat_ini', label: 'Invoice Saat Ini', field: 'invoice_saat_ini', align: 'right', sortable: true },
  { name: 'sisa_netto_kontrak', label: 'Sisa Netto Kontrak', field: 'sisa_netto_kontrak', align: 'right', sortable: true }
]
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card style="max-width: 100vw">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Lembar Evaluasi</div>
          <q-space />
          <q-btn
            flat
            round
            dense
            icon="close"
            @click="onDialogCancel"
          />
        </q-card-section>

      <q-separator />

      <q-card-section class="scroll">
        <div class="q-gutter-md">
          <q-table
            flat
            row-key="id_proyek"
            :rows="data.evaluasi"
            :columns="columns"
            :rows-per-page-options="[ 0 ]"
            hide-bottom
          >

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
                <q-td key="nilai_kontrak" :props="props">
                  {{ toRupiah(toFloat(props.row.nilai_kontrak)) }}
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
          </q-table>
        </div>
      </q-card-section>

      <q-card-section>
        <div class="q-mb-md row q-col-gutter-md">
          <div class="col-12 col-md-6">
            <q-select
              outlined
              v-model="penerimaan"
              label="Pilih Aksi*"
              :options="penerimaanOptionsRef"
            />
          </div>
          <div class="col-12 col-md-6">
            <q-input
              outlined
              autogrow
              v-model="form.catatan"
              label="Catatan"
            />
          </div>
        </div>

        <q-input
          v-if="penerimaan === 'Diterima Sebagian'"
          outlined
          hide-bottom-space
          v-model="form.jumlah_diterima"
          label="Jumlah Diterima*"
          :hint="toRupiah(toFloat(form.jumlah_diterima))"
          :error="form.errors.jumlah_diterima?.length ? true : false"
          :error-message="form.errors.jumlah_diterima"
          input-class="text-right"
        />
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn
          flat
          label="Confirm"
          color="primary"
          :loading="form.processing"
          @click="confirmAction"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
