<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  email: null,
  password: null,
  remember: false
});

function login () {
  form.post(route('login.attempt'));
}
</script>

<template>
  <div class="q-pa-xl col-12 col-sm-6 row justify-end items-center" style="height: 90vh;">
    <q-form
      @submit.prevent="login"
      class="col col-md-10 q-gutter-md"
      style="max-width: 400px;"
    >
      <h1 class="text-h5 text-primary text-weight-bold">Welcome Back</h1>
      <p class="text-secondary">Please login to your account</p>

      <q-input
        outlined
        hide-bottom-space
        clear-icon="close"
        label="Email address"
        v-model="form.email"
        :error="form.errors.email ? true : false"
        :error-message="form.errors.email"
      />

      <q-input
        outlined
        hide-bottom-space
        clear-icon="close"
        label="Password"
        type="password"
        v-model="form.password"
        :error="form.errors.password ? true : false"
        :error-message="form.errors.password"
      />

      <q-checkbox
        label="Remember me"
        v-model="form.remember"
      />

      <div>
        <q-btn
          type="submit"
          label="Login"
          color="primary"
          class="full-width"
          :loading="form.processing"
        />
      </div>
    </q-form>
  </div>
</template>