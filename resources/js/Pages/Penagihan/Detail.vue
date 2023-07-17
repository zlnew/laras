<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed, onUpdated } from 'vue';
import { Timeline, Keuangan, DetailPenagihan, Penagihan, DetailRAB } from '@/types';
import { fromRupiah, toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';
import { ref } from 'vue';

import CreateModalWindow from './Modals/CreateModal.vue';
import EditModalWindow from './Modals/EditModal.vue';
import DeleteModalWindow from './Modals/DeleteModal.vue';

import InformasiSection from './Partials/InformasiPartial.vue';
import TimelineSection from './Partials/TimelinePartial.vue';
import VerifikasiSection from './Partials/VerifikasiPartial.vue';
import PengajuanSection from './Partials/PengajuanPartial.vue';

const page = usePage();

const role = page.props.role;
const permissions = page.props.permissions;

const props = defineProps<{
  keuangan: Keuangan;
  detail_penagihan: Array<DetailPenagihan>;
  penagihan: Penagihan;
  detail_rab: Array<DetailRAB>;
  timeline: Array<Timeline>;
}>();

const CRUDPermission = computed(() => {
  if (role === 'admin') {
    return true;
  }

  if (
    permissions.includes('create penagihan')
    && permissions.includes('update penagihan')
    && permissions.includes('delete penagihan')
  ) {
    return true;
  }

  return false;
});

const pengajuanPermission = computed(() => {
  const status_aktivitas = props.penagihan.status_aktivitas;

  if (status_aktivitas === 'Dibuat') {
    return true;
  }

  return false;
});

const verifikasiPermission = computed(() => {
  const status_aktivitas = props.penagihan.status_aktivitas;
  
  if (permissions.includes('approve pengajuan dana')) {
    switch (status_aktivitas) {
      case 'Diajukan': return true;
      default: return false
    }
  }

  return false;
});

const detail_penagihan = computed(() => {
  return props.detail_penagihan.map((item) => {
    return { ...item }
  });
});

export interface TotalAmountPenagihan {
  penagihan: number;
  diterima: number;
  belum_ditagihkan: number;
}

const total_amount = computed<TotalAmountPenagihan>(() => {
  const penagihan = props.detail_penagihan.reduce((total, detail) => {    
    return total + (detail.harga_satuan * detail.volume_penagihan);
  }, 0);

  const diterima = props.detail_penagihan.reduce((total, detail) => {
    if (detail.status_diterima === '400') {
      return total + (detail.harga_satuan * detail.volume_penagihan);
    }

    return total;
  }, 0);

  const belum_ditagihkan = props.detail_penagihan.reduce((total, detail) => {
    if (detail.status_diterima === '100') {
      return total + (detail.harga_satuan * detail.volume_penagihan);
    }

    return total;
  }, 0);

  return {
    penagihan: penagihan,
    diterima: diterima + total_diterima.value,
    belum_ditagihkan: belum_ditagihkan - total_belum_ditagihkan.value,
  }
});

const group_of_checked_id = ref<Array<DetailPenagihan['id_detail_penagihan']>>();
const total_diterima = ref<number>(0);
const total_belum_ditagihkan = ref<number>(0);

function checkAll(event: Event) {
  const checkAll = event.target as HTMLInputElement;
  const checkboxes = document.querySelectorAll('.verifikasi-checkbox');
  
  checkboxes.forEach(checkbox => {
    if (checkbox instanceof HTMLInputElement) {
      checkbox.checked = checkAll.checked;
    }
  });

  sumTotal();
}

function sumTotal() {
  pushCheckedIDs();
  sumTotalDiterima();
  sumTotalBelumDitagihkan();
}

function pushCheckedIDs() {
  const checkboxes = document.querySelectorAll('.verifikasi-checkbox');
  let checked_id: number[] = [];

  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked && checkbox.dataset.id) {
      checked_id.push(parseFloat(checkbox.dataset.id));
    }
  });

  group_of_checked_id.value = checked_id;
}

function sumTotalDiterima() {
  const checkboxes = document.querySelectorAll('.verifikasi-checkbox');
  let total_amount = 0;
  
  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked) {
      const amount = parseFloat(checkbox.dataset.amount || '0');
      total_amount += amount;
    }
  });

  total_diterima.value = total_amount
}

function sumTotalBelumDitagihkan() {
  const checkboxes = document.querySelectorAll('.verifikasi-checkbox');
  let total_amount = 0;

  checkboxes.forEach((checkbox) => {
    if (checkbox instanceof HTMLInputElement && checkbox.checked) {
      const amount = parseFloat(checkbox.dataset.amount || '0');
      total_amount += amount;
    }
  });
  
  total_belum_ditagihkan.value = total_amount;
}

