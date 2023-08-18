<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref, onMounted } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'

// types
import type { FormOptions } from '@/Pages/Main/RABPage.vue'
import type { RAP } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

interface RAPProyek {
  nama_proyek: string
  tahun_anggaran: string
}

const props = defineProps<{
  rap: RAP & RAPProyek
  options: FormOptions
}>()

const selectedProyek = {
  id_proyek: props.rap.id_proyek,
  nama_proyek: props.rap.nama_proyek,
  tahun_anggaran: props.rap.tahun_anggaran
}

onMounted(() => {
  // eslint-disable-next-line vue/no-mutating-props
  props.options.proyek.push(selectedProyek)
})

const proyekOptionsRef = ref(props.options.proyek)

function proyekFilter (val: string, update: any) {
  update(() => {
    proyekOptionsRef.value = multiFilterOptions(val, props.options.proyek, ['nama_proyek', 'tahun_anggaran'])
  })
}

const form = useForm({
  id_rap: props.rap.id_rap,
  id_proyek: props.rap.id_proyek
})

function submit () {
  form.patch(route('rap.update', props.rap.id_rap), {
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
          <div class="text-h6">Edit RAP</div>
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
              use-input
              use-chips
              emit-value
              map-options
              hide-bottom-space
              input-debounce="500"
              label="Pilih Proyek"
              v-model="form.id_proyek"
              option-value="id_proyek"
              :option-label="(opt) => `${opt.nama_proyek} | ${opt.tahun_anggaran}`"
              :options="proyekOptionsRef"
              :error="form.errors.id_proyek ? true : false"
              :error-message="form.errors.id_proyek"
              @filter="proyekFilter"
            >
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    <strong class="text-primary">
                      {{ scope.opt.nama_proyek }}
                    </strong>
                    {{ scope.opt.tahun_anggaran }}
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
            label="Update"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
