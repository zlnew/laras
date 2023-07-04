<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { FormInput } from '@/Components/Form.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed } from 'vue';
import { PengajuanDana, Proyek } from '@/types';
import { ll } from '@/utilities/date';
import { Modal } from '@/utilities/modal';

import CreateModal from './Modals/Create.m.vue';
import UpdateModal from './Modals/Update.m.vue';
import DeleteModal from './Modals/Delete.m.vue';
import { Toast } from '@/utilities/toastify';
import { onUpdated } from 'vue';

const params = new URLSearchParams(document.location.search);
const page = usePage();

const props = defineProps<{
  pengajuan_dana: {
    data: Array<PengajuanDana>;
  };
  proyek: Array<Proyek>;
}>();

const pengajuan_dana = computed(() => {
  return props.pengajuan_dana.data.map((pengajuan) => {
    const tanggal_pengajuan = ll(pengajuan.created_at);
    const status_pengajuan = pengajuan.status_pengajuan == 400 ? 'Closed' : 'Open';      

    return { ...pengajuan,
      nama_proyek: pengajuan.nama_proyek,
      tanggal_pengajuan: tanggal_pengajuan,
      status_pengajuan_text: status_pengajuan,
    };
  });
});

const form = useForm({
  nama_proyek: params.get('nama_proyek'),
});

function search() {
  form.get(route('keuangan.search'));
}

function openCreateModal() {
  Modal.pop(CreateModal, {
    proyek: props.proyek
  });
}

function openUpdateModal(pengajuan_dana: Partial<PengajuanDana>) {
  Modal.pop(UpdateModal, {
    pengajuan_dana: pengajuan_dana,
    proyek: props.proyek
  });
}

function openDeleteModal(id_pengajuan_dana: PengajuanDana['id_pengajuan_dana']) {
  Modal.pop(DeleteModal, {
    id_pengajuan_dana: id_pengajuan_dana
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Pencarian RAP" />

  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'Keuangan', current: 'Daftar Keuangan Proyek' }" />
    </template>

    <ContentLayout>
      <CardLayout>
				<CardHeader>
          <div class="flex justify-between items-center gap-4">
            <EaseButton @click="openCreateModal" slotted>
              <FasIcon icon="fa-solid fa-plus" class="mr-1" /> Tambah Keuangan Proyek
            </EaseButton>
            <form @submit.prevent="search">
              <div class="flex justify-between items-center space-x-2">
                <FormInput v-model="form.nama_proyek" v-bind="{
                  type: 'search',
                  size: 'lg',
                  placeholder: 'Cari Berdasarkan Nama Proyek',
                  autocomplete: 'off',
                  class: 'w-96'
                }" />
                <EaseButton v-bind="{
                  type: 'submit',
                  text: 'Cari',
                  loading: form.processing,
                  onLoading: () => ({
                    text: false,
                  })
                }" />
              </div>
            </form>
          </div>
        </CardHeader>

        <CardBody table>
          <TableLayout>
            <THead>
              <TRow>
                <THeadCell value="Nama Proyek" />
                <THeadCell value="Keterangan" />
                <THeadCell value="Tanggal Pengajuan Dana" />
                <THeadCell textAlign="center" value="Status" />
                <THeadCell textAlign="center" value="" />
              </TRow>
            </THead>
            <TBody>
              <TRow
                v-if="pengajuan_dana.length"
                v-for="(pengajuan, index) in pengajuan_dana" :key="pengajuan.id_pengajuan_dana"
                v-bind="{ last: index === pengajuan_dana.length - 1 }"
              >
                <TBodyCell>
                  <Link :href="route('rap.detail', pengajuan.id_rap)">
                    <EaseButton variant="link" class="text-left" slotted>
                      <span class="line-clamp-2 hover:line-clamp-none">{{ pengajuan.nama_proyek }}</span>
                    </EaseButton>
                  </Link>
                </TBodyCell>
                <TBodyCell whitespace="nowrap">{{ pengajuan.keterangan }}</TBodyCell>
                <TBodyCell whitespace="nowrap">{{ pengajuan.tanggal_pengajuan }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="center">
                  <EaseButton v-bind="{
                    text: pengajuan.status_pengajuan_text,
                    variant: pengajuan.status_pengajuan == 400 ? 'danger-transparent' : 'transparent'
                  }" />
                </TBodyCell>
                <TBodyCell whitespace="nowrap">
                  <div class="flex">
                    <EaseButton @click="openUpdateModal({
                        id_pengajuan_dana: pengajuan.id_pengajuan_dana,
                        id_rap: pengajuan.id_rap,
                        keterangan: pengajuan.keterangan
                      })" variant="link" text="Edit"
                    />
                    <EaseButton @click="openDeleteModal(
                        pengajuan.id_pengajuan_dana
                      )" variant="danger-link" text="Delete"
                    />
                  </div>
                </TBodyCell>
              </TRow>
              <TRow v-else last>
                <TBodyCell colspan="4" textAlign="center">Keuangan proyek tidak ditemukan</TBodyCell>
              </TRow>
            </TBody>
          </TableLayout>
        </CardBody>
      </CardLayout>
    </ContentLayout>
  </AuthenticatedLayout>
</template>