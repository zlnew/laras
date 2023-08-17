<script setup lang="ts">
// cores
import { useForm, usePage } from '@inertiajs/vue3'
import { useDialogPluginComponent } from 'quasar'
import { ref } from 'vue'

// utils
import { multiFilterOptions } from '@/utils/options'

// types
import type { Role, User } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent()

const props = defineProps<{
  roles: Role[]
}>()

const rolesOptionsRef = ref(props.roles)

function rolesFilter (val: string, update: any) {
  update(() => {
    rolesOptionsRef.value = multiFilterOptions(val, props.roles, ['name'])
  })
}

interface UserRole {
  role: string
}

const page = usePage()
const params = page.props.query as unknown as User & UserRole

const form = useForm({
  name: params.name,
  email: params.email,
  role: params.role
})

function submit () {
  form.get(route('users'), {
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
          <div class="text-h6">Pencarian User</div>
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
              clearable
              hide-bottom-space
              label="Name"
              v-model="form.name"
            />

            <q-input
              outlined
              clearable
              hide-bottom-space
              type="email"
              label="Email Address"
              v-model="form.email"
            />

            <q-select
              outlined
              clearable
              use-input
              use-chips
              multiple
              emit-value
              map-options
              input-debounce="500"
              label="Role/Jabatan"
              v-model="form.role"
              option-value="name"
              option-label="name"
              :options="rolesOptionsRef"
              @filter="rolesFilter"
              class="text-capitalize"
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
                  <q-item-section class="text-capitalize">
                    {{ opt.name }}
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
