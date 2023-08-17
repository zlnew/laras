<script setup lang="ts">
// cores
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useQuasar } from 'quasar'

// utils
import { can, isAdmin, isEditable, isSubmitted } from '@/utils/permissions'
import { multiFilterOptions } from '@/utils/options'
import { fullDate } from '@/utils/date'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import {
  PenagihanItemTable,
  PenagihanSubmissionForm,
  PenagihanApprovalForm
} from '@/Components/Keuangan/detail-penagihan-page'
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue'
import { FilesTable } from '@/Components/Files/files-page'

// types
import type { DetailPenagihan, DetailRAB, File, Penagihan, Proyek, Rekening, Timeline } from '@/types'

export interface FormOptions {
  detailRab: Array<Partial<DetailRAB>>
  rekening: Rekening[]
}

interface JoinedWithPenagihan {
  id_rekening_pg: string
  nama_bank_pg: string
  nomor_rekening_pg: string
  nama_rekening_pg: string
}

const props = defineProps<{
  penagihan: Penagihan & Proyek & JoinedWithPenagihan
  detailPenagihan: DetailPenagihan[]
  dokumenPenunjang: File[]
  formOptions: FormOptions
  timeline: Timeline[]
}>()

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Penagihan/Invoice', url: route('penagihan') },
  { label: props.penagihan.nama_proyek, url: '#' }
]

const tab = ref('uraian')

const $q = useQuasar()
const editable = ref(false)

const rekeningOptionsRef = ref(props.formOptions.rekening)

function rekeningFilter (val: string, update: any) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(
      val, props.formOptions.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening']
    )
  })
}

const form = useForm({
  id_rekening: props.penagihan.id_rekening_pg,
  nomor_sp2d: props.penagihan.nomor_sp2d,
  tanggal_sp2d: props.penagihan.tanggal_sp2d,
  tanggal_terbit: props.penagihan.tanggal_terbit,
  tanggal_cair: props.penagihan.tanggal_cair
})

function save () {
  form.put(route('penagihan.fill', props.penagihan.id_penagihan), {
    onSuccess: (page) => {
      $q.notify({
        type: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })

      editable.value = false
    }
  })
}
</script>

