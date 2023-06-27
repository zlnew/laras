<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { TableLayout, THead, TBody, TFoot, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed, onUpdated, ref } from 'vue';
import { DetailRAB, RAB, Satuan } from '@/types';
import { toRupiah } from '@/utilities/number';
import { Modal } from '@/utilities/modal';
import { Toast } from '@/utilities/toastify';
import CreateModalWindow from '@/Pages/RAB/Modals/Create.m.vue';
import UpdateModalWindow from '@/Pages/RAB/Modals/Update.m.vue';
import DeleteModalWindow from '@/Pages/RAB/Modals/Delete.m.vue';
import { FormInput } from '@/Components/Form.vue';

const props = defineProps<{
  rab: RAB,
  detail_rab: Array<DetailRAB>;
  satuan: Array<Satuan>;
  flash: {
    success: string | null,
    error: string | null,
  },
}>();

const computed__rab = computed(() => {
  const items = props.detail_rab.map((detail) => {
    const computed__harga_satuan = toRupiah(detail.harga_satuan);
    const computed__total_harga = toRupiah(detail.harga_satuan * detail.volume);

    return {
      ...detail,
      computed__harga_satuan: computed__harga_satuan,
      computed__total_harga: computed__total_harga,
    }
  });

  const total_rab = props.detail_rab.map(detail => detail.harga_satuan * detail.volume)
    .reduce((acc, curr) => acc + curr, 0);

  return {
    items: items,
    total_rab: total_rab,
    computed_total_rab: toRupiah(total_rab),
  }
});

const rab = useForm({
  tax: props.rab.tax,
  additional_tax: props.rab.additional_tax,
  total_rab: computed__rab.value.total_rab,
});

function updateTax() {
  rab.patch(route('rab.update_tax', props.rab.id_rab));
}

function OpenCreateModal() {
  Modal.pop(CreateModalWindow, {
    id_rab: props.rab.id_rab,
    satuan: props.satuan,
  });
}

function OpenUpdateModal(detail_rab: DetailRAB) {
  Modal.pop(UpdateModalWindow, {
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
  if (props.flash.success) Toast.success(props.flash.success);
  if (props.flash.error) Toast.error(props.flash.error);
});
</script>

<template>
  <Head title="Detail RAB" />

  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'RAB', current: props.rab.proyek.nama_proyek }" />
    </template>

    <ContentLayout>
      <CardLayout>
				<CardHeader>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl">Rencana Anggaran Biaya</h5>
            <EaseButton @click="OpenCreateModal" slotted>
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
                <THeadCell value="Keterangan" />
                <THeadCell textAlign="center" value="" />
              </TRow>
            </THead>
            <TBody>
              <TRow
                v-if="computed__rab.items.length"
                v-for="(items, index) in computed__rab.items" :key="items.id_detail_rab"
              >
                <TBodyCell>{{ index + 1 }}</TBodyCell>
                <TBodyCell whitespace="nowrap" class="font-semibold text-primary">{{ items.uraian }}</TBodyCell>
                <TBodyCell whitespace="nowrap">{{ items.satuan.nama_satuan }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="right">{{ items.computed__harga_satuan }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="center">{{ items.volume }}</TBodyCell>
                <TBodyCell whitespace="nowrap" text-align="right">{{ items.computed__total_harga }}</TBodyCell>
                <TBodyCell>{{ items.keterangan }}</TBodyCell>
                <TBodyCell whitespace="nowrap">
                  <div class="flex">
                    <EaseButton @click="OpenUpdateModal(items)" variant="link" text="Edit" />
                    <EaseButton @click="OpenDeleteModal(items.id_detail_rab)" variant="danger-link" text="Delete" />
                  </div>
                </TBodyCell>
              </TRow>
              <TRow v-else last>
                <TBodyCell colspan="7" textAlign="center">Uraian tidak ditemukan</TBodyCell>
              </TRow>
            </TBody>
            <TFoot>
              <TRow last>
                <TBodyCell text-align="right" colspan="4" class="font-semibold">PPN</TBodyCell>
                <TBodyCell colspan="1" class="font-semibold">
                  <FormInput @input="updateTax" type="number" v-model="rab.tax" min="0" max="100" />
                </TBodyCell>
              </TRow>
              <TRow last>
                <TBodyCell text-align="right" colspan="4" class="font-semibold">Additional Tax</TBodyCell>
                <TBodyCell colspan="1" class="font-semibold">
                  <FormInput @input="updateTax" type="number" v-model="rab.additional_tax" min="0" max="100" />
                </TBodyCell>
              </TRow>
              <TRow last>
                <TBodyCell text-align="right" colspan="4" class="font-semibold">Total RAB (Termasuk PPN)</TBodyCell>
                <TBodyCell colspan="1" class="font-semibold">{{ toRupiah(rab.total_rab * rab.tax * rab.additional_tax) }}</TBodyCell>
              </TRow>
            </TFoot>
          </TableLayout>
        </CardBody>
      </CardLayout>
    </ContentLayout>
  </AuthenticatedLayout>
</template>