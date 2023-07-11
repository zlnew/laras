<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed, onUpdated } from 'vue';
import { DetailPengajuanDana, Timeline, Keuangan, PencairanDana, DetailPencairanDana } from '@/types';
import { toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';

import CreateModalWindow from './Modals/Create.m.vue';

import InformasiSection from './Partials/Informasi.p.vue';
import TimelineSection from './Partials/Timeline.p.vue';
import PersetujuanSection from './Partials/Persetujuan.p.vue';
import PengajuanSection from './Partials/Pengajuan.p.vue';

const page = usePage();

const role = page.props.role;
const permissions = page.props.permissions;

const props = defineProps<{
  keuangan: Keuangan;
  pencairan_dana: PencairanDana;
  detail_pencairan_dana: Array<DetailPencairanDana>;
  detail_pengajuan_dana: Array<DetailPengajuanDana>;
  timeline: Array<Timeline>;
}>();

const CRUDPermission = computed(() => {
  if (role === 'admin') {
    return true;
  }

  if (
    permissions.includes('create pencairan dana')
    && permissions.includes('update pencairan dana')
    && permissions.includes('delete pencairan dana')
  ) {
    return true;
  }

  return false;
});

const pengajuanPermission = computed(() => {
  const status_aktivitas = props.pencairan_dana.status_aktivitas;

  if (status_aktivitas === 'Dibuat') {
    return true;
  }

  return false;
});

const persetujuanPermission = computed(() => {
  const status_aktivitas = props.pencairan_dana.status_aktivitas;
  
  if (permissions.includes('approve status pencairan dana')) {
    if (role === 'admin') {
      return true;
    }
  
    switch (status_aktivitas) {
      case 'Dibayar': return true;
      default: return false
    }
  }

  return false;
});

const detail_pengajuan_dana = computed(() => {
  return props.detail_pengajuan_dana.map((item) => {
    const jumlah_pengajuan_in_rupiah = toRupiah(item.jumlah_pengajuan);
    return {
      ...item,
      jumlah_pengajuan_in_rupiah: jumlah_pengajuan_in_rupiah,
    }
  });
});

const total_amount = computed(() => {
  const pengajuan_dana = props.detail_pengajuan_dana.reduce((total, detail) => {    
    return total + parseFloat(detail.jumlah_pengajuan.toString());
  }, 0);

  const pencairan_dana = props.detail_pencairan_dana.reduce((total, detail) => {    
    return total + parseFloat(detail.jumlah_pencairan.toString());
  }, 0);

  return {
    pengajuan_dana: toRupiah(pengajuan_dana),
    pencairan_dana: toRupiah(pencairan_dana),
    belum_dibayar: toRupiah(pengajuan_dana - pencairan_dana),
  }
});

function OpenPembayaranModal(
  detail_pengajuan_dana: DetailPengajuanDana,
  jumlah_pencairan: DetailPencairanDana['jumlah_pencairan']
) {
  Modal.pop(CreateModalWindow, {
    id_pencairan_dana: props.pencairan_dana.id_pencairan_dana,
    detail_pengajuan_dana: detail_pengajuan_dana,
    jumlah_pencairan: jumlah_pencairan
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Pencairan Dana" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{
        second: 'Keuangan',
        current: props.keuangan.nama_proyek
      }" />
    </template>

    <ContentLayout>
      <informasi-section
        v-bind="{
          keuangan: keuangan,
          pencairan_dana: pencairan_dana
        }"
      />

      <card-layout>
				<card-header>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl">List Pengajuan Dana</h5>
          </div>
        </card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="#" />
                <t-head-cell value="Uraian" />
                <t-head-cell value="Pos" />
                <t-head-cell value="Jenis Pembayaran" />
                <t-head-cell value="Rekening" />
                <t-head-cell text-align="right" value="Pengajuan" />
                <t-head-cell text-align="center" value="Pembayaran" />
                <t-head-cell text-align="right" value="Belum Dibayar" />
              </t-row>
            </t-head>

            <t-body>
              <t-row
                  v-if="detail_pengajuan_dana.length"
                  v-for="(item, index) in detail_pengajuan_dana"
                  :key="item.id_detail_pengajuan_dana">

                <t-body-cell>
                  {{ index + 1 }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  class="font-semibold text-primary">
                  {{ item.uraian }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  {{ item.uraian_rap }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  {{ item.jenis_pembayaran }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  <span class="text-primary">
                    {{ item.nama_bank }} | {{ item.nomor_rekening }}
                  </span> - {{ item.nama_rekening }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ item.jumlah_pengajuan_in_rupiah }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  <template v-if="CRUDPermission && pengajuanPermission">
                    <ease-button
                      v-if="item.jumlah_pencairan < item.jumlah_pengajuan"
                      @click="OpenPembayaranModal(item, item.jumlah_pencairan)"
                      v-bind="{
                        variant: 'link',
                        text: item.jumlah_pencairan
                          ? toRupiah(item.jumlah_pencairan)
                          : 'Bayar'
                      }"
                    />
                    <ease-button
                      v-else
                      v-bind="{
                        variant: 'transparent',
                        text: toRupiah(item.jumlah_pencairan)
                      }"
                    />
                  </template>
                  <span v-else class="text-primary">
                    {{ toRupiah(item.jumlah_pencairan) }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  <span v-if="item.jumlah_pencairan < item.jumlah_pengajuan">
                    {{ toRupiah(item.jumlah_pengajuan - item.jumlah_pencairan) }}
                  </span>

                  <span v-else>-</span>
                </t-body-cell>

              </t-row>

              <t-row v-else last>
                <t-body-cell
                  colspan="8"
                  text-align="center">
                  Uraian tidak ditemukan
                </t-body-cell>
              </t-row>
            </t-body>

            <t-foot v-if="detail_pengajuan_dana.length">
              <t-row last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  class="font-semibold">
                  Total Pengajuan
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ total_amount.pengajuan_dana }}
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  class="font-semibold">
                  Total Pembayaran
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ total_amount.pencairan_dana }}
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  class="font-semibold">
                  Total Belum Dibayarkan
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ total_amount.belum_dibayar }}
                </t-body-cell>
              </t-row>
            </t-foot>
          </table-layout>
        </card-body>
      </card-layout>

      <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2">
          <timeline-section v-bind="{
            timeline: timeline
          }" />
        </div>

        <pengajuan-section
          v-if="CRUDPermission && pengajuanPermission"
          v-bind="{
            id_pencairan_dana: pencairan_dana.id_pencairan_dana,
          }"
        />

        <persetujuan-section
          v-if="persetujuanPermission"
          v-bind="{
            id_pencairan_dana: pencairan_dana.id_pencairan_dana,
          }"
        />
      </div>
    </ContentLayout>
  </authenticated-layout>
</template>