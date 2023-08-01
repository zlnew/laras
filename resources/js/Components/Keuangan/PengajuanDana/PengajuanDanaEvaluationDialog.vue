<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3';
import { QTableColumn, useDialogPluginComponent } from 'quasar';

// utils
import { toRupiah } from '@/utils/money';

// types
import { Evaluasi } from '@/Pages/Keuangan/DetailPengajuanDanaPage.vue';
import { DetailPengajuanDana, PengajuanDana } from '@/types';
import { ref } from 'vue';
import { computed } from 'vue';
import { ApprovedPengajuanSaatIni } from './PengajuanDanaItem/PengajuanDanaItemTable.vue';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

interface JoinedWithEvaluasi {
  total_harga: number;
  pengajuan_lalu: number;
  pengajuan_saat_ini: number;
  total_pengajuan: number;
  sisa_anggaran: number;
}

const props = defineProps<{
  data: {
    id_pengajuan_dana: PengajuanDana['id_pengajuan_dana'];
    selected_ids_detail_pengajuan_dana: Array<DetailPengajuanDana['id_detail_pengajuan_dana']> | undefined;
    approvedPengajuanSaatIni: Array<ApprovedPengajuanSaatIni> | undefined;
    evaluasi: Array<Evaluasi & JoinedWithEvaluasi>;
  };
}>();

const evaluasi = computed(() => {
  return props.data.evaluasi.map((evaluasiItem) => {
    evaluasiItem.pengajuan_saat_ini = 0;

    if (props.data.approvedPengajuanSaatIni) {
      const matchedItem = props.data.approvedPengajuanSaatIni.find(
        (approvedItem) => approvedItem.id_detail_rap === evaluasiItem.id_detail_rap
      );

      if (matchedItem) {
        evaluasiItem.pengajuan_saat_ini += matchedItem.jumlah_pengajuan;
      }
    }

    const pengajuanLalu = evaluasiItem.pengajuan_lalu ? parseFloat(evaluasiItem.pengajuan_lalu.toString()) : 0;
    const total_pengajuan = pengajuanLalu + evaluasiItem.pengajuan_saat_ini;
    const sisa_anggaran = evaluasiItem.total_harga - total_pengajuan;

    return {
      ...evaluasiItem,
      total_pengajuan: total_pengajuan,
      sisa_anggaran: sisa_anggaran
    };
  });
});

const form = useForm({
  selected_ids_detail_pengajuan_dana: props.data.selected_ids_detail_pengajuan_dana,
  catatan: null
});

function evaluate() {  
  form.post(route('pengajuan_dana.evaluate', props.data.id_pengajuan_dana), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      });
    }
  });
}

function reject() {
  form.post(route('pengajuan_dana.reject', props.data.id_pengajuan_dana), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      });
    }
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
  { name: 'nama_satuan', label: 'Satuan', field: 'nama_satuan', align: 'left', sortable: true },
  { name: 'harga_satuan', label: 'Harga Satuan', field: 'harga_satuan', align: 'right', sortable: true },
  { name: 'volume', label: 'Volume', field: 'volume', align: 'left', sortable: true },
  { name: 'total_harga', label: 'Total Harga', field: 'total_harga', align: 'right', sortable: true },
  { name: 'pengajuan_lalu', label: 'Pengajuan Sebelumnya', field: 'pengajuan_lalu', align: 'right', sortable: true },
  { name: 'pengajuan_saat_ini', label: 'Pengajuan Saat Ini', field: '', align: 'right', sortable: true },
  { name: 'total_pengajuan', label: 'Total Pengajuan', field: '', align: 'right', sortable: true },
  { name: 'sisa_anggaran', label: 'Sisa Anggaran', field: '', align: 'right', sortable: true },
];

const filter = ref();
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card style="max-width: 100vw">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Lembar Evaluasi</div>
          <q-space />
          <q-btn
            flat
            round
            dense
            icon="close"
            @click="onDialogCancel"
          />
        </q-card-section>

      <q-separator />

      <q-card-section class="scroll">
        <div class="q-gutter-md">
            <q-table
            flat
            bordered
            row-key="id_detail_rap"
            :rows="evaluasi"
            :columns="columns"
            :filter="filter"
            :rows-per-page-options="[ 0 ]"
            title="Evaluasi Pengajuan Dana"
            style="max-height: 100vh"
            virtual-scroll
          >
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
                  {{ toRupiah(props.row.total_harga) }}
                </q-td>

                <q-td key="pengajuan_lalu" :props="props">
                  {{ toRupiah(props.row.pengajuan_lalu) }}
                </q-td>

                <q-td key="pengajuan_saat_ini" :props="props">
                  {{ toRupiah(props.row.pengajuan_saat_ini || 0) }}
                </q-td>

                <q-td key="total_pengajuan" :props="props">
                  {{ toRupiah(props.row.total_pengajuan) }}
                </q-td>

                <q-td key="sisa_anggaran" :props="props">
                  {{ toRupiah(props.row.sisa_anggaran) }}
                </q-td>
              </q-tr>
            </template>
          </q-table>
        </div>
      </q-card-section>

      <q-card-section>
        <div class="q-gutter-md">
          <q-input
            outlined
            autogrow
            label="Catatan"
            v-model="form.catatan"
          />
        </div>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn
          flat
          label="Tolak"
          color="red"
          :loading="form.processing"
          :disable="data.selected_ids_detail_pengajuan_dana?.length ? true : false"
          @click="reject"
        />
        <q-btn
          flat
          label="Approve"
          color="primary"
          :loading="form.processing"
          :disable="data.selected_ids_detail_pengajuan_dana?.length ? false : true"
          @click="evaluate"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>