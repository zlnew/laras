<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3';

// utils
import { toFloat } from '@/utils/number';
import { toRupiah } from '@/utils/money';

// types
import { QTableColumn } from 'quasar';
import { Options, Piutang } from '@/Pages/Dashboard/KepalaDivisiPage.vue';
import { ref } from 'vue';
import { filterOptions, multiFilterOptions } from '@/utils/options';

const props = defineProps<{
  rows: Array<Piutang>;
  options: Options
}>();

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'proyek', label: 'Proyek', field: 'nama_proyek', align: 'left', sortable: true },
  { name: 'keperluan', label: 'Keperluan', field: 'keperluan', align: 'left', sortable: true },
  { name: 'jumlah_piutang', label: 'Jumlah Piutang', field: 'jumlah_piutang', align: 'right', sortable: true },
];

const picOptionsRef = ref(props.options.pic);
const penggunaJasaOptionsRef = ref(props.options.penggunaJasa);

function picFilter (val: string, update: Function) {
  update(() => {
    picOptionsRef.value = multiFilterOptions(val, props.options.pic, ['id', 'name']);
  });
}

function penggunaJasaFilter (val: string, update: Function) {
  update(() => {
    penggunaJasaOptionsRef.value = filterOptions(val, props.options.penggunaJasa);
  });
}

const page = usePage();

interface SearchParams {
  piutang_pengguna_jasa: string;
  piutang_pic: number;
}

const params = page.props.query as SearchParams;

const form = useForm({
  piutang_query: true,
  piutang_pengguna_jasa: params.piutang_pengguna_jasa,
  piutang_pic: params.piutang_pic
});

function search() {
  form.get(route('dashboard.kepala_divisi'), {
    preserveScroll: true
  });
}
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      title="Daftar Piutang"
      :rows="rows"
      :columns="columns"
      row-key="id_penagihan"
    >
      <template v-slot:top-right>
        <div class="row items-center q-col-gutter-sm">
          <div class="text-caption">Filter By</div>
          <q-select
            dense
            filled
            use-input
            input-debounce="500"
            label="Pengguna Jasa"
            v-model="form.piutang_pengguna_jasa"
            :options="penggunaJasaOptionsRef"
            @filter="penggunaJasaFilter"
            @update:model-value="search()"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
  
          <q-select
            dense
            filled
            use-input
            emit-value
            map-options
            input-debounce="500"
            label="PIC"
            v-model="form.piutang_pic"
            option-label="name"
            :options="picOptionsRef"
            @filter="picFilter"
            @update:model-value="search()"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
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

          <q-td key="jumlah_piutang" :props="props">
            {{ toRupiah(toFloat(props.row.jumlah_piutang)) }}
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>