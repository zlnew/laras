<script setup lang="ts">
// cores
import { QTableColumn } from 'quasar';
import { Link } from '@inertiajs/vue3';

// types
import { Reminder } from '@/Pages/Dashboard/ManajerProyekPage.vue';

defineProps<{
  rows: Array<Reminder>;
}>();

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left', sortable: true },
];
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      title="Pengajuan Ditolak/Perlu Revisi"
      :rows="rows"
      :columns="columns"
      row-key="id_pengajuan_dana"
    >
      <template v-slot:top-left>
        <div class="flex items-center q-gutter-md">
          <q-icon name="warning" size="sm" color="red"></q-icon>
          <div class="text-h6">Pengajuan Ditolak/Perlu Revisi</div>
        </div>
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

          <q-td key="proyek" :props="props">
            {{ props.row.nama_proyek }}
          </q-td>

          <q-td key="keperluan" :props="props">
            {{ props.row.keperluan }}
          </q-td>

          <q-td key="actions" :props="props">
            <Link :href="route('detail_pengajuan_dana', props.row.id_pengajuan_dana)">
              <q-btn
                flat
                dense
                no-caps
                color="primary"
              >
                Lihat Pengajuan
              </q-btn>
            </Link>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>