<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { filterOptions, multiFilterOptions } from '@/utils/options'

// types
import { type FormOptions } from '@/Pages/Keuangan/PenagihanPage.vue'
import { type Penagihan } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  penagihan: Penagihan
  options: FormOptions
}>()

const kasMasukOptions = ['Utang', 'Setoran Modal']

const proyekOptionsRef = ref(props.options.proyek)
const kasMasukOptionsRef = ref(kasMasukOptions)

function proyekFilter (val: string, update: any) {
  update(() => {
    proyekOptionsRef.value = multiFilterOptions(val, props.options.proyek, ['nama_proyek', 'tahun_anggaran'])
  })
}

function kasMasukFilter (val: string, update: any) {
  update(() => {
    kasMasukOptionsRef.value = filterOptions(val, kasMasukOptions)
  })
}

const form = useForm({
  id_proyek: props.penagihan.id_proyek,
  keperluan: props.penagihan.keperluan,
  kas_masuk: props.penagihan.kas_masuk
})

function submit () {
  form.patch(route('penagihan.update', props.penagihan.id_penagihan), {
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
          <div class="text-h6">Edit Penagihan/Invoice</div>
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

            <q-input
              outlined
              autogrow
              hide-bottom-space
              label="Keperluan"
              v-model="form.keperluan"
              :error="form.errors.keperluan ? true : false"
              :error-message="form.errors.keperluan"
            />

            <q-select
              outlined
              clearable
              use-input
              use-chips
              hide-bottom-space
              input-debounce="500"
              label="Kas Masuk"
              v-model="form.kas_masuk"
              :options="kasMasukOptionsRef"
              :error="form.errors.kas_masuk ? true : false"
              :error-message="form.errors.kas_masuk"
              @filter="kasMasukFilter"
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
            label="Update"
            color="primary"
            :loading="form.processing"
          />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>
