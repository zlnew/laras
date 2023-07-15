<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';

import { computed, onUpdated } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { DetailRAP, RAP, Satuan, Timeline } from '@/types';

import { toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';

import CreateModalWindow from './Modals/Create.m.vue';
import EditModalWindow from './Modals/Edit.m.vue';
import DeleteModalWindow from './Modals/Delete.m.vue';

import InformasiSection from './Partials/Informasi.p.vue';
import TimelineSection from './Partials/Timeline.p.vue';
import PengajuanSection from './Partials/Pengajuan.p.vue';
import PersetujuanSection from './Partials/Persetujuan.p.vue';

const page = usePage();

const role = page.props.role;
const permissions = page.props.permissions;

const props = defineProps<{
  rap: RAP,
  detail_rap: Array<DetailRAP>;
  satuan: Array<Satuan>;
  timeline: Array<Timeline>;
}>();

const rap = computed(() => {
  const status_rap_in_string = props.rap.status_rap == 400
      ? 'Closed'
      : 'On Progress';

  return {
    ...props.rap,
    status_rap_in_string: status_rap_in_string
  };
});

const detail_rap = computed(() => {
  return props.detail_rap.map(item => {
    const harga_satuan_in_rupiah = toRupiah(item.harga_satuan);
    const total_harga_in_rupiah = toRupiah(item.harga_satuan * item.volume);

    return {
      ...item,
      harga_satuan_in_rupiah: harga_satuan_in_rupiah,
      total_harga_in_rupiah: total_harga_in_rupiah,
    }
  });
});

const total_amount = computed(() => {
  const rap = props.detail_rap.reduce((total, item) => {    
    return total + (parseFloat(item.harga_satuan.toString()) * parseFloat(item.volume.toString()));
  }, 0);

  return { rap: toRupiah(rap) };
});

const CRUDPermission = computed(() => {
  if (role === 'admin') {
    return true;
  }

  if (
    permissions.includes('create rap')
    && permissions.includes('update rap')
    && permissions.includes('delete rap')
  ) {
    return true;
  }

  return false;
});

const pengajuanPersmission = computed(() => {
  if (props.rap.status_aktivitas === 'Dibuat'
  ) {
    return true;
  }

  return false;
});

const persetujuanPersmission = computed(() => {
  if (permissions.includes('approve rap')) {
    if (role === 'admin') {
      return true;
    }

    if (role === 'kepala divisi' && props.rap.status_aktivitas === 'Diajukan') {
      return true;
    }

    if (role === 'direktur utama' && props.rap.status_aktivitas === 'Diperiksa') {
      return true;
    }
  }

  return false;
});

function OpenCreateModal() {
  Modal.pop(CreateModalWindow, {
    id_rap: props.rap.id_rap,
    satuan: props.satuan,
  });
}

function OpenUpdateModal(detail_rap: DetailRAP) {
  Modal.pop(EditModalWindow, {
    detail_rap: detail_rap,
    satuan: props.satuan,
  });
}

function OpenDeleteModal(id_detail_rap: DetailRAP['id_detail_rap']) {
  Modal.pop(DeleteModalWindow, {
    id_detail_rap: id_detail_rap
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Detail RAP" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'RAP',
          current: props.rap.nama_proyek + ' - ' + props.rap.tahun_anggaran
        }"
      />
    </template>

    <content-layout>
      <informasi-section
        v-bind="{
          rap: rap
        }"
      />

      <card-layout>
				<card-header>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl text-dark">Uraian Rencana Anggaran Proyek</h5>
            <ease-button
              v-if="CRUDPermission && pengajuanPersmission"
              @click="OpenCreateModal"
              slotted>
              <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Tambah Uraian
            </ease-button>
          </div>
        </card-header>
        
        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="#" />
                <t-head-cell value="Uraian" />
                <t-head-cell value="Satuan" />
                <t-head-cell text-align="right" value="Harga" />
                <t-head-cell text-align="center" value="Volume" />
                <t-head-cell text-align="right" value="Total Harga" />
                <t-head-cell value="Status" />
                <t-head-cell value="Keterangan" />
                <t-head-cell v-if="CRUDPermission && pengajuanPersmission" />
              </t-row>
            </t-head>

            <t-body>
              <t-row
                v-if="detail_rap.length"
                v-for="(item, index) in detail_rap" :key="item.id_detail_rap">

                <t-body-cell>
                  {{ index + 1 }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  class="font-semibold text-dark">
                  {{ item.uraian }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  {{ item.nama_satuan }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ item.harga_satuan_in_rupiah }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  {{ item.volume }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ item.total_harga_in_rupiah }}
                </t-body-cell>

                <t-body-cell
                  whitespace="normal">
                  {{ item.status_uraian }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="normal">
                  {{ item.keterangan }}
                </t-body-cell>
                
                <t-body-cell
                  v-if="CRUDPermission && pengajuanPersmission"
                  whitespace="nowrap">
                  <div class="flex">
                    <EaseButton
                      @click="OpenUpdateModal(item)"
                      variant="link"
                      text="Edit"
                    />
                    <EaseButton
                      @click="OpenDeleteModal(item.id_detail_rap)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>
                <t-body-cell
                  colspan="9"
                  textAlign="center">
                  Uraian tidak ditemukan
                </t-body-cell>
              </t-row>
            </t-body>

            <t-foot v-if="detail_rap.length">
              <t-row last>
                <t-body-cell
                  text-align="right"
                  colspan="5"
                  class="font-semibold">
                  Total RAP
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  colspan="1"
                  class="font-semibold">
                  {{ total_amount.rap }}
                </t-body-cell>
              </t-row>
            </t-foot>
          </table-layout>
        </card-body>
      </card-layout>

      <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2">
          <timeline-section
            v-bind="{
              timeline: timeline
            }"
          />
        </div>

        <pengajuan-section
          v-if="CRUDPermission && pengajuanPersmission"
          v-bind="{
            id_rap: rap.id_rap,
            uraian_length: detail_rap.length
          }"
        />

        <persetujuan-section
          v-if="persetujuanPersmission"
          v-bind="{
            id_rap: rap.id_rap,
          }"
        />
      </div>
    </content-layout>
  </authenticated-layout>
</template>