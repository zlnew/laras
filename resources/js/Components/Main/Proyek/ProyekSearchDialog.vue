<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { computed, ref } from 'vue';

// utils
import { toRupiah } from '@/utils/money';
import { filterOptions, multiFilterOptions } from '@/utils/options';
import { FormOptions } from '@/Pages/Main/ProyekPage.vue';

// types
import { Proyek } from '@/types';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

interface ProyekSearch {
  nilai_kontrak_min: number;
  nilai_kontrak_max: number;
  rekening: string;
}

const props = defineProps<{
  rows: Array<Proyek>;
  options: FormOptions;
}>();

const penggunaJasaOptionsRef = ref(props.options.penggunaJasa);
const penyediaJasaOptionsRef = ref(props.options.penyediaJasa);
const tahunAnggaranOptionsRef = ref(props.options.tahunAnggaran);
const picOptionsRef = ref(props.options.currentPic);
const rekeningOptionsRef = ref(props.options.rekening);

function penggunaJasaFilter (val: string, update: Function) {
  update(() => {
    penggunaJasaOptionsRef.value = filterOptions(val, props.options.penggunaJasa)
  });
}

function penyediaJasaFilter (val: string, update: Function) {
  update(() => {
    penyediaJasaOptionsRef.value = filterOptions(val, props.options.penyediaJasa)
  });
}

function tahunAnggaranFilter (val: string, update: Function) {
  update(() => {
    tahunAnggaranOptionsRef.value = filterOptions(val, props.options.tahunAnggaran)
  });
}

function picFilter (val: string, update: Function) {
  update(() => {
    picOptionsRef.value = multiFilterOptions(
      val, props.options.currentPic, ['id', 'name']
    )
  });
}

function rekeningFilter (val: string, update: Function) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(
      val, props.options.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening']
    )
  });
}

const page = usePage();
const params = page.props.query as Proyek & ProyekSearch;

const pic = computed(() => {
  return props.options.currentPic.find(item => item.id == params.id_user);
});

const form = useForm({
  nama_proyek: params.nama_proyek,
  nomor_kontrak: params.nomor_kontrak,
  tanggal_kontrak: params.tanggal_kontrak,
  pengguna_jasa: params.pengguna_jasa,
  penyedia_jasa: params.penyedia_jasa,
  tahun_anggaran: params.tahun_anggaran,
  nomor_spmk: params.nomor_spmk,
  tanggal_spmk: params.tanggal_spmk,
  nilai_kontrak_min: params.nilai_kontrak_min || 0,
  nilai_kontrak_max: params.nilai_kontrak_max || 0,
  tanggal_mulai: params.tanggal_mulai,
  tanggal_selesai: params.tanggal_selesai,
  id_user: pic.value,
  id_rekening: params.id_rekening,
  status_proyek: params.status_proyek
});

