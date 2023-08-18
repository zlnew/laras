<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { toFloat } from '@/utils/number'

// types
import { type Penagihan } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  id_penagihan: Penagihan['id_penagihan']
  jumlah_diterima: Penagihan['jumlah_diterima']
}>()

const form = useForm({
  bertahap: true,
  catatan: null,
  jumlah_diterima: props.jumlah_diterima
})

function confirm () {
  form.post(route('penagihan.confirm', props.id_penagihan), {
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
        <div class="text-h6">Action Confirmation</div>
        <q-space />
        <q-btn
          flat
          round
          dense
          icon="close"
          @click="onDialogCancel"
        />
      </q-card-section>

      <q-card-section>
        <div class="text-body">
          Are you sure want to perform this action?
        </div>
      </q-card-section>

      <q-form @submit.prevent="confirm">
        <q-card-section class="scroll">
          <div class="q-gutter-md">
            <q-input
              outlined
              hide-bottom-space
              label="Masukkan Jumlah Diterima"
              v-model="form.jumlah_diterima"
              :hint="toRupiah(toFloat(form.jumlah_diterima))"
              :error="form.errors.jumlah_diterima ? true : false"
              :error-message="form.errors.jumlah_diterima"
              input-class="text-right"
            />
            <q-input
              outlined
              autogrow
              hide-bottom-space
              label="Tambahkan Catatan"
              v-model="form.catatan"
            />
          </div>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn
            flat
            label="Cancel"
            color="secondary"
            @click="onDialogCancel"
          />
          <q-btn
            flat
            type="submit"
            label="Ok"
            color="secondary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
