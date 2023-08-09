<script setup lang="ts">
// cores
import { ref, computed } from 'vue';

// utils
import { toFloat } from '@/utils/number';
import { toRupiah } from '@/utils/money';

// types
import { QTable, QTableColumn } from 'quasar';
import { SisaDanaRekening } from '@/Pages/Dashboard/KeuanganPage.vue';

const props = defineProps<{
  rows: Array<SisaDanaRekening>;
}>();

const rows = computed(() => {
  return props.rows.map(item => {
    const modal = toFloat(item.total_pengajuan_dana) + toFloat(item.total_penagihan);
    const pemasukan = toFloat(item.total_pencairan_dana) + toFloat(item.total_penagihan_diterima);

    return {
      ...item,
      sisa_dana: modal - pemasukan
    }
  });
});

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'rekening', label: 'Rekening', field: 'nama_rekening', align: 'left', sortable: true },
  { name: 'sisa_dana', label: 'Sisa Dana', field: '', align: 'right', sortable: true },
];

const tableFullscreen = ref(false);

function toggleFullscreen() {
  tableFullscreen.value = !tableFullscreen.value;
}

const table = ref<QTable>();

const totaAmount = computed(() => {
  const sisa_dana = table.value?.computedRows.reduce((total, item) => {    
    return total + toFloat(item.sisa_dana);
  }, 0);

  return {
    sisa_dana: sisa_dana,
  }
});
</script>

<template>
  <q-table
    ref="table"
    flat
    bordered
    title="Sisa Dana Rekening"
    :fullscreen="tableFullscreen"
    :rows="rows"
    :columns="columns"
    row-key="id_rekening"
    class="table"
  >
    <template v-slot:top-right>
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

        <q-td key="rekening" :props="props">
            <span class="text-caption text-weight-bold">
              {{ props.row.nama_bank }}
            </span> |
            <span class="text-caption">
              {{ props.row.nomor_rekening }}
            </span> -
            {{ props.row.nama_rekening }}
        </q-td>

        <q-td key="sisa_dana" :props="props">
          {{ toRupiah(props.row.sisa_dana) }}
        </q-td>
      </q-tr>
    </template>

    <template v-slot:bottom-row>
      <q-tr no-hover class="text-weight-bold text-right">
        <q-td colspan="2">Total Sisa Dana</q-td>
        <q-td>
          {{ toRupiah(totaAmount.sisa_dana) }}
        </q-td>
      </q-tr>
    </template>
  </q-table>
</template>

<style lang="sass">
.table

  td:last-child
    background-color: #fff

  tr th
    position: sticky
    z-index: 2
    background: #fff

  thead tr:last-child th
    top: 48px
    z-index: 3

  thead tr:first-child th
    top: 0
    z-index: 1
    
  tr:last-child th:last-child
    z-index: 3

  td:last-child
    z-index: 1

  td:last-child, th:last-child
    position: sticky
    right: 0

  tbody
    scroll-margin-top: 48px
</style>