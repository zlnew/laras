<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from "@/Components/Card.vue";
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';

import CreateModalWindow from '@/Pages/Proyek/Modals/Create.m.vue';
import EditModalWindow from '@/Pages/Proyek/Modals/Edit.m.vue';
import DeleteModalWindow from '@/Pages/Proyek/Modals/Delete.m.vue';
import SearchModalWindow from '@/Pages/Proyek/Modals/Search.m.vue';

import { toRupiah } from '@/utilities/number';
import { ll } from "@/utilities/date";
import { Modal } from "@/utilities/modal"
import { Toast } from "@/utilities/toastify";

import { computed, onUpdated } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Proyek } from '@/types';

const page = usePage();

const permissions = page.props.permissions;

const CRUDPermission = computed(() => {
  if (
    permissions.includes('create proyek')
    && permissions.includes('update proyek')
    && permissions.includes('delete proyek')
  ) {
    return true;
  }

  return false;
});

const props = defineProps<{
  daftar_proyek: {
    data: Array<Proyek>,
  },
}>();

const daftar_proyek = computed(() => {
  const data = props.daftar_proyek.data.map((proyek) => {
    const waktu_mulai_in_ll = ll(proyek.waktu_mulai);
    const waktu_selesai_in_ll = ll(proyek.waktu_selesai);
    const status_proyek_in_string = proyek.status_proyek == 400
      ? 'Closed'
      : 'On Progress';
    const nilai_kontrak_in_rupiah = toRupiah(proyek.nilai_kontrak);

    return { ...proyek,
      waktu_mulai_in_ll: waktu_mulai_in_ll,
      waktu_selesai_in_ll: waktu_selesai_in_ll,
      status_proyek_in_string: status_proyek_in_string,
      nilai_kontrak_in_rupiah: nilai_kontrak_in_rupiah,
    };
  });

  return { data };
});

function PopCreateModal() {
  Modal.pop(CreateModalWindow)
}

function PopEditModal(proyek: Object) {
  Modal.pop(EditModalWindow, { proyek });
}

function PopDeleteModal(id_proyek: string) {
  Modal.pop(DeleteModalWindow, { id_proyek });
}

function PopSearchModal() {
  Modal.pop(SearchModalWindow);
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Daftar Proyek" />
  
  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Proyek',
          current: 'Daftar Proyek'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
        <card-header>
          <div class="flex justify-between items-center">
            <div>
              <ease-button
                v-if="CRUDPermission"
                @click="PopCreateModal"
                slotted>
                <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Proyek Baru
              </ease-button>
            </div>
            <ease-button
              @click="PopSearchModal()"
              variant="transparent"
              slotted>
              <fas-icon icon="fa-solid fa-search" class="mr-1" /> Pencarian
            </ease-button>
          </div>
        </card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="Nama Proyek" />
                <t-head-cell value="Tahun Anggaran" />
                <t-head-cell value="Pengguna Jasa" />
                <t-head-cell text-align="center" value="Waktu Mulai" />
                <t-head-cell text-align="center" value="Waktu Selesai" />
                <t-head-cell text-align="right" value="Nilai Kontrak" />
                <t-head-cell text-align="center" value="Status" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="daftar_proyek.data.length"
                v-for="(proyek, index) in daftar_proyek.data" :key="proyek.id_proyek"
                v-bind="{ last: index === daftar_proyek.data.length - 1 }">

                <t-body-cell>
                  <Link class="link" href="#">
                    <span class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</span>
                  </Link>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ proyek.tahun_anggaran }}
                </t-body-cell>

                <t-body-cell
                  whitespace="normal">
                  {{ proyek.pengguna_jasa }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  {{ proyek.waktu_mulai_in_ll }}
                </t-body-cell>
                
                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  {{ proyek.waktu_selesai_in_ll }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="right">
                {{ proyek.nilai_kontrak_in_rupiah }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap"
                  text-align="center">
                  <ease-button
                    v-bind="{
                      text: proyek.status_proyek_in_string,
                      variant: proyek.status_proyek == 400
                        ? 'danger-transparent'
                        : 'transparent'
                      }"
                  />
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
                      @click="PopDeleteModal(proyek.id_proyek)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>

                <t-body-cell
                  colspan="7"
                  text-align="center">
                  Proyek tidak ditemukan
                </t-body-cell>

              </t-row>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>