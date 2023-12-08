<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { sanitizeUsNumber, toFloat } from '@/utils/number'

// types
import { type DetailPenagihan } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  detailPenagihan: DetailPenagihan
}>()

async function onChangeHargaSatuan (amount: string | number | null) {
  if (typeof amount === 'string') {
    const formattedAmount = await sanitizeUsNumber(amount)
    form.harga_satuan_penagihan = formattedAmount
  }
}

const form = useForm({
  uraian: props.detailPenagihan.uraian,
  volume_penagihan: toFloat(props.detailPenagihan.volume_penagihan),
  harga_satuan_penagihan: toFloat(props.detailPenagihan.harga_satuan_penagihan)
})

function submit () {
  form.patch(route('detail_penagihan.update', props.detailPenagihan.id_detail_penagihan), {
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
          <div class="text-h6">Edit Uraian Penagihan</div>
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
              label="Uraian"
              v-model="form.uraian"
              :error="form.errors.uraian ? true : false"
              :error-message="form.errors.uraian"
            />

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Harga Satuan"
                  v-model="form.harga_satuan_penagihan"
                  :hint="toRupiah(form.harga_satuan_penagihan)"
                  :hide-hint="form.harga_satuan_penagihan < 1"
                  :error="form.errors.harga_satuan_penagihan ? true : false"
                  :error-message="form.errors.harga_satuan_penagihan"
                  input-class="text-right"
                  @update:model-value="(val) => onChangeHargaSatuan(val)"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Volume"
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
                <div class="text-weight-bold text-subtitle1">{{ toRupiah(form.harga_satuan_penagihan * form.volume_penagihan) }}</div>
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
            label="Update"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
