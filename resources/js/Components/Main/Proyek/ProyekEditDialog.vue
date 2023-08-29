<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { toRupiah } from '@/utils/money'
import { filterOptions, multiFilterOptions } from '@/utils/options'
import { daysDiff, endOfDate } from '@/utils/date'
import { sanitizeUsNumber, toFloat } from '@/utils/number'

// types
import type { FormOptions } from '@/Pages/Main/ProyekPage.vue'
import type { Proyek } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  proyek: Proyek
  options: FormOptions
}>()

const penggunaJasaOptionsRef = ref(props.options.penggunaJasa)
const penyediaJasaOptionsRef = ref(props.options.penyediaJasa)
const tahunAnggaranOptionsRef = ref(props.options.tahunAnggaran)
const rekeningOptionsRef = ref(props.options.rekening)
const picOptionsRef = ref(props.options.pic)

function penggunaJasaFilter (val: string, update: any) {
  update(() => {
    penggunaJasaOptionsRef.value = filterOptions(val, props.options.penggunaJasa)
  })
}

function penyediaJasaFilter (val: string, update: any) {
  update(() => {
    penyediaJasaOptionsRef.value = filterOptions(val, props.options.penyediaJasa)
  })
}

function tahunAnggaranFilter (val: string, update: any) {
  update(() => {
    tahunAnggaranOptionsRef.value = filterOptions(val, props.options.tahunAnggaran)
  })
}

function rekeningFilter (val: string, update: any) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(
      val, props.options.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening']
    )
  })
}

function picFilter (val: string, update: any) {
  update(() => {
    picOptionsRef.value = multiFilterOptions(
      val, props.options.pic, ['id', 'name']
    )
  })
}

function updateTanggalMulai (val: string) {
  form.tanggal_mulai = val
  updateDaysDiff()
}

function updateTanggalSelesai (val: string) {
  form.tanggal_selesai = val
  updateDaysDiff()
}

function updateDurasi (val: number) {
  form.durasi = val
  updateEndOfDate()
}

function updateEndOfDate () {
  const endDate = endOfDate(form.tanggal_mulai, form.durasi)
  if (endDate !== null && endDate > form.tanggal_mulai) {
    form.tanggal_selesai = endDate
  }
}

function updateDaysDiff () {
  const days = daysDiff(form.tanggal_mulai, form.tanggal_selesai)
  if (days >= 0) {
    form.durasi = days
  }
}

async function onChangeNilaiKontrak (amount: string | number | null) {
  if (typeof amount === 'string') {
    const formattedAmount = await sanitizeUsNumber(amount)
    form.nilai_kontrak = formattedAmount
  }
}

const form = useForm({
  nama_proyek: props.proyek.nama_proyek,
  nomor_kontrak: props.proyek.nomor_kontrak,
  tanggal_kontrak: props.proyek.tanggal_kontrak,
  pengguna_jasa: props.proyek.pengguna_jasa,
  penyedia_jasa: props.proyek.penyedia_jasa,
  tahun_anggaran: props.proyek.tahun_anggaran,
  nomor_spmk: props.proyek.nomor_spmk,
  tanggal_spmk: props.proyek.tanggal_spmk,
  nilai_kontrak: toFloat(props.proyek.nilai_kontrak),
  tanggal_mulai: props.proyek.tanggal_mulai,
  durasi: props.proyek.durasi,
  tanggal_selesai: props.proyek.tanggal_selesai,
  id_user: props.proyek.id_user,
  id_rekening: props.proyek.id_rekening
})

