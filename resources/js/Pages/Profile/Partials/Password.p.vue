<script setup lang="ts">
import { CardBody, CardHeader, CardLayout } from "@/Components/Card.vue";
import { FormError, FormInput, FormLabel } from "@/Components/Form.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  current_password: null,
  password: null,
  password_confirmation: null,
});

function submit() {
  form.patch(route('password.update'), {
    onSuccess: () => form.reset(),
  });
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header>
      <h5 class="text-xl font-bold text-dark">
        Change Password
      </h5>
    </card-header>

    <card-body>
      <form @submit.prevent="submit">
        <div class="w-full mb-4">
          <FormLabel id="current_password" value="Password Saat Ini" />
  
          <FormInput v-model="form.current_password"
            v-bind="{
              size: 'lg',
              type: 'password',
              id: 'current_password',
              placeholder: 'Masukkan password saat ini',
              autocomplete: 'off'
            }"
          />
  
          <FormError class="mt-2" :message="form.errors.current_password" />
        </div>
  
        <div class="w-full mb-4">
          <FormLabel id="new_password" value="Password Baru" />
  
          <FormInput v-model="form.password"
            v-bind="{
              size: 'lg',
              type: 'password',
              id: 'new_password',
              placeholder: 'Masukkan password baru',
              autocomplete: 'off'
            }"
          />
  
          <FormError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="w-full mb-4">
          <FormLabel id="password_confirmation" value="Konfirmasi Password" />
  
          <FormInput v-model="form.password_confirmation"
            v-bind="{
              size: 'lg',
              type: 'password',
              id: 'password_confirmation',
              placeholder: 'Ulangi password baru',
              autocomplete: 'off'
            }"
          />
  
          <FormError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
  
        <div class="flex justify-end gap-2">
          <ease-button
            v-bind="{
              type: 'submit',
              text: 'Change Password',
              loading: form.processing
            }"
          />
        </div>
      </form>
    </card-body>
  </card-layout>
</template>