<template>
  <Head title="Penagihan" />
  <layout>

    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :key="breadcrumb.label"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        >
        </q-breadcrumbs-el>
      </q-breadcrumbs>
    </template>

    <module-top-section
      title="Penagihan"
      timeline-title="Timeline Penagihan"
      :data="{
        proyek: penagihan,
        status: penagihan.status_penagihan,
        timeline: timeline
      }"
    />

    <div class="q-px-md q-pt-md">
      <div class="row q-col-gutter-md">
        <div class="col-12 col-md-6">
          <q-card flat bordered>
            <q-card-section>
              <div class="row">
                <div class="col-4 text-caption">
                  Keperluan
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ penagihan.keperluan }}
                </div>

                <div class="col-4 text-caption">
                  Kas Masuk
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ penagihan.kas_masuk }}
                </div>

                <div class="col-4 text-caption">
                  Tanggal Pengajuan
                </div>
                <div class="col-8 text-subtitle2">
                  : {{ fullDate(penagihan.tanggal_pengajuan) || '-' }}
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>

        <div class="col-12 col-md-6">
          <q-card flat bordered>
            <q-card-section>
              <div
                v-if="isAdmin() ? true : can('create & modify penagihan') && isEditable(penagihan)"
                class="text-subtitle2 absolute-top text-right q-pa-sm"
              >
                <q-btn
                  flat
                  dense
                  :label="editable ? 'Save' : 'Edit'"
                  :icon="editable ? 'done' : 'edit_note'"
                  :color="editable ? 'green' : 'secondary'"
                  :disable="!can('create & modify penagihan') && !isEditable(penagihan)"
                  @click="editable ? save() : editable = true"
                >
                  <q-tooltip>{{ editable ? 'Save' : 'Edit' }}</q-tooltip>
                </q-btn>
              </div>

              <div class="text-h6">Info Penagihan</div>
            </q-card-section>

            <q-separator></q-separator>

            <q-card-section>
              <div class="row">
                <div class="col-4 text-caption">
                  Nomor Rekening Tujuan
                </div>
                <div
                  v-if="!editable"
                  class="col-8 text-subtitle2"
                >
                  : {{ penagihan.nama_bank_pg }} | {{ penagihan.nomor_rekening_pg }} - {{ penagihan.nama_rekening_pg }}
                </div>
                <div v-else class="col-8">
                  <q-select
                    flat
                    dense
                    use-input
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

                <div class="col-4 text-caption">
                  Nomor SP2D
                </div>
                <div
                  v-if="!editable"
                  class="col-8 text-subtitle2"
                >
                  : {{ form.nomor_sp2d || '-' }}
                </div>
                <div v-else class="col-8">
                  <q-input
                    flat
                    dense
                    hide-bottom-space
                    v-model="form.nomor_sp2d"
                    :error="form.errors.nomor_sp2d ? true : false"
                    :error-message="form.errors.nomor_sp2d"
                  />
                </div>

                <div class="col-4 text-caption">
                  Tanggal SP2D
                </div>
                <div
                  v-if="!editable"
                  class="col-8 text-subtitle2"
                >
                  : {{ fullDate(form.tanggal_sp2d) || '-' }}
                </div>
                <div v-else class="col-8 text-subtitle2">
                  <q-input
                    flat
                    dense
                    hide-bottom-space
                    type="date"
                    v-model="form.tanggal_sp2d"
                    :error="form.errors.tanggal_sp2d ? true : false"
                    :error-message="form.errors.tanggal_sp2d"
                  />
                </div>

                <div class="col-4 text-caption">
                  Tanggal Terbit
                </div>
                <div
                  v-if="!editable"
                  class="col-8 text-subtitle2"
                >
                  : {{ fullDate(form.tanggal_terbit) || '-' }}
                </div>
                <div v-else class="col-8 text-subtitle2">
                  <q-input
                    flat
                    dense
                    hide-bottom-space
                    type="date"
                    v-model="form.tanggal_terbit"
                    :error="form.errors.tanggal_terbit ? true : false"
                    :error-message="form.errors.tanggal_terbit"
                  />
                </div>

                <div class="col-4 text-caption">
                  Tanggal Cair
                </div>
                <div
                  v-if="!editable"
                  class="col-8 text-subtitle2"
                >
                  : {{ fullDate(form.tanggal_cair) || '-' }}
                </div>
                <div v-else class="col-8 text-subtitle2">
                  <q-input
                    flat
                    dense
                    hide-bottom-space
                    type="date"
                    v-model="form.tanggal_cair"
                    :error="form.errors.tanggal_cair ? true : false"
                    :error-message="form.errors.tanggal_cair"
                  />
                </div>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </div>

    <div class="q-px-md q-pt-md">
      <q-card flat bordered>
        <q-tabs
          v-model="tab"
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="justify"
          narrow-indicator
        >
          <q-tab no-caps name="uraian" label="Uraian" />
          <q-tab no-caps name="dokumen" label="Dokumen Penunjang" />
        </q-tabs>

        <q-separator />

        <q-tab-panels v-model="tab">
          <q-tab-panel class="q-pa-none" name="uraian">
            <penagihan-item-table
              :rows="detailPenagihan"
              :data="{
                penagihan: penagihan,
              }"
              :form-options="formOptions"
            />
          </q-tab-panel>

          <q-tab-panel class="q-pa-none" name="dokumen">
            <files-table
              :rows="dokumenPenunjang"
              :data="{
                model_id: penagihan.id_penagihan,
                permissions: 'create & modify penagihan',
                status_aktivitas: penagihan.status_aktivitas
              }"
            />
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>

    <penagihan-submission-form
      v-if="can('create & modify penagihan') && isEditable(penagihan) && detailPenagihan.length"
      :data="{
        id_penagihan: penagihan.id_penagihan,
      }"
    />

    <penagihan-approval-form
      v-if="can('confirm penagihan') && isSubmitted(penagihan)"
      :data="{
        id_penagihan: penagihan.id_penagihan,
        jumlah_diterima: penagihan.jumlah_diterima
      }"
    />

  </layout>
</template>
