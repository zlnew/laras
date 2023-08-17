<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { filterOptions, multiFilterOptions } from '@/utils/options'

// types
import { type Penagihan } from '@/types'
import { type FormOptions } from '@/Pages/Keuangan/PenagihanPage.vue'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  options: FormOptions
}>()

const kasMasukOptions = ['Utang', 'Setoran Modal']

const proyekOptionsRef = ref(props.options.currentProyek)
const kasMasukOptionsRef = ref(kasMasukOptions)

function proyekFilter (val: string, update: any) {
  update(() => {
    proyekOptionsRef.value = multiFilterOptions(val, props.options.currentProyek, ['nama_proyek', 'tahun_anggaran'])
  })
}

function kasMasukFilter (val: string, update: any) {
  update(() => {
    kasMasukOptionsRef.value = filterOptions(val, kasMasukOptions)
  })
}

const page = usePage()
const params = page.props.query as unknown as Penagihan

const form = useForm({
  id_proyek: params.id_proyek,
  kas_masuk: params.kas_masuk,
  status_penagihan: params.status_penagihan,
  ditolak: false
})

function search () {
  form.get(route('penagihan'), {
    onSuccess: () => { onDialogOK() }
  })
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Pencarian Penagihan</div>
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

      <q-form @submit.prevent="search">
        <q-card-section class="scroll">
          <div class="q-gutter-md">
            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              map-options
              multiple
              hide-bottom-space
              input-debounce="500"
              label="Proyek"
              v-model="form.id_proyek"
              option-value="id_proyek"
              :option-label="(opt) => `${opt.nama_proyek} | ${opt.tahun_anggaran}`"
              :options="proyekOptionsRef"
              :error="form.errors.id_proyek ? true : false"
              :error-message="form.errors.id_proyek"
              @filter="proyekFilter"
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
                  <q-item-section>
                    <strong class="text-primary">
                      {{ opt.nama_proyek }}
                    </strong>
                    {{ opt.tahun_anggaran }}
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

            <q-select
              outlined
              clearable
              fill-input
              label="Status Penagihan"
              v-model="form.status_penagihan"
              :options="[100, 400]"
            >
              <template v-slot:selected-item="scope">
                <q-badge
                  :color="scope.opt == 400 ? 'red' : 'primary'"
                  :label="scope.opt == 400 ? 'Closed' : 'Open'"
                />
              </template>

              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section>
                    {{ scope.opt == 400 ? 'Closed' :  'Open'}}
                  </q-item-section>
                </q-item>
              </template>
            </q-select>

            <q-toggle
              checked-icon="check"
              unchecked-icon="clear"
              label="Hanya tampilkan Penagihan yang ditolak"
              v-model="form.ditolak"
            />
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
