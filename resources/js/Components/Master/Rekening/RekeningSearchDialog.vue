<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

// utils
import { filterOptions } from '@/utils/options';

// types
import { FormOptions } from '@/Pages/Master/RekeningPage.vue';
import { Rekening } from '@/types';

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

const page = usePage();
const params = page.props.query as Rekening;

const form = useForm({
  nama_bank: params.nama_bank,
  nomor_rekening: params.nomor_rekening,
  nama_rekening: params.nama_rekening,
  tujuan_rekening: params.tujuan_rekening
});

function submit() {
  form.get(route('rekening'), {
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
          <div class="text-h6">Pencarian Rekening</div>
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
            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              multiple
              input-debounce="500"
              label="Bank"
              v-model="form.nama_bank"
              :options="banksOptionsRef"
              @filter="banksFilter"
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
                  <q-item-section class="text-capitalize">
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

            <div class="row">
              <div class="col col-md-6 q-pr-sm">
                <q-input
                  outlined
                  clear-icon="close"
                  label="Nomor Rekening"
                  v-model="form.nomor_rekening"
                />
              </div>
              <div class="col col-md-6 q-pl-sm">
                <q-input
                  outlined
                  clear-icon="close"
                  label="Nama Rekening"
                  v-model="form.nama_rekening"
                />
              </div>
            </div>

            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              multiple
              input-debounce="500"
              label="Tujuan Rekening"
              v-model="form.tujuan_rekening"
              :options="tujuanRekeningOptionsRef"
              @filter="tujuanRekeningFilter"
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
                  <q-item-section class="text-capitalize">
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