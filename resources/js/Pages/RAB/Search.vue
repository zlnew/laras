<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { FormInput } from '@/Components/Form.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { computed } from 'vue';
import { Proyek } from '@/types';

const params = new URLSearchParams(document.location.search);

const props = defineProps<{
  daftarProyek: Array<Proyek>;
}>();

const computed__daftarProyek = computed(() => {
  return props.daftarProyek.map((proyek) => {
    const computed__status_proyek = proyek.status_proyek == 400 ? 'Closed' : 'On Progress';      

    return { ...proyek,
      status_proyek: computed__status_proyek,
      status_proyek_code: proyek.status_proyek,
    };
  });
});

const form = useForm({
  nama_proyek: params.get('nama_proyek'),
});

function search() {
  form.get(route('rab.search'));
}
</script>

<template>
  <Head title="Pencarian RAB" />

  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'RAB', current: 'Search' }" />
    </template>

    <ContentLayout>
      <CardLayout>
				<CardHeader>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl">Cari Proyek</h5>
          </div>
        </CardHeader>
				<CardBody>
          <form @submit.prevent="search">
            <div class="flex justify-between items-center space-x-2">
              <FormInput v-model="form.nama_proyek" v-bind="{
                type: 'search',
                size: 'lg',
                placeholder: 'Cari Berdasarkan Nama Proyek',
                autocomplete: 'off',
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
				</CardBody>

        <CardBody table>
          <TableLayout>
            <THead>
              <TRow>
                <THeadCell value="Nama Proyek" />
                <THeadCell value="Tahun Anggaran" />
                <THeadCell value="Pengguna Jasa" />
                <THeadCell textAlign="center" value="Status" />
                <THeadCell textAlign="center" value="" />
              </TRow>
            </THead>
            <TBody>
              <TRow
                v-if="computed__daftarProyek.length"
                v-for="(proyek, index) in computed__daftarProyek" :key="proyek.id_proyek"
                v-bind="{ last: index === computed__daftarProyek.length - 1 }"
              >
                <TBodyCell>
                  <Link :href="route('rab.detail', proyek.rab.id_rab)">
                    <EaseButton variant="link" class="text-left" slotted>
                      <span class="line-clamp-2 hover:line-clamp-none">{{ proyek.nama_proyek }}</span>
                    </EaseButton>
                  </Link>
                </TBodyCell>
                <TBodyCell whitespace="nowrap">{{ proyek.tahun_anggaran }}</TBodyCell>
                <TBodyCell whitespace="nowrap">{{ proyek.pengguna_jasa }}</TBodyCell>
                <TBodyCell whitespace="nowrap" textAlign="center">
                  <EaseButton v-bind="{
                    text: proyek.status_proyek,
                    variant: proyek.status_proyek_code == 400 ? 'danger-transparent' : 'transparent'
                  }" />
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