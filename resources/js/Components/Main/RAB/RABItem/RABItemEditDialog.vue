<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'
import { toRupiah } from '@/utils/money'
import { toFloat } from '@/utils/number'

// types
import type { FormOptions } from '@/Pages/Main/DetailRABPage.vue'
import type { DetailRAB } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  detailRab: DetailRAB
  options: FormOptions
}>()

const satuanOptionsRef = ref(props.options.satuan)

function satuanFilter (val: string, update: any) {
  update(() => {
    satuanOptionsRef.value = multiFilterOptions(val, props.options.satuan, ['nama_satuan'])
  })
}

const form = useForm({
  uraian: props.detailRab.uraian,
  harga_satuan: props.detailRab.harga_satuan,
  volume: props.detailRab.volume,
  keterangan: props.detailRab.keterangan,
  id_satuan: props.detailRab.id_satuan
})

function submit () {
  form.patch(route('detail_rab.update', props.detailRab.id_detail_rab), {
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
          <div class="text-h6">Edit Uraian RAB</div>
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

            <q-select
              outlined
              use-input
              use-chips
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="Satuan"
              v-model="form.id_satuan"
              option-value="id_satuan"
              option-label="nama_satuan"
              :options="satuanOptionsRef"
              :error="form.errors.id_satuan ? true : false"
              :error-message="form.errors.id_satuan"
              @filter="satuanFilter"
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
                  hide-bottom-space
                  label="Harga Satuan"
                  v-model="form.harga_satuan"
                  :hint="toRupiah(toFloat(form.harga_satuan))"
                  :hide-hint="toFloat(form.harga_satuan) < 1"
                  :error="form.errors.harga_satuan ? true : false"
                  :error-message="form.errors.harga_satuan"
                  input-class="text-right"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm">
                <q-input
                  outlined
                  hide-bottom-space
                  label="Volume"
                  v-model="form.volume"
                  :error="form.errors.volume ? true : false"
                  :error-message="form.errors.volume"
                  input-class="text-right"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6 q-pr-sm">
                <q-input
                  outlined
                  autogrow
                  hide-bottom-space
                  label="Keterangan"
                  v-model="form.keterangan"
                  :error="form.errors.keterangan ? true : false"
                  :error-message="form.errors.keterangan"
                />
              </div>

              <div class="col-12 col-md-6 q-pl-sm text-right">
                <div class="text-secondary text-caption">Total Harga</div>
                <div class="text-weight-bold text-subtitle1">{{ toRupiah(toFloat(form.harga_satuan) * toFloat(form.volume)) }}</div>
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
