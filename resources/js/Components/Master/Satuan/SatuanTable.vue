<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3';
import { QTableColumn, useQuasar } from 'quasar';
import { ref } from 'vue';

// comps
import {
  SatuanCreateDialog,
  SatuanEditDialog,
  SatuanDeleteDialog
} from '@/Components/Master/satuan-page';

// types
import { Satuan } from '@/types';

const props = defineProps<{
  rows: Array<Satuan>;
}>();

const $q = useQuasar();

function createSatuan() {
  $q.dialog({
    component: SatuanCreateDialog,
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function editSatuan(data: Satuan) {
  $q.dialog({
    component: SatuanEditDialog,
    componentProps: {
      satuan: data,
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function deleteSatuan(id_satuan: Satuan['id_satuan']) {
  $q.dialog({
    component: SatuanDeleteDialog,
    componentProps: {
      id_satuan: id_satuan
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
    name: 'nama_satuan',
    label: 'Nama Satuan',
    field: 'nama_satuan',
    align: 'left',
    sortable: true
  },
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
          label="Tambah Satuan"
          icon="add"
          color="primary"
          @click="createSatuan"
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
          @click="router.visit(route('satuan'))"
        />
        <!-- <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchRekening"
        /> -->
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
          
          <q-td key="nama_satuan" :props="props">
            {{ props.row.nama_satuan }}
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
                      @click="editSatuan(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteSatuan(props.row.id_satuan)"
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