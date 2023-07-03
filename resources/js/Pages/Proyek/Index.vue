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
const permissions = computed(() => page.props.permissions);

const props = defineProps<{
  daftarProyek: {
    data: Array<Proyek>,
  },
  flash: {
    success: string | null,
    error: string | null,
  },
}>();

const computed__daftarProyek = computed(() => {
  return props.daftarProyek.data.map((proyek) => {
    const computed__waktu_mulai = ll(proyek.waktu_mulai);
    const computed__waktu_selesai = ll(proyek.waktu_selesai);
    const computed__status_proyek = proyek.status_proyek == 400 ? 'Closed' : 'On Progress';
    const computed__nilai_kontrak = toRupiah(proyek.nilai_kontrak);

    return { ...proyek,
      waktu_mulai: computed__waktu_mulai,
      waktu_selesai: computed__waktu_selesai,
      status_proyek: computed__status_proyek,
      nilai_kontrak: computed__nilai_kontrak,
      status_proyek_code: proyek.status_proyek,
    };
  });
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
  if (props.flash.success) Toast.success(props.flash.success);
});
</script>

<template>
  <Head title="Daftar Proyek" />
  
  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'Proyek', current: 'Daftar Proyek' }" />
    </template>

    <ContentLayout>
      <CardLayout>
        <CardHeader>
          <div class="flex justify-between items-center">
            <div>
              <EaseButton v-if="permissions.includes('create proyek')" @click="PopCreateModal" slotted>
                <FasIcon icon="fa-solid fa-plus" class="mr-1" /> Proyek Baru
              </EaseButton>
            </div>
            <EaseButton @click="PopSearchModal()" variant="transparent" slotted>
              <FasIcon icon="fa-solid fa-search" class="mr-1" /> Pencarian
            </EaseButton>
          </div>
        </CardHeader>

        <CardBody table>
          <TableLayout>
            <THead>
              <TRow>
                <THeadCell value="Nama Proyek" />
                <THeadCell value="Tahun Anggaran" />
                <THeadCell value="Pengguna Jasa" />
                <THeadCell textAlign="center" value="Waktu Mulai" />
                <THeadCell textAlign="center" value="Waktu Selesai" />
                <THeadCell textAlign="right" value="Nilai Kontrak" />
                <THeadCell textAlign="center" value="Status" />
                <THeadCell textAlign="center" value="" />
              </TRow>
            </THead>
            <TBody>
              <TRow
                v-if="computed__daftarProyek.length"
                v-for="(proyek, index) in computed__daftarProyek" :key="proyek.id_proyek"
                v-bind="{ last: index === computed__daftarProyek.length - 1 }">

                <TBodyCell>
                  <Link href="#">
                    <EaseButton variant="link" class="text-left" slotted>
                      <span class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</span>
                    </EaseButton>
                  </Link>
                </TBodyCell>
                <TBodyCell whitespace="nowrap">{{ proyek.tahun_anggaran }}</TBodyCell>
                <TBodyCell>{{ proyek.pengguna_jasa }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="center">{{ proyek.waktu_mulai }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="center">{{ proyek.waktu_selesai }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="right">{{ proyek.nilai_kontrak }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="center">
                  <EaseButton v-bind="{
                    text: proyek.status_proyek,
                    variant: proyek.status_proyek_code == 400 ? 'danger-transparent' : 'transparent'
                  }" />
                </TBodyCell>
                <TBodyCell
                  v-if="permissions.includes('update proyek') && permissions.includes('delete proyek')"
                  whitespace="nowrap">
                  <div class="flex">
                    <EaseButton @click="PopEditModal(proyek)" text="Edit" variant="link" />
                    <EaseButton @click="PopDeleteModal(proyek.id_proyek)" variant="link" slotted>
                      <span class="text-danger">Delete</span>
                    </EaseButton>
                  </div>
                </TBodyCell>
              </TRow>

              <TRow v-else last>
                <TBodyCell colspan="7" textAlign="center">Proyek tidak ditemukan</TBodyCell>
              </TRow>
            </TBody>
          </TableLayout>
        </CardBody>
      </CardLayout>
    </ContentLayout>
  </AuthenticatedLayout>
</template>