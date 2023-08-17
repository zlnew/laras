<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'

// types
import type { RAP } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  id_rap: RAP['id_rap']
}>()

const form = useForm({
  file: null
})

function submit () {
  form.post(route('detail_rap.import', props.id_rap), {
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
    <q-card style="width: 500px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Import Uraian RAP</div>
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
            <q-btn
              color="green-8"
              icon="download"
              label="Template"
              href="/storage/uploads/template_uraian_rap.xlsx"
            >
               <q-tooltip>Download template CSV/XLS</q-tooltip>
            </q-btn>

            <q-file
              outlined
              counter
              hide-bottom-space
              v-model="form.file"
              label="Pick file"
              hint="Format: csv, xls, xlsx"
              :error="form.errors.file ? true : false"
              :error-message="form.errors.file"
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
            label="Import"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
