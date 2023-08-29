<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { onMounted, ref } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'
import { toRupiah } from '@/utils/money'
import { sanitizeUsNumber, toFloat } from '@/utils/number'

// types
import { type FormOptions } from '@/Pages/Keuangan/PenagihanPage.vue'
import type { Penagihan, Proyek } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  penagihan: Penagihan & { id_rekening_pg: string }
  options: FormOptions
}>()

const proyekOptionsRef = ref(props.options.proyek)
const rekeningOptionsRef = ref(props.options.rekening)

function proyekFilter (val: string, update: any) {
  update(() => {
    proyekOptionsRef.value = multiFilterOptions(val, props.options.proyek, ['nama_proyek', 'tahun_anggaran'])
  })
}

function rekeningFilter (val: string, update: any) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(
      val, props.options.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening']
    )
  })
}

const penyediaJasa = ref('')
const penggunaJasa = ref('')

function onChooseProyek (id: Proyek['id_proyek']) {
  const match = props.options.proyek.find(item => item.id_proyek === id)

  if (match !== undefined) {
    if (match.penyedia_jasa !== undefined) {
      penyediaJasa.value = match.penyedia_jasa
    }
    if (match.pengguna_jasa !== undefined) {
      penggunaJasa.value = match.pengguna_jasa
    }
  }
}

async function onChangeNilaiNetto (amount: string | number | null) {
  if (typeof amount === 'string') {
    const formattedAmount = await sanitizeUsNumber(amount)
    form.nilai_netto = formattedAmount
  }
}

const form = useForm({
  id_proyek: props.penagihan.id_proyek,
  id_rekening: props.penagihan.id_rekening_pg,
  keperluan: props.penagihan.keperluan,
  nomor_sp2d: props.penagihan.nomor_sp2d,
  tanggal_sp2d: props.penagihan.tanggal_sp2d,
  tanggal_terbit: props.penagihan.tanggal_terbit,
  tanggal_cair: props.penagihan.tanggal_cair,
  nilai_netto: toFloat(props.penagihan.nilai_netto),
  faktur: null
})

function submit () {
  form.post(route('penagihan.update', props.penagihan.id_penagihan), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
}

onMounted(() => {
  onChooseProyek(form.id_proyek)
})
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Edit Penagihan/Invoice</div>
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
              use-input
              use-chips
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="Pilih Proyek"
              v-model="form.id_proyek"
              :option-value="(opt) => opt.id_proyek"
              :option-label="(opt) => `${opt.nama_proyek} - ${opt.tahun_anggaran}`"
              :options="proyekOptionsRef"
              :error="form.errors.id_proyek ? true : false"
              :error-message="form.errors.id_proyek"
              @filter="proyekFilter"
              @update:model-value="(opt) => onChooseProyek(opt)"
            >
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    <strong class="text-primary">
                      {{ scope.opt.nama_proyek }}
                    </strong>
                    {{ scope.opt.tahun_anggaran }}
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

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  readonly
                  outlined
                  label="Penyedia Jasa"
                  v-model="penyediaJasa"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  readonly
                  outlined
                  label="Pengguna Jasa"
                  v-model="penggunaJasa"
                />
              </div>
            </div>

            <q-select
              outlined
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

            <q-input
              outlined
              autogrow
              hide-bottom-space
              label="Keperluan"
              v-model="form.keperluan"
              :error="form.errors.keperluan ? true : false"
              :error-message="form.errors.keperluan"
            />

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Nomor SP2D"
                  v-model="form.nomor_sp2d"
                  :error="form.errors.nomor_sp2d ? true : false"
                  :error-message="form.errors.nomor_sp2d"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal SP2D"
                  type="date"
                  v-model="form.tanggal_sp2d"
                  :error="form.errors.tanggal_sp2d ? true : false"
                  :error-message="form.errors.tanggal_sp2d"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Terbit"
                  type="date"
                  v-model="form.tanggal_terbit"
                  :error="form.errors.tanggal_terbit ? true : false"
                  :error-message="form.errors.tanggal_terbit"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Cair"
                  type="date"
                  v-model="form.tanggal_cair"
                  :error="form.errors.tanggal_cair ? true : false"
                  :error-message="form.errors.tanggal_cair"
                />
              </div>
            </div>

            <q-input
              outlined
              hide-bottom-space
              label="Nilai Netto"
              v-model="form.nilai_netto"
              :hint="toRupiah(form.nilai_netto)"
              :hide-hint="form.nilai_netto < 1"
              :error="form.errors.nilai_netto ? true : false"
              :error-message="form.errors.nilai_netto"
              input-class="text-right"
              @update:model-value="(val) => onChangeNilaiNetto(val)"
            />

            <q-file
              outlined
              counter
              hide-bottom-space
              v-model="form.faktur"
              label="Upload Faktur (Optional)"
              hint="Format: png, jpeg, jpg, pdf | Size: 100 KB"
              :error="form.errors.faktur ? true : false"
              :error-message="form.errors.faktur"
            />
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
            label="Update"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
