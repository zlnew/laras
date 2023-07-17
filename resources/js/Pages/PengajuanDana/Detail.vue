<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed, onUpdated } from 'vue';
import { DetailPengajuanDana, DetailRAP, PengajuanDana, Timeline, Keuangan, Rekening } from '@/types';
import { fromRupiah, toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';
import { ref } from 'vue';

import CreateModalWindow from './Modals/Create.m.vue';
import UpdateModalWindow from './Modals/Update.m.vue';
import DeleteModalWindow from './Modals/Delete.m.vue';

import InformasiSection from './Partials/Informasi.p.vue';
import TimelineSection from './Partials/Timeline.p.vue';
import PersetujuanSection from './Partials/Persetujuan.p.vue';
import PengajuanSection from './Partials/Pengajuan.p.vue';

const page = usePage();

const role = page.props.role;
const permissions = page.props.permissions;

const props = defineProps<{
  keuangan: Keuangan;
  detail_pengajuan_dana: Array<DetailPengajuanDana>;
  pengajuan_dana: PengajuanDana;
  detail_rap: Array<DetailRAP>;
  timeline: Array<Timeline>;
  rekening: Array<Rekening>;
}>();

const CRUDPermission = computed(() => {
  if (role === 'admin') {
    return true;
  }

  if (
    permissions.includes('create pengajuan dana')
    && permissions.includes('update pengajuan dana')
    && permissions.includes('delete pengajuan dana')
  ) {
    return true;
  }

  return false;
});

const pengajuanPermission = computed(() => {
  const status_aktivitas = props.pengajuan_dana.status_aktivitas;

  if (status_aktivitas === 'Dibuat') {
    return true;
  }

  return false;
});

const persetujuanPermission = computed(() => {
  const status_aktivitas = props.pengajuan_dana.status_aktivitas;
  
  if (permissions.includes('approve pengajuan dana')) {
    if (role === 'admin') {
      switch (status_aktivitas) {
        case 'Diajukan': return true;
        case 'Dievaluasi': return true;
        default: return false
      }
    }
  
    if (role === 'kepala divisi') {
      switch (status_aktivitas) {
        case 'Diajukan': return true;
        default: return false
      }
    }
  
    if (role === 'direktur utama') {
      switch (status_aktivitas) {
        case 'Dievaluasi': return true;
        default: return false
      }
    }
  }

  return false;
});

const detail_pengajuan_dana = computed(() => {
  return props.detail_pengajuan_dana.map((detail) => {
    const jumlah_pengajuan_in_rupiah = toRupiah(detail.jumlah_pengajuan);
    return {
      ...detail,
      jumlah_pengajuan_in_rupiah: jumlah_pengajuan_in_rupiah,
    }
  });
});

export interface TotalAmountPengajuanDana {
  pengajuan_dana: string | undefined;
  disetujui: string | undefined;
  ditolak: string | undefined;
}

const total_amount = computed<TotalAmountPengajuanDana>(() => {
  const pengajuan_dana = props.detail_pengajuan_dana.reduce((total, detail) => {    
    return total + parseFloat(detail.jumlah_pengajuan.toString());
  }, 0);

  return {
    pengajuan_dana: toRupiah(pengajuan_dana),
    disetujui: toRupiah(total_disetujui.value),
    ditolak: toRupiah(total_ditolak.value),
  }
});

const group_of_checked_id = ref<Array<DetailPengajuanDana['id_detail_pengajuan_dana']>>();
const total_disetujui = ref<number>(0);
const total_ditolak = ref<number>(0);

function checkAll(event: Event) {
  const checkAll = event.target as HTMLInputElement;
  const checkboxes = document.querySelectorAll('.persetujuan-checkbox');
  
  checkboxes.forEach(checkbox => {
    if (checkbox instanceof HTMLInputElement) {
      checkbox.checked = checkAll.checked;
    }
  });

  sumTotal();
}

function sumTotal() {
  pushCheckedIDs();
  sumTotalDisetujui();
  sumTotalDitolak();
}

function pushCheckedIDs() {
  const checkboxes = document.querySelectorAll('.persetujuan-checkbox');
  let checked_id: number[] = [];

  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked && checkbox.dataset.id) {
      checked_id.push(parseFloat(checkbox.dataset.id));
    }
  });

  group_of_checked_id.value = checked_id;
}

function sumTotalDisetujui() {
  const checkboxes = document.querySelectorAll('.persetujuan-checkbox');
  let total_disetujui_amount = 0;

  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked) {
      const amount = parseFloat(checkbox.dataset.amount || '0');
      total_disetujui_amount += amount;
    }
  });

  total_disetujui.value = total_disetujui_amount;
}

