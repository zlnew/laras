<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';
import { ref } from 'vue';

// utils
import { multiFilterOptions } from '@/utils/options';

// types
import { Role, User } from '@/types';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

interface UserRole {
  role_name: string;
};

const props = defineProps<{
  user: User & UserRole;
  roles: Array<Role>;
}>();

const rolesOptionsRef = ref(props.roles);

function rolesFilter(val: string, update: Function) {
  update(() => {
    rolesOptionsRef.value = multiFilterOptions(val, props.roles, ['name']);
  });
}

const form = useForm({
  id: props.user.id,
  name: props.user.name,
  email: props.user.email,
  password: null,
  role: props.user.role_name
});

function submit() {
  form.patch(route('users.update', props.user.id), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      });
    }
  });
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
          <div class="text-h6">Edit User</div>
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
              hide-bottom-space
              clear-icon="close"
              label="Name"
              v-model="form.name"
              :error="form.errors.name ? true : false"
              :error-message="form.errors.name"
            />

            <q-input
              outlined
              hide-bottom-space
              type="email"
              clear-icon="close"
              label="Email Address"
              v-model="form.email"
              :error="form.errors.email ? true : false"
              :error-message="form.errors.email"
            />

            <q-input
              outlined
              hide-bottom-space
              type="password"
              clear-icon="close"
              label="Password"
              v-model="form.password"
              :error="form.errors.password ? true : false"
              :error-message="form.errors.password"
            />

            <q-select
              outlined
              clearable
              use-input
              use-chips
              emit-value
              input-debounce="500"
              label="Role/Jabatan"
              v-model="form.role"
              option-value="name"
              option-label="name"
              :options="rolesOptionsRef"
              :error="form.errors.role ? true : false"
              :error-message="form.errors.role"
              @filter="rolesFilter"
              class="text-capitalize"
            > 
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps">
                  <q-item-section class="text-capitalize">
                    {{ scope.opt.name }}
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