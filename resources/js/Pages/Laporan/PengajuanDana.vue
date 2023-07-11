<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { FormInput } from '@/Components/Form.vue';

import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { PengajuanDana, Proyek } from '@/types';
import { toRupiah } from '@/utilities/number';
import { ll } from '@/utilities/date';

const page = usePage();

const queryParams = page.props.query as Proyek;

const props = defineProps<{
  pengajuan_dana: {
    data: Array<PengajuanDana>;
  },
}>();

const form = useForm({
  nama_proyek: queryParams.nama_proyek,
});

function search() {
  form.get(route('laporan.pengajuan_dana'));
}
</script>

<template>
  <Head title="Monitoring Pengajuan Dana" />

  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Reports',
          current: 'Pengajuan Dana'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
				<card-header class="mb-4">
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
				</card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="Nama Proyek" />
                <t-head-cell value="Keperluan" />
                <t-head-cell value="Tanggal Pengajuan" />
                <t-head-cell text-align="right" value="Jumlah Pengajuan Dana" />
                <t-head-cell text-align="right" value="Jumlah Disetujui" />
                <t-head-cell text-align="center" value="Status" />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="pengajuan_dana.data.length"
                v-for="(item, index) in pengajuan_dana.data" :key="item.id_proyek"
                v-bind="{ last: index === pengajuan_dana.data.length - 1 }">
                
                <t-body-cell>
                  <Link class="link" :href="'#'">
                    <span class="line-clamp-2 hover:line-clamp-none">{{ item.nama_proyek }}</span>
                  </Link>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <span class="font-semibold text-primary">
                    {{ item.keperluan }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ ll(item.tanggal_pengajuan) }}
                </t-body-cell>

                <t-body-cell
                  text-align="right"
                  whitespace="nowrap">
                  <span class="text-primary">
                    {{ toRupiah(item.jumlah_pengajuan_dana) }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  text-align="right"
                  whitespace="nowrap">
                  <span class="font-semibold text-primary">
                    {{ toRupiah(item.jumlah_disetujui) }}
                  </span>
                </t-body-cell>

                <t-body-cell
                  text-align="center">
                  <Link :href="route('pengajuan_dana.detail', item.id_pengajuan_dana)">
                    <EaseButton
                      v-bind="{
                        text: item.status_pengajuan == 400
                          ? 'Closed'
                          : 'Open',
                        variant: item.status_pengajuan == 400
                          ? 'danger-link'
                          : 'link'
                      }"
                    />
                  </Link>
                </t-body-cell>

              </t-row>

              <TRow v-else last>

                <t-body-cell
                  colspan="6"
                  text-align="center">
                  Pengajuan Dana tidak ditemukan
                </t-body-cell>
              
              </TRow>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>