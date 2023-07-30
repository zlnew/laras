<script setup lang="ts">
// cores
import { ref, computed } from 'vue';
import { QTableColumn, useQuasar } from 'quasar';
import { useForm } from '@inertiajs/vue3';

// utils
import { toRupiah } from '@/utils/money';
import { can, isAdmin, isEditable } from '@/utils/permissions';

// types
import { DetailRAB, DetailRAP, RAB, RAP } from '@/types';
import { FormOptions } from '@/Pages/Main/RAPPage.vue';

// comps
import {
  RAPItemCreateDialog,
  RAPItemEditDialog,
  RAPItemDeleteDialog
} from '@/Components/Main/detail-rap-page';

interface Data {
  rap: RAP;
  rab: RAB;
  detailRab: Array<DetailRAB>;
}

const props = defineProps<{
  rows: Array<DetailRAP>;
  data: Data;
  formOptions: FormOptions; 
}>();

const totalAmount = computed(() => {
  const rap = props.rows.reduce((total, item) => {
    return total + (item.harga_satuan * item.volume);
  }, 0);

  const rab = props.data.detailRab.reduce((total, item) => {
    return total + (item.harga_satuan * item.volume);
  }, 0);

  const pph = (props.data.rab.additional_tax / 100) * rab;
  const netto = rab - pph;
  const laba = netto - rap;
  const labaPercentage = (laba / netto) * 100;

  return {
    rap: rap,
    netto: netto,
    laba: laba,
    labaPercentage: labaPercentage
  }
});

const $q = useQuasar();

function createRAPItem() {
  $q.dialog({
    component: RAPItemCreateDialog,
    componentProps: {
      rap: props.data.rap,
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

function editRAPItem(data: DetailRAP) {
  $q.dialog({
    component: RAPItemEditDialog,
    componentProps: {
      detailRap: data,
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

function deleteRAPItem(id: DetailRAP['id_detail_rap']) {
  $q.dialog({
    component: RAPItemDeleteDialog,
    componentProps: {
      id_detail_rap: id
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
    name: 'uraian',
    label: 'Uraian',
    field: 'uraian',
    align: 'left',
    sortable: true
  },
  { name: 'status_uraian', label: 'Status', field: 'status_uraian', align: 'left', sortable: true },
  { name: 'nama_satuan', label: 'Satuan', field: 'nama_satuan', align: 'left', sortable: true },
  { name: 'harga_satuan', label: 'Harga Satuan', field: 'harga_satuan', align: 'right', sortable: true },
  { name: 'volume', label: 'Volume', field: 'volume', align: 'left', sortable: true },
  { name: 'total_harga', label: 'Total Harga', field: '', align: 'right', sortable: true },
  { name: 'keterangan', label: 'Ket', field: 'keterangan', align: 'left', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
];

const tableFullscreen = ref(false);

function toggleFullscreen() {
  tableFullscreen.value = !tableFullscreen.value;
}

const filter = ref('');
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      row-key="id_detail_rap"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
      :filter="filter"
    >
      <template v-slot:top-left>
        <div class="q-gutter-sm">
          <q-btn
            v-if="isAdmin() ? true : can('create & modify rap') && isEditable(data.rap.status_aktivitas)"
            no-caps
            label="Tambah Uraian RAP"
            icon="add"
            color="primary"
            @click="createRAPItem"
          />
        </div>
      </template>

      <template v-slot:top-right>
        <q-input
          dense
          debounce="300"
          v-model="filter"
          placeholder="Search"
        >
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>

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

          <q-td key="uraian" :props="props">
            {{ props.row.uraian }}
          </q-td>

          <q-td key="status_uraian" :props="props">
            {{ props.row.status_uraian }}
          </q-td>

          <q-td key="nama_satuan" :props="props">
            {{ props.row.nama_satuan }}
          </q-td>

          <q-td key="harga_satuan" :props="props">
            {{ toRupiah(props.row.harga_satuan) }}
          </q-td>

          <q-td key="volume" :props="props">
            {{ props.row.volume }}
          </q-td>

          <q-td key="total_harga" :props="props">
            {{ toRupiah(props.row.harga_satuan * props.row.volume) }}
          </q-td>

          <q-td key="keterangan" :props="props">
            {{ props.row.keterangan }}
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify rap') && isEditable(data.rap.status_aktivitas)"
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
                      @click="editRAPItem(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />
                  
                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteRAPItem(props.row.id_detail_rap)"
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

      <template v-if="rows.length" v-slot:bottom-row>
        <q-tr no-hover>
          <q-td colspan="5" style="border: none;"></q-td>
          <q-td class="text-right">
            Total RAP
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.rap) }}
          </q-td>
          <q-td colspan="2" style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="5" style="border: none;"></q-td>
          <q-td class="text-right">
            Nilai Netto
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.netto) }}
          </q-td>
          <q-td colspan="2" style="border: none;"></q-td>
        </q-tr>

        <q-tr no-hover>
          <q-td colspan="5" style="border: none;"></q-td>
          <q-td class="text-right">
            Proyeksi Laba
          </q-td>
          <q-td class="text-right text-weight-bold">
            {{ toRupiah(totalAmount.laba) }}
            <span class="text-caption">
              ({{ totalAmount.labaPercentage.toFixed(2) + '%' }})
            </span>
          </q-td>
          <q-td colspan="2" style="border: none;"></q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>