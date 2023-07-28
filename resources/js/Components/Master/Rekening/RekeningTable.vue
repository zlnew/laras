<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3';
import { QTableColumn, useQuasar } from 'quasar';
import { ref } from 'vue';

// comps
import {
  RekeningSearchDialog,
  RekeningCreateDialog,
  RekeningEditDialog,
  RekeningDeleteDialog
} from '@/Components/Master/rekening-page';

// types
import { Rekening } from '@/types';
import { FormOptions } from '@/Pages/Master/RekeningPage.vue';

const props = defineProps<{
  rows: Array<Rekening>;
  formOptions: FormOptions;
}>();

const $q = useQuasar();

function searchRekening() {
  $q.dialog({
    component: RekeningSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  });
}

function createRekening() {
  $q.dialog({
    component: RekeningCreateDialog,
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

function editRekening(data: Rekening) {
  $q.dialog({
    component: RekeningEditDialog,
    componentProps: {
      rekening: data,
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

function deleteRekening(id_rekening: Rekening['id_rekening']) {
  $q.dialog({
    component: RekeningDeleteDialog,
    componentProps: {
      id_rekening: id_rekening
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
    name: 'index',
    label: '#',
    field: 'index'
  },
  {
    name: 'user',
    label: 'User',
    field: 'nama',
    align: 'left',
    sortable: true
  },
  { name: 'bank', label: 'Bank', field: 'nama_bank', align: 'left', sortable: true },
  { name: 'rekening', label: 'Rekening', field: 'nomor_rekening', align: 'left', sortable: true },
  { name: 'tujuan', label: 'Tujuan', field: 'tujuan_rekening', align: 'left', sortable: true },
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
      row-key="id"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 5, 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          no-caps
          label="Tambah Rekening"
          icon="add"
          color="primary"
          @click="createRekening"
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
          @click="router.visit(route('rekening'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchRekening"
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

          <q-td key="user" :props="props">
            <div>{{ props.row.nama }}</div>
            <div class="text-blue-grey-8">{{ props.row.jabatan }}</div>
          </q-td>

          <q-td key="bank" :props="props">
            <q-chip size="sm" :label="props.row.nama_bank" :ripple="false" />
          </q-td>

          <q-td key="rekening" :props="props">
            <div>{{ props.row.nomor_rekening }}</div>
            <div class="text-blue-grey-8">{{ props.row.nama_rekening }}</div>
          </q-td>
          
          <q-td key="tujuan" :props="props">
            {{ props.row.tujuan_rekening }}
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
                      @click="editRekening(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteRekening(props.row.id_rekening)"
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