<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'

// types
import { type PengajuanDana } from '@/types'
import { type FormOptions } from '@/Pages/Keuangan/PengajuanDanaPage.vue'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  options: FormOptions
}>()

const proyekOptionsRef = ref(props.options.currentProyek)

function proyekFilter (val: string, update: any) {
  update(() => {
    proyekOptionsRef.value = multiFilterOptions(val, props.options.currentProyek, ['nama_proyek', 'tahun_anggaran'])
  })
}

const page = usePage()
const params = page.props.query as unknown as PengajuanDana

const form = useForm({
  id_proyek: params.id_proyek,
  status_pengajuan: params.status_pengajuan,
  ditolak: false
})

function search () {
  form.get(route('pengajuan_dana'), {
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
          <div class="text-h6">Pencarian Pengajuan Dana</div>
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
              fill-input
              label="Status Pengajuan Dana"
              v-model="form.status_pengajuan"
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
              label="Hanya tampilkan Pengajuan Dana yang ditolak"
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
