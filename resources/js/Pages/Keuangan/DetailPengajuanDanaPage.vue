<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// utils
import { can, isEditable, isEvaluated, isSubmitted } from '@/utils/permissions';
import { fullDate } from '@/utils/date';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import {
  PengajuanDanaItemTable,
  PengajuanDanaSubmissionForm,
  PengajuanDanaApprovalForm,
  PengajuanDanaEvaluateForm
} from '@/Components/Keuangan/detail-pengajuan-dana-page';
import ModuleTopSection from '@/Components/Sections/ModuleTopSection.vue';
import { FilesTable } from '@/Components/Files/files-page';

// types
import { DetailPengajuanDana, DetailRAP, File, PengajuanDana, Proyek, Rekening, Timeline } from '@/types';
import { ApprovedPengajuanSaatIni } from '@/Components/Keuangan/PengajuanDana/PengajuanDanaItem/PengajuanDanaItemTable.vue';

export interface FormOptions {
  detailRap: Array<Partial<DetailRAP>>;
  rekening: Array<Partial<Rekening>>;
}

export interface Evaluasi {
  id_detail_rap: number;
  id_proyek: string;
  uraian: string;
  nama_satuan: string;
  harga_satuan: string;
  volume: number;
  total_harga: number;
} 

const props = defineProps<{
  pengajuanDana: PengajuanDana & Proyek;
  detailPengajuanDana: Array<DetailPengajuanDana>;
  dokumenPenunjang: Array<File>;
  evaluasi: Array<Evaluasi>;
  formOptions: FormOptions;
  timeline: Array<Timeline>;
}>();

const breadcrumbs = [
  { label: 'Keuangan', url: '#' },
  { label: 'Pengajuan Dana', url: route('pengajuan_dana') },
  { label: props.pengajuanDana.nama_proyek, url: '#' },
];

const tab = ref('uraian');

const table = ref<{
  selectedIds: Array<DetailPengajuanDana['id_detail_pengajuan_dana']>;
  approvedPengajuanSaatIni: Array<ApprovedPengajuanSaatIni>;
}>();
</script>

<template>
  <Head title="RAPP" />
  <layout>
    
    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        >
        </q-breadcrumbs-el>
      </q-breadcrumbs>
    </template>

    <module-top-section
      title="Pengajuan Dana"
      timeline-title="Timeline Pengajuan Dana"
      :data="{
        proyek: pengajuanDana,
        status: pengajuanDana.status_pengajuan,
        timeline: timeline
      }"
    />

    <div class="q-px-md q-pt-md">
      <q-card flat bordered style="max-width: 500px">
        <q-card-section>
          <div class="row">
            <div class="col-4 text-caption">
              Keperluan
            </div>
            <div class="col-8 text-subtitle2">
              : {{ pengajuanDana.keperluan }}
            </div>

            <div class="col-4 text-caption">
              Tanggal Pengajuan
            </div>
            <div class="col-8 text-subtitle2">
              : {{ fullDate(pengajuanDana.tanggal_pengajuan) || '-' }}
            </div>
          </div>
        </q-card-section>
      </q-card>
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
            <pengajuan-dana-item-table
              ref="table"
              :rows="detailPengajuanDana"
              :data="{
                pengajuanDana: pengajuanDana,
              }"
              :form-options="formOptions"
            />
          </q-tab-panel>
    
          <q-tab-panel class="q-pa-none" name="dokumen">
            <files-table
              :rows="dokumenPenunjang"
              :data="{
                model_id: pengajuanDana.id_pengajuan_dana,
                permissions: 'create & modify pengajuan dana',
                status_aktivitas: pengajuanDana.status_aktivitas
              }"
            />
          </q-tab-panel>
        </q-tab-panels>
      </q-card>
    </div>

    <pengajuan-dana-submission-form
      v-if="can('create & modify pengajuan dana') && isEditable(pengajuanDana) && detailPengajuanDana.length"
      :data="{
        id_pengajuan_dana: pengajuanDana.id_pengajuan_dana,
      }"
    />

    <pengajuan-dana-evaluate-form
      v-if="can('evaluate pengajuan dana') && isSubmitted(pengajuanDana)"
      :data="{
        evaluasi: evaluasi,
        approvedPengajuanSaatIni: table?.approvedPengajuanSaatIni,
        id_pengajuan_dana: pengajuanDana.id_pengajuan_dana,
        selected_ids_detail_pengajuan_dana: table?.selectedIds
      }"
    />

    <pengajuan-dana-approval-form
      v-if="can('approve pengajuan dana') && isEvaluated(pengajuanDana)"
      :data="{
        id_pengajuan_dana: pengajuanDana.id_pengajuan_dana,
        selected_ids_detail_pengajuan_dana: table?.selectedIds
      }"
    />

  </layout>
</template>