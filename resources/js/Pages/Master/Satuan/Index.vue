<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from "@/Components/Card.vue";
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { FormInput } from '@/Components/Form.vue';

import { Toast } from "@/utilities/toastify";

import { onUpdated } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Satuan } from '@/types';
import { Modal } from '@/utilities/modal';

import CreateModal from './Modals/CreateModal.vue';
import EditModal from './Modals/EditModal.vue';
import DeleteModal from './Modals/DeleteModal.vue';

const page = usePage();

const queryParams = page.props.query as Satuan;

defineProps<{
  satuan: {
    data: Array<Satuan>,
  },
}>();

const search = useForm({
  nama_satuan: queryParams.nama_satuan
});

function searchSatuan() {
  search.get(route('satuan'));
}

function createSatuan() {
  Modal.pop(CreateModal);
}

function updateSatuan(satuan: Satuan) {
  Modal.pop(EditModal, {
    satuan: satuan,
  });
}

function deleteSatuan(id_satuan: Satuan['id_satuan']) {
  Modal.pop(DeleteModal, {
    id_satuan: id_satuan,
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Satuan" />
  
  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Master',
          current: 'Satuan'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
        <card-header class="mb-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <ease-button
                @click="createSatuan"
                slotted>
              <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Tambah Satuan
            </ease-button>
            </div>
            <form @submit.prevent="searchSatuan">
              <div class="flex justify-between items-center space-x-2">
                <form-input v-model="search.nama_satuan"
                  v-bind="{
                    type: 'search',
                    size: 'lg',
                    placeholder: 'Cari Berdasarkan Nama Satuan',
                    autocomplete: 'off',
                  }"
                />
                <ease-button
                  v-bind="{
                    type: 'submit',
                    text: 'Cari',
                    loading: search.processing,
                    onLoading: () => ({
                      text: false,
                    })
                  }"
                />
              </div>
            </form>
          </div>
        </card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="Nama Satuan" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="satuan.data.length"
                v-for="(item, index) in satuan.data" :key="item.id"
                v-bind="{ last: index === satuan.data.length - 1 }">

                <t-body-cell
                  whitespace="nowrap"
                  class="font-semibold text-primary">
                  {{ item.nama_satuan }}
                </t-body-cell>

                <t-body-cell
                  text-align="right"
                  whitespace="nowrap">
                  <div class="flex justify-end">
                    <ease-button
                      @click="updateSatuan(item)"
                      variant="link"
                      text="Edit"
                    />
                    <ease-button
                      @click="deleteSatuan(item.id_satuan)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>

                <t-body-cell
                  colspan="2"
                  text-align="center">
                  Satuan tidak ditemukan
                </t-body-cell>

              </t-row>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>