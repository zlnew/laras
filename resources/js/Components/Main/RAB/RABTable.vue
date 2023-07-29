<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

// types
import { Proyek, RAB } from '@/types';
import { QTableColumn, useQuasar } from 'quasar';
import { FormOptions } from '@/Pages/Main/RABPage.vue';

// comps
import {
  RABSearchDialog,
  RABCreateDialog,
  RABEditDialog,
  RABDeleteDialog
} from '@/Components/Main/rab-page';
import { ProyekDetailDialog } from '@/Components/Main/proyek-page';

const props = defineProps<{
  rows: Array<RAB>;
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

function searchRAB() {
  $q.dialog({
    component: RABSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  });
}

function createRAB() {
  $q.dialog({
    component: RABCreateDialog,
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

function editRAB(data: RAB) {
  $q.dialog({
    component: RABEditDialog,
    componentProps: {
      rab: data,
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

function deleteRAB(id: RAB['id_rab']) {
  $q.dialog({
    component: RABDeleteDialog,
    componentProps: {
      id_rab: id
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
  { name: 'status_rab', label: 'Status', field: 'status_rab', align: 'left', sortable: true },
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
      row-key="id_rab"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 5, 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          no-caps
          label="Tambah RAB"
          icon="add"
          color="primary"
          @click="createRAB"
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
          @click="router.visit(route('rab'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchRAB"
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
          
          <q-td key="status_rab" :props="props">
            <q-badge
              :color="props.row.status_rab == 400 ? 'red' : 'primary'"
              :label="props.row.status_rab == 400 ? 'Closed' : 'Open'"
              v-in-link="route('detail_rab', props.row.id_rab)"
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
                      @click="editRAB(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteRAB(props.row.id_rab)"
                    >
                      Delete
                    </q-item-section>
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