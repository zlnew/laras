<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'

// types
import { type DetailPencairanDana, type PencairanDana } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  id_pencairan_dana: PencairanDana['id_pencairan_dana']
  id_detail_pengajuan_dana: DetailPencairanDana['id_detail_pencairan_dana']
}>()

const form = useForm({
  id_detail_pengajuan_dana: props.id_detail_pengajuan_dana,
  jumlah_pencairan: 0
})

function submit () {
  form.post(route('detail_pencairan_dana.store', props.id_pencairan_dana), {
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
    <q-card style="width: 400px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Pencairan Dana</div>
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
              reverse-fill-mask
              hide-bottom-space
              label="Masukkan Jumlah Pencairan"
              mask="#.##"
              fill-mask="0"
              v-model="form.jumlah_pencairan"
              :hint="toRupiah(form.jumlah_pencairan)"
              :hide-hint="form.jumlah_pencairan < 1"
              :error="form.errors.jumlah_pencairan ? true : false"
              :error-message="form.errors.jumlah_pencairan"
              input-class="text-right"
            />
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
            label="Confirm"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