function createPenagihan() {
  Modal.pop(CreateModalWindow, {
    id_penagihan: props.penagihan.id_penagihan,
    detail_rab: props.detail_rab,
  });
}

function editPenagihan(detail_penagihan: DetailPenagihan) {
  Modal.pop(EditModalWindow, {
    detail_penagihan: detail_penagihan,
    detail_rab: props.detail_rab,
  });
}

function deletePenagihan(id_detail_penagihan: DetailPenagihan['id_detail_penagihan']) {
  Modal.pop(DeleteModalWindow, {
    id_detail_penagihan: id_detail_penagihan
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Penagihan / Invoice" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{
        second: 'Penagihan',
        current: props.keuangan.nama_proyek
      }" />
    </template>

    <ContentLayout>
      <informasi-section
        v-bind="{
          keuangan: keuangan,
          penagihan: penagihan
        }"
      />

      <card-layout>
				<card-header class="mb-4">
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl text-dark">List Penagihan</h5>
            <ease-button
              v-if="CRUDPermission && pengajuanPermission"
              @click="createPenagihan"
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
                <t-head-cell value="Volume" />
                <t-head-cell value="Satuan" />
                <t-head-cell text-align="right" value="Harga Satuan" />
                <t-head-cell text-align="right" value="Jumlah Penagihan" />
                <t-head-cell v-if="verifikasiPermission" value="Verifikasi" />
                <t-head-cell v-if="CRUDPermission && pengajuanPermission" />
              </t-row>
            </t-head>

            <t-body>
              <t-row
                  v-if="detail_penagihan.length"
                  v-for="(item, index) in detail_penagihan"
                  :key="item.id_detail_penagihan">

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
                  {{ item.volume_penagihan }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ item.nama_satuan }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ toRupiah(item.harga_satuan) }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                  {{ toRupiah(item.volume_penagihan * item.harga_satuan) }}
                </t-body-cell>
                
                <t-body-cell
                  v-if="verifikasiPermission">
                  <input
                    v-if="item.status_diterima === '100'"
                    @change="sumTotal"
                    v-bind="{
                      type: 'checkbox',
                      class: 'verifikasi-checkbox',
                      'data-id': item.id_detail_penagihan,
                      'data-amount': item.volume_penagihan * item.harga_satuan
                    }"
                  />
                  <input
                    v-else
                    v-bind="{
                      type: 'checkbox',
                      checked: true,
                      disabled: true
                    }"
                  />
                </t-body-cell>

                <t-body-cell
                  v-if="CRUDPermission && pengajuanPermission"
                  whitespace="nowrap">
                  <div v-if="item.status_diterima === '100'" class="flex">
                    <ease-button
                      variant="link"
                      text="Edit"
                      @click="editPenagihan(item)"
                    />
                    <ease-button
                      variant="danger-link"
                      text="Delete"
                      @click="deletePenagihan(item.id_detail_penagihan)"
                    />
                  </div>
                  <div v-else>
                    <ease-button
                      variant="transparent"
                      text="Diterima"
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

            <t-foot v-if="detail_penagihan.length">
              <t-row
                v-if="verifikasiPermission"
                last>
                <t-body-cell colspan="5"></t-body-cell>
                
                <t-body-cell
                  text-align="right">
                  Verifikasi Semua
                </t-body-cell>
                
                <t-body-cell>
                  <input
                    @change="checkAll($event)"
                    type="checkbox"
                    title="Verifikasi semua"
                  />
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  Total Penagihan
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ toRupiah(total_amount.penagihan) }}
                </t-body-cell>
              </t-row>

              <t-row
                last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  Total Diterima
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ toRupiah(total_amount.diterima) }}
                </t-body-cell>
              </t-row>

              <t-row
                last>
                <t-body-cell colspan="4"></t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  Sisa Belum Ditagihkan
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  class="font-semibold">
                  {{ toRupiah(total_amount.belum_ditagihkan) }}
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
            id_penagihan: penagihan.id_penagihan,
            detail_penagihan_length: detail_penagihan.length
          }"
        />

        <verifikasi-section
          v-if="verifikasiPermission"
          v-bind="{
            id_penagihan: penagihan.id_penagihan,
            group_of_id_detail_penagihan: group_of_checked_id,
            total_amount: total_amount,
          }"
        />
      </div>
    </ContentLayout>
  </authenticated-layout>
</template>