function sumTotalDitolak() {
  const checkboxes = document.querySelectorAll('.persetujuan-checkbox');
  const total_pengajuan = fromRupiah(total_amount.value.pengajuan_dana || '0');
  let total_ditolak_amount = 0;

  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked) {
      const amount = parseFloat(checkbox.dataset.amount || '0');
      total_ditolak_amount += amount;
    }
  });
  
  if (total_pengajuan) {
    total_ditolak.value = total_pengajuan - total_ditolak_amount;
  }
}

function OpenCreateModal() {
  Modal.pop(CreateModalWindow, {
    id_pengajuan_dana: props.pengajuan_dana.id_pengajuan_dana,
    detail_rap: props.detail_rap,
    rekening: props.rekening
  });
}

function OpenUpdateModal(detail_pengajuan_dana: DetailPengajuanDana) {
  Modal.pop(UpdateModalWindow, {
    detail_pengajuan_dana: detail_pengajuan_dana,
    detail_rap: props.detail_rap,
    rekening: props.rekening
  });
}

function OpenDeleteModal(id_detail_pengajuan_dana: DetailPengajuanDana['id_detail_pengajuan_dana']) {
  Modal.pop(DeleteModalWindow, {
    id_detail_pengajuan_dana: id_detail_pengajuan_dana
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Pengajuan Dana" />

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
          pengajuan_dana: pengajuan_dana
        }"
      />

      <card-layout>
				<card-header>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl text-dark">List Pengajuan Dana</h5>
            <ease-button
              v-if="CRUDPermission && pengajuanPermission"
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
                <t-head-cell value="Pos" />
                <t-head-cell value="Jenis Pembayaran" />
                <t-head-cell value="Rekening" />
                <t-head-cell value="Bank" />
                <t-head-cell text-align="right" value="Jumlah Pengajuan" />
                <t-head-cell v-if="persetujuanPermission" value="Persetujuan" />
                <t-head-cell v-if="CRUDPermission && pengajuanPermission" />
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
                  class="font-semibold text-dark">
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
                  {{ item.nomor_rekening }} - {{ item.nama_rekening }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">{{ item.nama_bank }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ item.jumlah_pengajuan_in_rupiah }}
                </t-body-cell>
                
                <t-body-cell
                  v-if="persetujuanPermission">
                  <input
                    @change="sumTotal"
                    v-bind="{
                    type: 'checkbox',
                    class: 'persetujuan-checkbox',
                    'data-id': item.id_detail_pengajuan_dana,
                    'data-amount': item.jumlah_pengajuan
                    }"
                  />
                </t-body-cell>

                <t-body-cell
                  v-if="CRUDPermission && pengajuanPermission"
                  whitespace="nowrap">
                  <div class="flex">
                    <ease-button
                      variant="link"
                      text="Edit"
                      @click="OpenUpdateModal(item)"
                    />
                    <ease-button
                      variant="danger-link"
                      text="Delete"
                      @click="OpenDeleteModal(item.id_detail_pengajuan_dana)"
                    />
                  </div>
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
              <t-row
                v-if="persetujuanPermission"
                last>
                <t-body-cell colspan="6"></t-body-cell>
                
                <t-body-cell
                  text-align="right">
                  Setujui Semua
                </t-body-cell>
                
                <t-body-cell>
                  <input
                    @change="checkAll($event)"
                    type="checkbox"
                    title="Setujui semua"
                  />
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell colspan="5"></t-body-cell>
                
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

              <t-row
                v-if="persetujuanPermission"
                last>
                <t-body-cell colspan="5"></t-body-cell>
                
                <t-body-cell
                  class="font-semibold">
                  Disetujui
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ total_amount.disetujui }}
                </t-body-cell>
              </t-row>

              <t-row
                v-if="persetujuanPermission"
                last>
                <t-body-cell colspan="5"></t-body-cell>
                
                <t-body-cell
                  class="font-semibold">
                  Tidak Disetujui
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ total_amount.ditolak }}
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
            id_pengajuan_dana: pengajuan_dana.id_pengajuan_dana,
            detail_pengajuan_dana_length: detail_pengajuan_dana.length
          }"
        />

        <persetujuan-section
          v-if="persetujuanPermission"
          v-bind="{
            id_pengajuan_dana: pengajuan_dana.id_pengajuan_dana,
            group_of_id_detail_pengajuan_dana: group_of_checked_id,
            total_amount: total_amount,
          }"
        />
      </div>
    </ContentLayout>
  </authenticated-layout>
</template>