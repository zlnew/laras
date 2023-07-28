<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

// utils
import { filterOptions } from '@/utils/options';

// types
import { FormOptions } from '@/Pages/Master/RekeningPage.vue';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

const props = defineProps<{
  options: FormOptions;
}>();

const banksOptionsRef = ref(props.options.banks);
const tujuanRekeningOptionsRef = ref(props.options.tujuanRekening);

function banksFilter(val: string, update: Function) {
  update(() => {
    banksOptionsRef.value = filterOptions(val, props.options.banks);
  });
}

function tujuanRekeningFilter(val: string, update: Function) {
  update(() => {
    tujuanRekeningOptionsRef.value = filterOptions(val, props.options.tujuanRekening);
  });
}

const form = useForm({
  nama: null,
  jabatan: null,
  nama_bank: null,
  nomor_rekening: null,
  nama_rekening: null,
  tujuan_rekening: null
});

function submit() {
  form.post(route('rekening.store'), {
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
          <div class="text-h6">Tambah Rekening Baru</div>
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
            <div class="row">
              <div class="col col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Nama User"
                  v-model="form.nama"
                  :error="form.errors.nama ? true : false"
                  :error-message="form.errors.nama"
                />
              </div>
              <div class="col col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Jabatan User"
                  v-model="form.jabatan"
                  :error="form.errors.jabatan ? true : false"
                  :error-message="form.errors.jabatan"
                />
              </div>
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              hide-bottom-space
              input-debounce="500"
              label="Bank"
              new-value-mode="add-unique"
              v-model="form.nama_bank"
              :options="banksOptionsRef"
              :error="form.errors.nama_bank ? true : false"
              :error-message="form.errors.nama_bank"
              @filter="banksFilter"
            > 
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Enter to add new option
                  </q-item-section>
                </q-item>
              </template>
            </q-select>

            <div class="row">
              <div class="col col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Nomor Rekening"
                  v-model="form.nomor_rekening"
                  :error="form.errors.nomor_rekening ? true : false"
                  :error-message="form.errors.nomor_rekening"
                />
              </div>
              <div class="col col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  clear-icon="close"
                  label="Nama Rekening"
                  v-model="form.nama_rekening"
                  :error="form.errors.nama_rekening ? true : false"
                  :error-message="form.errors.nama_rekening"
                />
              </div>
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              hide-bottom-space
              input-debounce="500"
              label="Tujuan Rekening"
              v-model="form.tujuan_rekening"
              :options="tujuanRekeningOptionsRef"
              :error="form.errors.tujuan_rekening ? true : false"
              :error-message="form.errors.tujuan_rekening"
              @filter="tujuanRekeningFilter"
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