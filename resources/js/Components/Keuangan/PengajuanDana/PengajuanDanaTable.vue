<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { QTableColumn, useQuasar } from 'quasar';

// utils
import { can, isAdmin, isEditable, isModuleEditable, isRejected } from '@/utils/permissions';

// types
import { PengajuanDana, Proyek } from '@/types';
import { FormOptions } from '@/Pages/Keuangan/PengajuanDanaPage.vue';

// comps
import {
  PengajuanDanaSearchDialog,
  PengajuanDanaCreateDialog,
  PengajuanDanaEditDialog,
  PengajuanDanaDeleteDialog
} from '@/Components/Keuangan/pengajuan-dana-page';
import { ProyekDetailDialog } from '@/Components/Main/proyek-page';

const props = defineProps<{
  rows: Array<PengajuanDana>;
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

function searchPengajuanDana() {
  $q.dialog({
    component: PengajuanDanaSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  });
}

function createPengajuanDana() {
  $q.dialog({
    component: PengajuanDanaCreateDialog,
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

function editPengajuanDana(data: PengajuanDana) {
  $q.dialog({
    component: PengajuanDanaEditDialog,
    componentProps: {
      pengajuanDana: data,
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

function deletePengajuanDana(id: PengajuanDana['id_pengajuan_dana']) {
  $q.dialog({
    component: PengajuanDanaDeleteDialog,
    componentProps: {
      id_pengajuan_dana: id
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
  { name: 'tahun_anggaran', label: 'Tahun Anggaran', field: 'tahun_anggaran', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'status_pengajuan', label: 'Status', field: 'status_pengajuan', align: 'left', sortable: true },
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
      row-key="id_rap"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          v-if="can('create & modify pengajuan dana')"
          no-caps
          label="Tambah Pengajuan Dana"
          icon="add"
          color="primary"
          @click="createPengajuanDana"
        />

        <div v-else class="text-h6">List Pengajuan Dana</div>
      </template>

      <template v-slot:top-right>
        <q-btn
          v-if="Object.keys($page.props.query).length"
          flat
          no-caps
          label="Clear Filter"
          icon="clear"
          color="secondary"
          @click="router.visit(route('pengajuan_dana'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchPengajuanDana"
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

          <q-td key="tahun_anggaran" :props="props">
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td key="keperluan" :props="props">
            {{ props.row.keperluan }}
          </q-td>
          
          <q-td key="status_pengajuan" :props="props">
            <q-btn
              v-if="isRejected(props.row.status_aktivitas)"
              flat
              dense
              round
              color="grey-6"
              icon="warning"
              size="sm"
            >
              <q-tooltip>Ditolak</q-tooltip>
            </q-btn>

            <q-badge
              :color="props.row.status_pengajuan == 400 ? 'red' : 'primary'"
              :label="props.row.status_pengajuan == 400 ? 'Closed' : 'Open'"
              v-in-link="route('detail_pengajuan_dana', props.row.id_pengajuan_dana)"
            />
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify pengajuan dana') && isModuleEditable(props.row.status_pengajuan)"
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
                      @click="editPengajuanDana(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deletePengajuanDana(props.row.id_pengajuan_dana)"
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