function submit () {
  form.transform(form => ({
    ...form,
    tanggal_selesai: endOfDate(form.tanggal_mulai, form.durasi)
  })).patch(route('proyek.update', props.proyek.id_proyek), {
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
          <div class="text-h6">Tambah Proyek Baru</div>
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
            <q-input
              outlined
              autogrow
              hide-bottom-space
              clear-icon="close"
              label="Nama Proyek"
              v-model="form.nama_proyek"
              :error="form.errors.nama_proyek ? true : false"
              :error-message="form.errors.nama_proyek"
            />

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  autogrow
                  hide-bottom-space
                  clear-icon="close"
                  label="Nomor Kontrak"
                  v-model="form.nomor_kontrak"
                  :error="form.errors.nomor_kontrak ? true : false"
                  :error-message="form.errors.nomor_kontrak"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Kontrak"
                  type="date"
                  v-model="form.tanggal_kontrak"
                  :error="form.errors.tanggal_kontrak ? true : false"
                  :error-message="form.errors.tanggal_kontrak"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-select
                  outlined
                  use-input
                  hide-bottom-space
                  input-debounce="500"
                  new-value-mode="add-unique"
                  label="Pengguna Jasa"
                  v-model="form.pengguna_jasa"
                  :options="penggunaJasaOptionsRef"
                  :error="form.errors.pengguna_jasa ? true : false"
                  :error-message="form.errors.pengguna_jasa"
                  @filter="penggunaJasaFilter"
                >
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        Enter to add new pengguna jasa
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </div>
              <div class="col-12 col-md-6 q-pl-sm">
                <q-select
                  outlined
                  use-input
                  hide-bottom-space
                  input-debounce="500"
                  new-value-mode="add-unique"
                  label="Penyedia Jasa"
                  v-model="form.penyedia_jasa"
                  :options="penyediaJasaOptionsRef"
                  :error="form.errors.penyedia_jasa ? true : false"
                  :error-message="form.errors.penyedia_jasa"
                  @filter="penyediaJasaFilter"
                >
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        Enter to add new penyedia jasa
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </div>
            </div>

            <q-select
              outlined
              use-input
              use-chips
              hide-bottom-space
              input-debounce="500"
              new-value-mode="add-unique"
              label="Tahun Anggaran"
              v-model="form.tahun_anggaran"
              :options="tahunAnggaranOptionsRef"
              :error="form.errors.tahun_anggaran ? true : false"
              :error-message="form.errors.tahun_anggaran"
              @filter="tahunAnggaranFilter"
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Enter to add new tahun anggaran
                  </q-item-section>
                </q-item>
              </template>
            </q-select>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  autogrow
                  hide-bottom-space
                  clear-icon="close"
                  label="Nomor SPMK"
                  v-model="form.nomor_spmk"
                  :error="form.errors.nomor_spmk ? true : false"
                  :error-message="form.errors.nomor_spmk"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal SPMK"
                  type="date"
                  v-model="form.tanggal_spmk"
                  :error="form.errors.tanggal_spmk ? true : false"
                  :error-message="form.errors.tanggal_spmk"
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
              label="PIC/Penanggung Jawab"
              v-model="form.id_user"
              option-value="id"
              option-label="name"
              :options="picOptionsRef"
              :error="form.errors.id_user ? true : false"
              :error-message="form.errors.id_user"
              @filter="picFilter"
            >
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
                  outlined
                  hide-bottom-space
                  label="Tanggal Mulai"
                  type="date"
                  :model-value="form.tanggal_mulai"
                  @update:model-value="updateTanggalMulai(($event as string))"
                  :error="form.errors.tanggal_mulai ? true : false"
                  :error-message="form.errors.tanggal_mulai"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Durasi (Hari)"
                  min="1"
                  type="number"
                  suffix="Hari"
                  input-class="text-right"
                  :model-value="form.durasi"
                  @update:model-value="updateDurasi(($event as number))"
                  :error="form.errors.durasi ? true : false"
                  :error-message="form.errors.durasi"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Selesai"
                  type="date"
                  :model-value="form.tanggal_selesai"
                  @update:model-value="updateTanggalSelesai(($event as string))"
                  :error="form.errors.tanggal_selesai ? true : false"
                  :error-message="form.errors.tanggal_selesai"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Nilai Kontrak"
                  v-model="form.nilai_kontrak"
                  :hint="toRupiah(form.nilai_kontrak)"
                  :hide-hint="form.nilai_kontrak < 1"
                  :error="form.errors.nilai_kontrak ? true : false"
                  :error-message="form.errors.nilai_kontrak"
                  input-class="text-right"
                  @update:model-value="(val) => onChangeNilaiKontrak(val)"
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
