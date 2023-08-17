<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3'
import { useQuasar } from 'quasar'

// utils
import { avatar } from '@/utils/avatar'

// types
import type { User } from '@/types'

const props = defineProps<{
  data: {
    user: User
    role: string
  }
}>()

const $q = useQuasar()

const form = useForm({
  name: props.data.user.name,
  email: props.data.user.email
})

function save () {
  form.patch(route('profile.update'), {
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
      <div class="row items-center no-wrap">
        <div class="q-mr-md">
          <q-avatar size="48px">
            <img :src="avatar(form.name)" />
          </q-avatar>
        </div>

        <div class="col">
          <div class="text-h6">{{ data.user.name }}</div>
          <div class="text-subtitle2 text-capitalize">{{ data.role }}</div>
        </div>
      </div>
    </q-card-section>

    <q-form @submit.prevent="save">
      <q-card-section>
        <div class="q-gutter-md">
          <q-input
            outlined
            counter
            hide-bottom-space
            v-model="form.name"
            label="Nama Lengkap"
            maxlength="30"
            :error="form.errors.name ? true : false"
            :error-message="form.errors.name"
          />

          <q-input
            outlined
            counter
            hide-bottom-space
            v-model="form.email"
            label="Email Address"
            maxlength="30"
            :error="form.errors.email ? true : false"
            :error-message="form.errors.email"
          />
        </div>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn
          flat
          color="primary"
          type="submit"
          label="Save"
          :loading="form.processing"
        />
      </q-card-actions>
    </q-form>
  </q-card>
</template>
