<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { filterOptions, multiFilterOptions } from '@/utils/options'

// types
import type { User } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

interface Options {
  pic: User[]
  penggunaJasa: string[]
}

const props = defineProps<{
  options: Options
  data: {
    route: string
  }
}>()

const picOptionsRef = ref(props.options.pic)
const penggunaJasaOptionsRef = ref(props.options.penggunaJasa)

function picFilter (val: string, update: any) {
  update(() => {
    picOptionsRef.value = multiFilterOptions(val, props.options.pic, ['id', 'name'])
  })
}

function penggunaJasaFilter (val: string, update: any) {
  update(() => {
    penggunaJasaOptionsRef.value = filterOptions(val, props.options.penggunaJasa)
  })
}

const form = useForm({
  piutang_pic: null,
  piutang_pengguna_jasa: null
})

function search () {
  form
    .transform((data) => ({
      ...data,
      piutang_query: true
    }))
    .get(props.data.route, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => { onDialogOK() }
    })
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card style="width: 400px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Pencarian Piutang</div>
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
              emit-value
              map-options
              input-debounce="500"
              label="Penanggung Jawab (PIC)"
              v-model="form.piutang_pic"
              option-value="id"
              option-label="name"
              :options="picOptionsRef"
              @filter="picFilter"
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
              use-input
              input-debounce="500"
              label="Pengguna jasa"
              v-model="form.piutang_pengguna_jasa"
              :options="penggunaJasaOptionsRef"
              @filter="penggunaJasaFilter"
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
