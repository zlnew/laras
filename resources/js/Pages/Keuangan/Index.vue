<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { FormInput } from '@/Components/Form.vue';

import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onUpdated } from 'vue';
import { Keuangan, Proyek } from '@/types';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';

import CreateModalWindow from './Modals/Create.m.vue';
import EditModalWindow from './Modals/Edit.m.vue';
import DeleteModalWindow from './Modals/Delete.m.vue';

const page = usePage();

const permissions = page.props.permissions;

const queryParams = page.props.query as Proyek;

const CRUDPermission = computed(() => {
  if (
    permissions.includes('create pengajuan dana')
    && permissions.includes('update pengajuan dana')
    && permissions.includes('delete pengajuan dana')
  ) {
    return true;
  }

  return false;
});

const props = defineProps<{
  keuangan: {
    data: Array<Keuangan>;
  },
  proyek: Array<Proyek>;
}>();

const form = useForm({
  nama_proyek: queryParams.nama_proyek,
});

function PopCreateModal() {
  Modal.pop(CreateModalWindow, {
    daftar_proyek: props.proyek
  });
}

function PopEditModal(keuangan: Partial<Keuangan>) {
  Modal.pop(EditModalWindow, {
    id_keuangan: keuangan.id_keuangan,
    keperluan: keuangan.keperluan
  });
}

function PopDeleteModal(id_keuangan: Keuangan['id_keuangan']) {
  Modal.pop(DeleteModalWindow, {
    id_keuangan: id_keuangan
  });
}

function search() {
  form.get(route('keuangan'));
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Keuangan" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Keuangan',
          current: 'Keuangan Proyek'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
				<card-header class="mb-4">
          <div class="grid grid-cols-2 gap-4">
            <div class="space-x-2">
              <ease-button
                v-if="CRUDPermission"
                @click="PopCreateModal"
                slotted>
                <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Tambah Keuangan Proyek
              </ease-button>
            </div>
            <form @submit.prevent="search">
              <div class="flex justify-between items-center space-x-2">
                <form-input v-model="form.nama_proyek"
                  v-bind="{
                    type: 'search',
                    size: 'lg',
                    placeholder: 'Cari Berdasarkan Nama Proyek',
                    autocomplete: 'off',
                  }"
                />
                <ease-button
                  v-bind="{
                    type: 'submit',
                    text: 'Cari',
                    loading: form.processing,
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
                <t-head-cell value="Nama Proyek" />
                <t-head-cell value="Tahun Anggaran" />
                <t-head-cell value="Keperluan" />
                <t-head-cell value="Pengajuan Dana" />
                <t-head-cell value="Pencairan Dana" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="keuangan.data.length"
                v-for="(proyek, index) in keuangan.data" :key="proyek.id_proyek"
                v-bind="{ last: index === keuangan.data.length - 1 }">
                
                <t-body-cell>
                  <Link class="link" :href="'#'">
                    <span class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</span>
                  </Link>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ proyek.tahun_anggaran }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  <span class="font-semibold text-dark">
                    {{ proyek.keperluan }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <Link
                    class="link text-xs"
                    :href="route('pengajuan_dana.detail', proyek.id_pengajuan_dana)">
                    Lihat
                  </Link>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <Link
                    v-if="proyek.id_pencairan_dana"
                    class="link text-xs"
                    :href="route('pencairan_dana.detail', proyek.id_pencairan_dana)">
                    Lihat
                  </Link>

                  <span v-else>-</span>
                </t-body-cell>

                <t-body-cell
                  v-if="CRUDPermission"
                  whitespace="nowrap">
                  <div class="flex">
                    <ease-button
                      @click="PopEditModal(proyek)"
                      variant="link"
                      text="Edit"
                    />
                    <ease-button
                      @click="PopDeleteModal(proyek.id_keuangan)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <TRow v-else last>

                <t-body-cell
                  colspan="5"
                  text-align="center">
                  Keuangan proyek tidak ditemukan
                </t-body-cell>
              
              </TRow>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>