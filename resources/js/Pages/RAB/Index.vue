<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { FormInput } from '@/Components/Form.vue';

import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onUpdated } from 'vue';
import { Proyek, RAB } from '@/types';
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
    permissions.includes('create rab')
    && permissions.includes('update rab')
    && permissions.includes('delete rab')
  ) {
    return true;
  }

  return false;
});

const props = defineProps<{
  rab: {
    data: Array<RAB>;
  },
  proyek: Array<Proyek>;
}>();

const rab = computed(() => {
  const data = props.rab.data.map((rab) => {
    const status_rab_in_string = rab.status_rab == 400
      ? 'Closed'
      : 'On Progress';      

    return { ...rab,
      status_rab_in_string: status_rab_in_string,
    };
  });

  return { data };
});

const form = useForm({
  nama_proyek: queryParams.nama_proyek,
});

function PopCreateModal() {
  Modal.pop(CreateModalWindow, {
    daftar_proyek: props.proyek
  });
}

function PopEditModal(rab: Partial<RAB>) {
  Modal.pop(EditModalWindow, {
    id_rab: rab.id_rap,
    id_proyek: rab.id_proyek,
    nama_proyek: rab.nama_proyek,
    daftar_proyek: props.proyek
  });
}

function PopDeleteModal(id_rab: RAB['id_rab']) {
  Modal.pop(DeleteModalWindow, {
    id_rab: id_rab
  });
}

function search() {
  form.get(route('rab'));
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="RAP" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'RAB',
          current: 'Rencana Anggaran Biaya'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
				<card-header class="mb-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <ease-button
              v-if="CRUDPermission"
              @click="PopCreateModal"
              slotted>
              <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Buat RAB Proyek
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
                <t-head-cell value="Pengguna Jasa" />
                <t-head-cell text-align="center" value="Status" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="rab.data.length"
                v-for="(proyek, index) in rab.data" :key="proyek.id_proyek"
                v-bind="{ last: index === rab.data.length - 1 }">
                
                <t-body-cell>
                  <Link class="link" :href="route('detail_rab', proyek.id_rab)">
                    <span class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</span>
                  </Link>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ proyek.tahun_anggaran }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap">
                  {{ proyek.pengguna_jasa }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  <Link :href="route('detail_rab', proyek.id_rab)">
                    <EaseButton
                      v-bind="{
                        text: proyek.status_rab_in_string,
                        variant: proyek.status_rab == 400
                          ? 'danger-transparent'
                          : 'transparent'
                      }"
                    />
                  </Link>
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
                      @click="PopDeleteModal(proyek.id_rab)"
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
                  RAB tidak ditemukan
                </t-body-cell>
              
              </TRow>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>