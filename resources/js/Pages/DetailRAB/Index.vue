<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { FormInput } from '@/Components/Form.vue';

import { computed, onUpdated } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { DetailRAB, RAB, Satuan, Timeline } from '@/types';

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

const role = computed(() => page.props.role);
const permissions = computed(() => page.props.permissions);

const props = defineProps<{
  rab: RAB,
  detail_rab: Array<DetailRAB>;
  satuan: Array<Satuan>;
  timeline: Array<Timeline>;
}>();

const rab = computed(() => {
  const status_rab_in_string = props.rab.status_rab == 400
      ? 'Closed'
      : 'On Progress';

  return {
    ...props.rab,
    status_rab_in_string: status_rab_in_string
  };
});

const detail_rab = computed(() => {
  return props.detail_rab.map(item => {
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
  const rab = props.detail_rab.reduce((total, item) => {    
    return total + (parseFloat(item.harga_satuan.toString()) * parseFloat(item.volume.toString()));
  }, 0);
  
  const tax = (props.rab.tax / 100) * rab;
  const additionalTax = (props.rab.additional_tax / 100) * rab;
  const RABWithTax = rab + tax + additionalTax;

  return {
    rab: toRupiah(rab),
    tax: toRupiah(tax),
    additional_tax: toRupiah(additionalTax),
    rab_with_tax: toRupiah(RABWithTax),
  }
});

const CRUDPermission = computed(() => {
  if (role.value === 'admin') {
    return true;
  }

  if (
    permissions.value.includes('create rab')
    && permissions.value.includes('update rab')
    && permissions.value.includes('delete rab')
  ) {
    return true;
  }

  return false;
});

const pengajuanPersmission = computed(() => {  
  if (props.rab.status_aktivitas === 'Dibuat') {
    return true;
  }

  return false;
});

const persetujuanPersmission = computed(() => {
  if (
    permissions.value.includes('approve rab')
    && props.rab.status_aktivitas === 'Diajukan'
  ) {
    return true;
  }

  return false;
});

const taxForm = useForm({
  tax: props.rab.tax,
  additional_tax: props.rab.additional_tax
});

function updateTax() {
  taxForm.patch(route('rab.update_tax', props.rab.id_rab));
}

function OpenCreateModal() {
  Modal.pop(CreateModalWindow, {
    id_rab: props.rab.id_rab,
    satuan: props.satuan,
  });
}

function OpenUpdateModal(detail_rab: DetailRAB) {
  Modal.pop(EditModalWindow, {
    detail_rab: detail_rab,
    satuan: props.satuan,
  });
}

function OpenDeleteModal(id_detail_rab: DetailRAB['id_detail_rab']) {
  Modal.pop(DeleteModalWindow, {
    id_detail_rab: id_detail_rab
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Detail RAB" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'RAB',
          current: props.rab.nama_proyek + ' - ' + props.rab.tahun_anggaran
        }"
      />
    </template>

    <content-layout>
      <informasi-section
        v-bind="{
          rab: rab
        }"
      />

      <card-layout>
				<card-header>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl text-dark">Uraian Rencana Anggaran Biaya</h5>
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
                <t-head-cell value="Keterangan" />
                <t-head-cell v-if="CRUDPermission && pengajuanPersmission" />
              </t-row>
            </t-head>

            <t-body>
              <t-row
                v-if="detail_rab.length"
                v-for="(item, index) in detail_rab" :key="item.id_detail_rab">

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
                      @click="OpenDeleteModal(item.id_detail_rab)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>
                <t-body-cell
                  colspan="8"
                  textAlign="center">
                  Uraian tidak ditemukan
                </t-body-cell>
              </t-row>
            </t-body>

            <t-foot v-if="detail_rab.length">
              <t-row last>
                <t-body-cell
                  text-align="right"
                  colspan="5"
                  class="font-semibold">
                  PPN
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  colspan="1"
                  class="font-semibold">
                  <FormInput v-model="taxForm.tax"
                    v-if="CRUDPermission"
                    @input="updateTax"
                    type="number"
                    min="0"
                    max="100"
                  />
                  <span v-else>{{ taxForm.tax }}%</span>
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell
                  text-align="right"
                  colspan="5"
                  class="font-semibold">
                  Additional Tax
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  colspan="1"
                  class="font-semibold">
                  <FormInput v-model="taxForm.additional_tax"
                    v-if="CRUDPermission"
                    @input="updateTax"
                    type="number"
                    min="0"
                    max="100"
                  />
                  <span v-else>{{ taxForm.additional_tax }}%</span>
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell
                  text-align="right"
                  colspan="5"
                  class="font-semibold">
                  Total RAB
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  colspan="1"
                  class="font-semibold">
                  {{ total_amount.rab }}
                </t-body-cell>
              </t-row>

              <t-row last>
                <t-body-cell
                  text-align="right"
                  colspan="5"
                  class="font-semibold">
                  Total RAB (Termasuk PPN)
                </t-body-cell>
                
                <t-body-cell
                  text-align="right"
                  colspan="1"
                  class="font-semibold">
                  {{ total_amount.rab_with_tax }}
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
            id_rab: rab.id_rab,
            uraian_length: detail_rab.length
          }"
        />

        <persetujuan-section
          v-if="persetujuanPersmission"
          v-bind="{
            id_rab: rab.id_rab,
          }"
        />
      </div>
    </content-layout>
  </authenticated-layout>
</template>