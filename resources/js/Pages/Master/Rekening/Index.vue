<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from "@/Components/Card.vue";
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';

import { Toast } from "@/utilities/toastify";

import { onUpdated } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Rekening } from '@/types';
import { Modal } from '@/utilities/modal';

import SearchModal from './Modals/SearchModal.vue';
import CreateModal from './Modals/CreateModal.vue';
import EditModal from './Modals/EditModal.vue';
import DeleteModal from './Modals/DeleteModal.vue';

const page = usePage();

const props = defineProps<{
  rekening: {
    data: Array<Rekening>,
  },
  banks: Array<Partial<Rekening>>;
}>();

function searchRekening() {
  Modal.pop(SearchModal, {
    banks: props.banks
  });
}

function createRekening() {
  Modal.pop(CreateModal);
}

function updateRekening(rekening: Rekening) {
  Modal.pop(EditModal, {
    rekening: rekening,
  });
}

function deleteRekening(id_rekening: Rekening['id_rekening']) {
  Modal.pop(DeleteModal, {
    id_rekening: id_rekening,
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Rekening" />
  
  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Master',
          current: 'Rekening'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
        <card-header class="mb-4">
          <div class="flex justify-between items-center">
            <ease-button @click="createRekening" slotted>
              <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Tambah Rekening
            </ease-button>
            <ease-button @click="searchRekening" variant="transparent" slotted>
              <fas-icon icon="fa-solid fa-search" class="mr-1" /> Pencarian
            </ease-button>
          </div>
        </card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="Nama" />
                <t-head-cell value="Bank" />
                <t-head-cell value="Rekening" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="rekening.data.length"
                v-for="(item, index) in rekening.data" :key="item.id"
                v-bind="{ last: index === rekening.data.length - 1 }">

                <t-body-cell
                  whitespace="nowrap">
                  <span class="font-semibold text-primary">
                    {{ item.nama }}
                  </span>
                  <p class="font-semibold text-primary/60">
                    {{ item.jabatan }}
                  </p>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <span class="font-semibold text-primary">
                    {{ item.nama_bank }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  whitespace="normal">
                  <span class="font-semibold text-primary">
                    {{ item.nomor_rekening }},
                  </span>
                  <span class="text-primary/60">
                    {{ item.nama_rekening }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <div class="flex">
                    <ease-button
                      @click="updateRekening(item)"
                      variant="link"
                      text="Edit"
                    />
                    <ease-button
                      @click="deleteRekening(item.id_rekening)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>

                <t-body-cell
                  colspan="4"
                  text-align="center">
                  Rekening tidak ditemukan
                </t-body-cell>

              </t-row>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>