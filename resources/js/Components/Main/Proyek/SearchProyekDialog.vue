<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';

// utils
import { toRupiah } from '@/utils/money';

// types
import { Proyek } from '@/types';
import { ref } from 'vue';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

interface ProyekSearch {
  nilai_kontrak_min: number;
  nilai_kontrak_max: number;
}

const props = defineProps<{
  rows: Array<Proyek>;
}>();

const penggunaJasaOptions = props.rows.reduce((group: any, product) => {
  group[product.pengguna_jasa] = [];
  group[product.pengguna_jasa].push(product.pengguna_jasa);

  return group;
}, {});

const tahunAnggaranOptions = props.rows.reduce((group: any, product) => {
  group[product.tahun_anggaran] = [];
  group[product.tahun_anggaran].push(product.tahun_anggaran);

  return group;
}, {});

const picOptions = props.rows.reduce((group: any, product) => {
  group[product.pic] = [];
  group[product.pic].push(product.pic);

  return group;
}, {});

const penggunaJasa = Object.keys(penggunaJasaOptions);
const penggunaJasaRef = ref(penggunaJasa);

const tahunAnggaran = Object.keys(tahunAnggaranOptions);
const tahunAnggaranRef = ref(tahunAnggaran);

const pic = Object.keys(picOptions);
const picRef = ref(pic);

function penggunaJasaFilterFn (val: string, update: Function) {    
  update(() => {
    const needle = val.toLowerCase();
    penggunaJasaRef.value = penggunaJasa.filter((v) => v.toLowerCase().indexOf(needle) > -1);
  });
}

function tahunAnggaranFilterFn (val: string, update: Function) {    
  update(() => {
    const needle = val.toLowerCase();
    tahunAnggaranRef.value = tahunAnggaran.filter((v) => v.toLowerCase().indexOf(needle) > -1);
  });
}

function picFilterFn (val: string, update: Function) {    
  update(() => {
    const needle = val.toLowerCase();
    picRef.value = pic.filter((v) => v.toLowerCase().indexOf(needle) > -1);
  });
}

const page = usePage();
const params = page.props.query as Proyek & ProyekSearch;

const form = useForm({
  nama_proyek: params.nama_proyek,
  pengguna_jasa: params.pengguna_jasa,
  tahun_anggaran: params.tahun_anggaran,
  nilai_kontrak_max: params.nilai_kontrak_max || 0,
  nilai_kontrak_min: params.nilai_kontrak_min || 0,
  waktu_mulai: params.waktu_mulai,
  waktu_selesai: params.waktu_selesai,
  pic: params.pic,
});

function search() {
  form.get(route('proyek'), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      });
    }
  });
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Pencarian Proyek</div>
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

      <q-form @submit.prevent="search">
        <q-card-section class="scroll">
          <div class="q-gutter-md">
            <q-input
              outlined
              clearable
              autogrow
              hide-bottom-space
              clear-icon="close"
              label="Nama Proyek"
              v-model="form.nama_proyek"
            />

            <q-select
              outlined
              clearable
              hide-bottom-space
              use-input
              fill-input
              hide-selected
              input-debounce="0"
              mask="####"
              label="Tahun Anggaran"
              v-model="form.tahun_anggaran"
              :options="tahunAnggaranRef"
              @filter="tahunAnggaranFilterFn"
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
              outlined
              clearable
              hide-bottom-space
              use-input
              fill-input
              hide-selected
              input-debounce="0"
              label="Pengguna jasa"
              v-model="form.pengguna_jasa"
              :options="penggunaJasaRef"
              @filter="penggunaJasaFilterFn"
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
              outlined
              clearable
              hide-bottom-space
              use-input
              fill-input
              hide-selected
              input-debounce="0"
              label="Penanggung Jawab (PIC)"
              v-model="form.pic"
              :options="picRef"
              @filter="picFilterFn"
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  clearable
                  hide-bottom-space
                  label="Tanggal Mulai"
                  type="date"
                  v-model="form.waktu_mulai"
                />
              </div>
              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  clearable
                  hide-bottom-space
                  label="Tanggal Selesai"
                  type="date"
                  v-model="form.waktu_selesai"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  label="Nilai Kontrak Min"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.nilai_kontrak_min"
                  :hint="toRupiah(form.nilai_kontrak_min)"
                  :hide-hint="form.nilai_kontrak_min < 1"
                  input-class="text-right"
                />
              </div>
              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  label="Nilai Kontrak Max"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.nilai_kontrak_max"
                  :hint="toRupiah(form.nilai_kontrak_max)"
                  :hide-hint="form.nilai_kontrak_max < 1"
                  input-class="text-right"
                />
              </div>
            </div>
          </div>
        </q-card-section>

        <q-separator />
  
        <q-card-actions align="right">
          <q-btn
            flat
            type="submit"
            label="Search"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>