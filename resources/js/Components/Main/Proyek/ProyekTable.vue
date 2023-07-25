<script setup lang="ts">
// types
import { Proyek } from '@/types';
import { QTableColumn, useQuasar } from 'quasar';
import { ProyekFilterOptions } from '@/Pages/Main/ProyekPage.vue';

// utils
import { toRupiah } from '@/utils/money';

// comps
import {
  ProyekSearchDialog,
  ProyekCreateDialog,
  ProyekEditDialog,
  ProyekDeleteDialog
} from '@/Components/Main/proyek-page';

const props = defineProps<{
  rows: Array<Proyek>;
  filterOptions: ProyekFilterOptions; 
}>();

const columns: Array<QTableColumn> = [
  {
    name: 'nama_proyek',
    label: 'Nama Proyek',
    field: 'nama_proyek',
    align: 'left',
    classes: 'text-primary',
    sortable: true
  },
  {
    name: 'pengguna_jasa',
    label: 'Pengguna Jasa',
    field: 'pengguna_jasa',
    align: 'left',
    sortable: true
  },
  {
    name: 'tahun_anggaran',
    label: 'Tahun Anggaran',
    field: 'tahun_anggaran',
    align: 'left',
    sortable: true
  },
  {
    name: 'nilai_kontrak',
    label: 'Nilai Kontrak',
    field: 'nilai_kontrak',
    align: 'right',
    sortable: true
  },
  {
    name: 'waktu_mulai',
    label: 'Tanggal Mulai',
    field: 'waktu_mulai',
    align: 'left',
    sortable: true
  },
  {
    name: 'waktu_selesai',
    label: 'Tanggal Selesai',
    field: 'waktu_selesai',
    align: 'left',
    sortable: true
  },
  {
    name: 'status_proyek',
    label: 'Status',
    field: 'status_proyek',
    align: 'left',
    sortable: true,
  },
  {
    name: 'actions',
    label: 'Actions',
    field: '',
    align: 'left',
  }
];

const $q = useQuasar();

function searchProyek() {
  $q.dialog({
    component: ProyekSearchDialog,
    componentProps: {
      rows: props.rows,
      options: props.filterOptions
    }
  });
}

function createProyek() {
  $q.dialog({
    component: ProyekCreateDialog,
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function editProyek(data: Proyek) {
  $q.dialog({
    component: ProyekEditDialog,
    componentProps: {
      proyek: data
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function deleteProyek(id: Proyek['id_proyek']) {
  $q.dialog({
    component: ProyekDeleteDialog,
    componentProps: {
      id_proyek: id
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      row-key="nama_proyek"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 5, 10, 15, 20, 25, 50, 0 ]"
    >
      <template v-slot:top-left>
        <q-btn
          no-caps
          label="Proyek Baru"
          icon="add"
          color="primary"
          @click="createProyek"
        />
      </template>

      <template v-slot:top-right>
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchProyek"
        />
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            style="font-weight: bold;"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="nama_proyek" :props="props">
            {{ props.row.nama_proyek }}
          </q-td>

          <q-td key="pengguna_jasa" :props="props">
            {{ props.row.pengguna_jasa }}
          </q-td>

          <q-td key="tahun_anggaran" :props="props">
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td key="nilai_kontrak" :props="props">
            {{ toRupiah(props.row.nilai_kontrak) }}
          </q-td>

          <q-td key="waktu_mulai" :props="props">
            {{ props.row.waktu_mulai }}
          </q-td>

          <q-td key="waktu_selesai" :props="props">
            {{ props.row.waktu_selesai }}
          </q-td>
          
          <q-td key="status_proyek" :props="props">
            <q-badge
              :color="props.row.status_proyek == 400 ? 'red' : 'primary'"
              :label="props.row.status_proyek == 400 ? 'Closed' : 'On Progress'"
            />
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              dense
              flat
              color="blue-grey"
              icon="more_vert"
            >
              <q-menu
                auto-close
                transition-show="scale"
                transition-hide="scale"
              >
                <q-list dense style="min-width: 100px">
                  <q-item clickable>
                    <q-item-section
                      @click="editProyek(props.row)"
                    >Edit</q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteProyek(props.row.id_proyek)"
                    >Delete</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>