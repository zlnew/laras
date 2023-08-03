<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

// utils
import { toRupiah } from '@/utils/money';
import { fullDate } from '@/utils/date';
import { can, isAdmin, isModuleEditable } from '@/utils/permissions';

// types
import { Proyek } from '@/types';
import { QTableColumn, useQuasar } from 'quasar';
import { FormOptions } from '@/Pages/Main/ProyekPage.vue';

// comps
import {
  ProyekDetailDialog,
  ProyekSearchDialog,
  ProyekCreateDialog,
  ProyekEditDialog,
  ProyekDeleteDialog
} from '@/Components/Main/proyek-page';

const props = defineProps<{
  rows: Array<Proyek>;
  formOptions: FormOptions; 
}>();

const $q = useQuasar();

function detailProyek(data: Proyek) {
  $q.dialog({
    component: ProyekDetailDialog,
    componentProps: {
      proyek: data,
    }
  });
}

function searchProyek() {
  $q.dialog({
    component: ProyekSearchDialog,
    componentProps: {
      rows: props.rows,
      options: props.formOptions
    }
  });
}

function createProyek() {
  $q.dialog({
    component: ProyekCreateDialog,
    componentProps: {
      options: props.formOptions
    }
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
      proyek: data,
      options: props.formOptions
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

const columns: Array<QTableColumn> = [
  { name: 'index', label: '#', field: 'index' },
  {
    name: 'nama_proyek',
    label: 'Nama Proyek',
    field: 'nama_proyek',
    align: 'left',
    sortable: true
  },
  { name: 'pengguna_jasa', label: 'Pengguna Jasa', field: 'pengguna_jasa', align: 'left', sortable: true },
  { name: 'penyedia_jasa', label: 'Penyedia Jasa', field: 'penyedia_jasa', align: 'left', sortable: true },
  { name: 'tahun_anggaran', label: 'Tahun Anggaran', field: 'tahun_anggaran', align: 'left', sortable: true },
  { name: 'nilai_kontrak', label: 'Nilai Kontrak', field: 'nilai_kontrak', align: 'right', sortable: true },
  { name: 'tanggal_mulai', label: 'Tanggal Mulai', field: 'tanggal_mulai', align: 'left', sortable: true },
  { name: 'durasi', label: 'Durasi (Hari)', field: 'durasi', align: 'left', sortable: true },
  { name: 'tanggal_selesai', label: 'Tanggal Selesai', field: 'tanggal_selesai', align: 'left', sortable: true },
  { name: 'status_proyek', label: 'Status', field: 'status_proyek', align: 'left', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
];

const tableFullscreen = ref(false);

function toggleFullscreen() {
  tableFullscreen.value = !tableFullscreen.value;
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
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          v-if="can('create & modify proyek')"
          no-caps
          label="Proyek Baru"
          icon="add"
          color="primary"
          @click="createProyek"
        />
      </template>

      <template v-slot:top-right>
        <q-btn
          v-if="Object.keys($page.props.query).length"
          flat
          no-caps
          label="Clear Filter"
          icon="clear"
          color="secondary"
          @click="router.visit(route('proyek'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchProyek"
        />
        <q-btn
          flat dense
          :icon="tableFullscreen ? 'fullscreen_exit' : 'fullscreen'"
          @click="toggleFullscreen"
          class="q-ml-md"
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
          <q-td key="index" :props="props">
            {{ ++props.rowIndex }}
          </q-td>

          <q-td key="nama_proyek" :props="props">
            <q-btn
              flat
              no-caps
              dense
              color="primary"
              :ripple="false"
              :label="props.row.nama_proyek"
              @click="detailProyek(props.row)"
            >
              <q-tooltip anchor="bottom middle" self="top middle">
                Lihat Detail
              </q-tooltip>
            </q-btn>
          </q-td>

          <q-td key="pengguna_jasa" :props="props">
            {{ props.row.pengguna_jasa }}
          </q-td>

          <q-td key="penyedia_jasa" :props="props">
            {{ props.row.penyedia_jasa }}
          </q-td>

          <q-td key="tahun_anggaran" :props="props">
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td key="nilai_kontrak" :props="props">
            {{ toRupiah(props.row.nilai_kontrak) }}
          </q-td>
          
          <q-td key="tanggal_mulai" :props="props">
            {{ fullDate(props.row.tanggal_mulai) }}
          </q-td>

          <q-td key="durasi" :props="props">
            {{ props.row.durasi }} Hari
          </q-td>

          <q-td key="tanggal_selesai" :props="props">
            {{ fullDate(props.row.tanggal_selesai) }}
          </q-td>
          
          <q-td key="status_proyek" :props="props">
            <q-badge
              :color="props.row.status_proyek == 400 ? 'red' : 'primary'"
              :label="props.row.status_proyek == 400 ? 'Closed' : 'On Progress'"
            />
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify proyek') && isModuleEditable(props.row.status_proyek)"
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
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteProyek(props.row.id_proyek)"
                    >
                      Delete
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>

            <q-btn
              v-else
              dense
              flat
              color="grey-6"
              icon="block"
            >
              <q-tooltip>Required permission</q-tooltip>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>