function search() {
  form
  .transform(form => ({
    ...form,
    nilai_kontrak_min: form.nilai_kontrak_min === 0 ? undefined : form.nilai_kontrak_min,
    nilai_kontrak_max: form.nilai_kontrak_max === 0 ? undefined : form.nilai_kontrak_max
  }))
  .get(route('proyek'), {
    onSuccess: () => onDialogOK()
  });
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
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
              clear-icon="close"
              label="Nama Proyek"
              v-model="form.nama_proyek"
            />

            <div class="row">
              <div class="col col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Nomor Kontrak"
                  v-model="form.nomor_kontrak"
                  :error="form.errors.nomor_kontrak ? true : false"
                  :error-message="form.errors.nomor_kontrak"
                />
              </div>

              <div class="col col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Nomor SPMK"
                  v-model="form.nomor_spmk"
                  :error="form.errors.nomor_spmk ? true : false"
                  :error-message="form.errors.nomor_spmk"
                />
              </div>
            </div>

            <div class="row">
              <div class="col col-md-6 q-pr-sm">
                <q-select
                  outlined
                  clearable
                  use-input
                  use-chips
                  multiple
                  input-debounce="500"
                  label="Pengguna jasa"
                  v-model="form.pengguna_jasa"
                  :options="penggunaJasaOptionsRef"
                  @filter="penggunaJasaFilter"
                >
                  <template v-slot:option="{itemProps, opt, selected, toggleOption}">
                    <q-item v-bind="itemProps">
                      <q-item-section side>
                        <q-checkbox
                          size="sm"
                          :model-value="selected"
                          @update:model-value="toggleOption(opt)"
                        />
                      </q-item-section>
                      <q-item-section>
                        {{ opt }}
                      </q-item-section>
                    </q-item>
                  </template>
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        No results
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </div>
              <div class="col col-md-6 q-pl-sm">
                <q-select
                  outlined
                  clearable
                  use-input
                  use-chips
                  multiple
                  input-debounce="500"
                  label="Penyedia jasa"
                  v-model="form.penyedia_jasa"
                  :options="penyediaJasaOptionsRef"
                  @filter="penyediaJasaFilter"
                >
                  <template v-slot:option="{itemProps, opt, selected, toggleOption}">
                    <q-item v-bind="itemProps">
                      <q-item-section side>
                        <q-checkbox
                          size="sm"
                          :model-value="selected"
                          @update:model-value="toggleOption(opt)"
                        />
                      </q-item-section>
                      <q-item-section>
                        {{ opt }}
                      </q-item-section>
                    </q-item>
                  </template>
                  <template v-slot:no-option>
                    <q-item>
                      <q-item-section class="text-grey">
                        No results
                      </q-item-section>
                    </q-item>
                  </template>
                </q-select>
              </div>
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
              multiple
              input-debounce="500"
              label="Tahun Anggaran"
              v-model="form.tahun_anggaran"
              :options="tahunAnggaranOptionsRef"
              @filter="tahunAnggaranFilter"
            >
              <template v-slot:option="{itemProps, opt, selected, toggleOption}">
                <q-item v-bind="itemProps">
                  <q-item-section side>
                    <q-checkbox
                      size="sm"
                      :model-value="selected"
                      @update:model-value="toggleOption(opt)"
                    />
                  </q-item-section>
                  <q-item-section>
                    {{ opt }}
                  </q-item-section>
                </q-item>
              </template>
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
              use-input
              use-chips
              emit-value
              map-options
              input-debounce="500"
              label="Penanggung Jawab (PIC)"
              v-model="form.id_user"
              option-value="id"
              option-label="name"
              :options="picOptionsRef"
              @filter="picFilter"
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
  
                  label="Tanggal Mulai"
                  type="date"
                  v-model="form.tanggal_mulai"
                />
              </div>
              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  clearable
  
                  label="Tanggal Selesai"
                  type="date"
                  v-model="form.tanggal_selesai"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  mask="#.##"
                  fill-mask="0"
                  label="Nilai Kontrak Min"
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

            <q-select
              outlined
              clearable
              use-input
              use-chips
              multiple
              emit-value
              map-options
              input-debounce="500"
              label="Rekening Pembayaran"
              v-model="form.id_rekening"
              option-value="id_rekening"
              :option-label="(opt) => `${opt.nama_bank} | ${opt.nomor_rekening} - ${opt.nama_rekening}`"
              :options="rekeningOptionsRef"
              @filter="rekeningFilter"
            >              
              <template v-slot:option="{itemProps, opt, selected, toggleOption}">
                <q-item v-bind="itemProps">
                  <q-item-section side>
                    <q-checkbox
                      size="sm"
                      :model-value="selected"
                      @update:model-value="toggleOption(opt)"
                    />
                  </q-item-section>
                  <q-item-section>
                    <strong class="text-primary">
                      {{ opt.nama_bank }}
                    </strong>
                    {{ opt.nomor_rekening }} - {{ opt.nama_rekening }}
                  </q-item-section>
                </q-item>
              </template>

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
              fill-input
              label="Status Proyek"
              v-model="form.status_proyek"
              :options="[100, 400]"
            >
              <template v-slot:selected-item="scope">
                <q-badge
                  :color="scope.opt == 400 ? 'red' : 'primary'"
                  :label="scope.opt == 400 ? 'Closed' : 'On Progress'"
                />
              </template>

              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    {{ scope.opt == 400 ? 'Closed' :  'On Progress'}}
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
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