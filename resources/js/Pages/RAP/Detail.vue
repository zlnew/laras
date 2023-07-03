<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed, onUpdated, ref } from 'vue';
import { DetailRAP, RAP, Satuan } from '@/types';
import { toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';
import CreateModalWindow from '@/Pages/RAP/Modals/Create.m.vue';
import UpdateModalWindow from '@/Pages/RAP/Modals/Update.m.vue';
import DeleteModalWindow from '@/Pages/RAP/Modals/Delete.m.vue';

const page = usePage();
const permissions = computed(() => page.props.permissions);

const props = defineProps<{
  rap: RAP,
  detail_rap: Array<DetailRAP>;
  satuan: Array<Satuan>;
  flash: {
    success: string | null,
    error: string | null,
  },
}>();

const computed__rap = computed(() => {
  const items = props.detail_rap.map((detail) => {
    const computed__harga_satuan = toRupiah(detail.harga_satuan);
    const computed__total_harga = toRupiah(detail.harga_satuan * detail.volume);

    return {
      ...detail,
      computed__harga_satuan: computed__harga_satuan,
      computed__total_harga: computed__total_harga,
    }
  });

  const total_rap = props.detail_rap.map(detail => detail.harga_satuan * detail.volume)
    .reduce((acc, curr) => acc + curr, 0);

  return {
    items: items,
    total_rap: toRupiah(total_rap),
  }
});

function OpenCreateModal() {
  Modal.pop(CreateModalWindow, {
    id_rap: props.rap.id_rap,
    satuan: props.satuan,
  });
}

function OpenUpdateModal(detail_rap: DetailRAP) {
  Modal.pop(UpdateModalWindow, {
    detail_rap: detail_rap,
    satuan: props.satuan,
  });
}

function OpenDeleteModal(id_detail_rap: DetailRAP['id_detail_rap']) {
  Modal.pop(DeleteModalWindow, {
    id_detail_rap: id_detail_rap
  });
}

onUpdated(() => {
  if (props.flash.success) Toast.success(props.flash.success);
  if (props.flash.error) Toast.error(props.flash.error);
});
</script>

<template>
  <Head title="Detail RAP" />

  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'RAP', current: props.rap.proyek.nama_proyek }" />
    </template>

    <ContentLayout>
      <CardLayout>
				<CardHeader>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl">Rencana Anggaran Proyek</h5>
            <EaseButton v-if="permissions.includes('create rap')" @click="OpenCreateModal" slotted>
              <FasIcon icon="fa-solid fa-plus" class="mr-1" /> Tambah Uraian
            </EaseButton>
          </div>
        </CardHeader>
        <CardBody table>
          <TableLayout>
            <THead>
              <TRow>
                <THeadCell value="#" />
                <THeadCell value="Uraian" />
                <THeadCell value="Satuan" />
                <THeadCell text-align="right" value="Harga" />
                <THeadCell text-align="center" value="Volume" />
                <THeadCell text-align="right" value="Total Harga" />
                <THeadCell value="Status" />
                <THeadCell value="Keterangan" />
                <THeadCell textAlign="center" value="" />
              </TRow>
            </THead>
            <TBody>
              <TRow
                v-if="computed__rap.items.length"
                v-for="(items, index) in computed__rap.items" :key="items.id_detail_rap"
              >
                <TBodyCell>{{ index + 1 }}</TBodyCell>
                <TBodyCell whitespace="nowrap" class="font-semibold text-primary">{{ items.uraian }}</TBodyCell>
                <TBodyCell whitespace="nowrap">{{ items.satuan.nama_satuan }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="right">{{ items.computed__harga_satuan }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="center">{{ items.volume }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="right">{{ items.computed__total_harga }}</TBodyCell>
                <TBodyCell whitespace="nowrap">{{ items.status_uraian }}</TBodyCell>
                <TBodyCell>{{ items.keterangan }}</TBodyCell>
                <TBodyCell
                  v-if="permissions.includes('update rap') && permissions.includes('delete rap')"
                  whitespace="nowrap">
                  <div class="flex">
                    <EaseButton @click="OpenUpdateModal(items)" variant="link" text="Edit" />
                    <EaseButton @click="OpenDeleteModal(items.id_detail_rap)" variant="danger-link" text="Delete" />
                  </div>
                </TBodyCell>
              </TRow>
              <TRow v-else last>
                <TBodyCell colspan="8" textAlign="center">Uraian tidak ditemukan</TBodyCell>
              </TRow>
            </TBody>
            <TFoot v-if="computed__rap.items.length">
              <TRow last>
                <TBodyCell text-align="right" colspan="5" class="font-semibold">Total RAP</TBodyCell>
                <TBodyCell colspan="1" class="font-semibold">{{ computed__rap.total_rap }}</TBodyCell>
              </TRow>
            </TFoot>
          </TableLayout>
        </CardBody>
      </CardLayout>
    </ContentLayout>
  </AuthenticatedLayout>
</template>