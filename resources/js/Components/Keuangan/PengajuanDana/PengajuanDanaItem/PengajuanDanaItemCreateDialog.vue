<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { filterOptions, multiFilterOptions } from '@/utils/options'
import { toRupiah } from '@/utils/money'

// types
import { type FormOptions } from '@/Pages/Keuangan/DetailPengajuanDanaPage.vue'
import { type PengajuanDana } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  pengajuanDana: PengajuanDana
  options: FormOptions
}>()

const jenisPembayaranOptions = ['Cash', 'Transfer']

const posOptionsRef = ref(props.options.detailRap)
const rekeningOptionsRef = ref(props.options.rekening)
const jenisPembayaranOptionsRef = ref(jenisPembayaranOptions)

function posFilter (val: string, update: any) {
  update(() => {
    posOptionsRef.value = multiFilterOptions(val, props.options.detailRap, ['uraian'])
  })
}

function rekeningFilter (val: string, update: any) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(val, props.options.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening'])
  })
}

function jenisPembayaranFilter (val: string, update: any) {
  update(() => {
    jenisPembayaranOptionsRef.value = filterOptions(val, jenisPembayaranOptions)
  })
}

const form = useForm({
  uraian: null,
  jumlah_pengajuan: 0,
  jenis_pembayaran: null,
  id_detail_rap: null,
  id_rekening: null
})

function submit () {
  form.post(route('detail_pengajuan_dana.store', props.pengajuanDana.id_pengajuan_dana), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Tambah Uraian Pengajuan Dana</div>
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

      <q-form @submit.prevent="submit">
        <q-card-section class="scroll">
          <div class="q-gutter-md">
            <q-select
              outlined
              clearable
              use-input
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="POS"
              v-model="form.id_detail_rap"
              option-value="id_detail_rap"
              option-label="uraian"
              :options="posOptionsRef"
              :error="form.errors.id_detail_rap ? true : false"
              :error-message="form.errors.id_detail_rap"
              @filter="posFilter"
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>

            <q-input
              outlined
              autogrow
              hide-bottom-space
              label="Uraian"
              v-model="form.uraian"
              :error="form.errors.uraian ? true : false"
              :error-message="form.errors.uraian"
            />

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  label="Jumlah Pengajuan"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.jumlah_pengajuan"
                  :hint="toRupiah(form.jumlah_pengajuan)"
                  :hide-hint="form.jumlah_pengajuan < 1"
                  :error="form.errors.jumlah_pengajuan ? true : false"
                  :error-message="form.errors.jumlah_pengajuan"
                  input-class="text-right"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-select
                  outlined
                  clearable
                  use-input
                  use-chips
                  hide-bottom-space
                  input-debounce="500"
                  label="Jenis Pembayaran"
                  v-model="form.jenis_pembayaran"
                  :options="jenisPembayaranOptionsRef"
                  :error="form.errors.jenis_pembayaran ? true : false"
                  :error-message="form.errors.jenis_pembayaran"
                  @filter="jenisPembayaranFilter"
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
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="Rekening Pembayaran"
              v-model="form.id_rekening"
              option-value="id_rekening"
              :option-label="(opt) => `${opt.nama_bank} | ${opt.nomor_rekening} - ${opt.nama_rekening}`"
              :options="rekeningOptionsRef"
              :error="form.errors.id_rekening ? true : false"
              :error-message="form.errors.id_rekening"
              @filter="rekeningFilter"
            >
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    <strong class="text-primary">
                      {{ scope.opt.nama_bank }}
                    </strong>
                    {{ scope.opt.nomor_rekening }} - {{ scope.opt.nama_rekening }}
                  </q-item-section>
                </q-item>
              </template>
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn v-if="form.hasErrors"
            flat
            label="Clear Errors"
            color="red"
            @click="form.clearErrors()"
          />
          <q-btn
            flat
            label="Reset"
            color="secondary"
            @click="form.reset()"
          />
          <q-btn
            flat
            type="submit"
            label="Submit"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
