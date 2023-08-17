<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'
import { toRupiah } from '@/utils/money'

// types
import { type FormOptions } from '@/Pages/Keuangan/DetailPenagihanPage.vue'
import { type Penagihan } from '@/types'
import { toFloat } from '@/utils/number'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  penagihan: Penagihan
  options: FormOptions
}>()

const rabOptionsRef = ref(props.options.detailRab)

function rabFilter (val: string, update: any) {
  update(() => {
    rabOptionsRef.value = multiFilterOptions(val, props.options.detailRab, ['uraian'])
  })
}

function getHargaSatuan (id: number) {
  const matchedItem = props.options.detailRab.find(drab => drab.id_detail_rab === id)

  // eslint-disable-next-line @typescript-eslint/strict-boolean-expressions, @typescript-eslint/prefer-optional-chain
  if (matchedItem && matchedItem.harga_satuan) {
    form.harga_satuan_penagihan = matchedItem.harga_satuan
  }
}

const form = useForm({
  id_detail_rab: null,
  volume_penagihan: '0',
  harga_satuan_penagihan: '0'
})

function submit () {
  form.post(route('detail_penagihan.store', props.penagihan.id_penagihan), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      })
    }
  })
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
          <div class="text-h6">Tambah Uraian Penagihan</div>
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
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="Uraian RAB"
              option-value="id_detail_rab"
              option-label="uraian"
              :model-value="form.id_detail_rab"
              :options="rabOptionsRef"
              :error="form.errors.id_detail_rab ? true : false"
              :error-message="form.errors.id_detail_rab"
              @filter="rabFilter"
              @update:model-value="(value) => {
                form.id_detail_rab = value;
                getHargaSatuan(value);
              }"
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
                  reverse-fill-mask
                  hide-bottom-space
                  label="Harga Satuan"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.harga_satuan_penagihan"
                  :hint="toRupiah(toFloat(form.harga_satuan_penagihan))"
                  :hide-hint="toFloat(form.harga_satuan_penagihan) < 1"
                  :error="form.errors.harga_satuan_penagihan ? true : false"
                  :error-message="form.errors.harga_satuan_penagihan"
                  input-class="text-right"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  reverse-fill-mask
                  hide-bottom-space
                  label="Volume"
                  mask="#.##"
                  fill-mask="0"
                  v-model="form.volume_penagihan"
                  :error="form.errors.volume_penagihan ? true : false"
                  :error-message="form.errors.volume_penagihan"
                  input-class="text-right"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
              </div>

              <div class="col-12 col-md-6 q-pl-sm text-right">
                <div class="text-secondary text-caption">Total Harga</div>
                <div class="text-weight-bold text-subtitle1">
                  {{ toRupiah(toFloat(form.harga_satuan_penagihan) * toFloat(form.volume_penagihan)) }}
                </div>
              </div>
            </div>
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
