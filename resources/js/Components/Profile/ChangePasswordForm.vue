<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useQuasar } from 'quasar'

const $q = useQuasar()

const form = useForm({
  current_password: null,
  password: null,
  confirmed_password: null
})

function save () {
  form.patch(route('password.update'), {
    onSuccess: (page) => {
      $q.notify({
        color: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}
</script>

<template>
  <q-card flat bordered>
    <q-card-section>
      <div class="text-h6">Change Password</div>
    </q-card-section>

    <q-form @submit.prevent="save">
      <q-card-section>
        <div class="q-gutter-md">
          <q-input
            outlined
            hide-bottom-space
            v-model="form.current_password"
            type="password"
            label="Current Password"
            :error="form.errors.current_password ? true : false"
            :error-message="form.errors.current_password"
          />

          <q-input
            outlined
            hide-bottom-space
            v-model="form.password"
            type="password"
            label="New Password"
            :error="form.errors.password ? true : false"
            :error-message="form.errors.password"
          />

          <q-input
            outlined
            hide-bottom-space
            v-model="form.confirmed_password"
            type="password"
            label="Confirm New Password"
            :error="form.errors.confirmed_password ? true : false"
            :error-message="form.errors.confirmed_password"
          />
        </div>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn
          flat
          color="primary"
          type="submit"
          label="Change"
          :loading="form.processing"
        />
      </q-card-actions>
    </q-form>
  </q-card>
</template>
