<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

// utils
import { toRupiah } from '@/utils/money';
import { multiFilterOptions } from '@/utils/options';

// types
import { Rekening } from '@/types';
import { daysDiff, endOfDate } from '@/utils/date';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

const props = defineProps<{
  rekening: Array<Rekening>;
}>();

const rekeningOptionsRef = ref(props.rekening);

function rekeningFilter (val: string, update: Function) {
  update(() => {
    rekeningOptionsRef.value = multiFilterOptions(
      val, props.rekening, ['nama_bank', 'nomor_rekening', 'nama_rekening']
    )
  });
}

function updateWaktuMulai (val: string) {
  form.waktu_mulai = val;

  updateDaysDiff();
}

function updateWaktuSelesai (val: string) {
  form.waktu_selesai = val;

  updateDaysDiff();
}

function updateDurasi (val: number) {
  form.durasi = val;

  updateEndOfDate();
}

function updateEndOfDate () {
  const endDate = endOfDate(form.waktu_mulai, form.durasi);

  if (endDate && endDate > form.waktu_mulai) {
    form.waktu_selesai = endDate;
  }
}

function updateDaysDiff () {
  const days = daysDiff(form.waktu_mulai, form.waktu_selesai);

  if (days >= 0) {
    form.durasi = days;
  }
}

const form = useForm({
  nama_proyek: null,
  pengguna_jasa: null,
  tahun_anggaran: null,
  nilai_kontrak: 0,
  durasi: 1,
  waktu_mulai: '',
  waktu_selesai: '',
  pic: null,
  id_rekening: null
});

function submit() {
  form
  .transform(form => ({
      ...form,
      waktu_selesai: endOfDate(form.waktu_mulai, form.durasi)
  }))
  .post(route('proyek'), {
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
          <div class="text-h6">Tambah Proyek Baru</div>
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

      <q-form @submit.prevent="submit">
        <q-card-section class="scroll">
          <div class="q-gutter-md">
            <q-input
              outlined
              autogrow
              hide-bottom-space
              clear-icon="close"
              label="Nama Proyek"
              v-model="form.nama_proyek"
              :error="form.errors.nama_proyek ? true : false"
              :error-message="form.errors.nama_proyek"
            />

            <q-input
              outlined
              hide-bottom-space
              clear-icon="close"
              label="Tahun Anggaran"
              mask="####"
              v-model="form.tahun_anggaran"
              :error="form.errors.tahun_anggaran ? true : false"
              :error-message="form.errors.tahun_anggaran"
            />

            <q-input
              outlined
              autogrow
              hide-bottom-space
              clear-icon="close"
              label="Pengguna Jasa"
              v-model="form.pengguna_jasa"
              :error="form.errors.pengguna_jasa ? true : false"
              :error-message="form.errors.pengguna_jasa"
            />

            <q-input
              outlined
              autogrow
              hide-bottom-space
              clear-icon="close"
              label="Penanggung Jawab (PIC)"
              v-model="form.pic"
              :error="form.errors.pic ? true : false"
              :error-message="form.errors.pic"
            />

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Mulai"
                  type="date"
                  :model-value="form.waktu_mulai"
                  @update:model-value="updateWaktuMulai(($event as string))"
                  :error="form.errors.waktu_mulai ? true : false"
                  :error-message="form.errors.waktu_mulai"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Durasi (Hari)"
                  min="1"
                  type="number"
                  suffix="Hari"
                  input-class="text-right"
                  :model-value="form.durasi"
                  @update:model-value="updateDurasi(($event as number))"
                  :error="form.errors.durasi ? true : false"
                  :error-message="form.errors.durasi"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Tanggal Selesai"
                  type="date"
                  :model-value="form.waktu_selesai"
                  @update:model-value="updateWaktuSelesai(($event as string))"
                  :error="form.errors.waktu_selesai ? true : false"
                  :error-message="form.errors.waktu_selesai"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  label="Nilai Kontrak"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.nilai_kontrak"
                  :hint="toRupiah(form.nilai_kontrak)"
                  :hide-hint="form.nilai_kontrak < 1"
                  :error="form.errors.nilai_kontrak ? true : false"
                  :error-message="form.errors.nilai_kontrak"
                  input-class="text-right"
                />
              </div>
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
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
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    <strong class="text-primary">
                      {{ scope.opt.nama_bank }}
                    </strong>
                    {{ scope.opt.nomor_rekening }} - {{ scope.opt.nama_rekening }}
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
        </q-card-section>

        <q-separator />
  
        <q-card-actions align="right">
          <q-btn v-if="form.hasErrors"
            flat
            label="Clear Errors"
            color="red"
            @click="form.clearErrors()"
          />
          <q-btn
            flat
            label="Reset"
            color="secondary"
            @click="form.reset()"
          />
          <q-btn
            flat
            type="submit"
            label="Submit"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>