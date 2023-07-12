<script setup lang="ts">
import { CardBody, CardHeader, CardLayout } from "@/Components/Card.vue";
import { FormError, FormInput, FormLabel } from "@/Components/Form.vue";
import { useForm, usePage } from "@inertiajs/vue3";

const page = usePage();

const user = page.props.auth.user;
const role = page.props.role;

const form = useForm({
  name: user.name,
  email: user.email,
});

function submit() {
  form.patch(route('profile.update'));
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header>
      <h5 class="text-xl font-bold text-primary">
        User Profile
      </h5>
    </card-header>

    <card-body>
      <div class="mb-4 flex justify-center items-center gap-4">
        <img
            :src="`https://ui-avatars.com/api/?name=${form.name}`"
            alt="User Avatar"
            class="w-32 rounded-full"
        />
        <div class="max-w-xs">
          <p class="text-2xl font-bold text-primary">
            {{ form.name }}
          </p>
          <p class="text-lg capitalize text-primary/60">
            {{ role }}
          </p>
        </div>
      </div>

      <form @submit.prevent="submit">
        <div class="w-full mb-4">
          <FormLabel id="user_name" value="Nama Lengkap" />
  
          <FormInput v-model="form.name"
            v-bind="{
              size: 'lg',
              type: 'text',
              id: 'user_name',
              placeholder: 'Nama Lengkap',
              autocomplete: 'off'
            }"
          />
  
          <FormError class="mt-2" :message="form.errors.name" />
        </div>
  
        <div class="w-full mb-4">
          <FormLabel id="email" value="Alamat Email" />
  
          <FormInput v-model="form.email"
            v-bind="{
              size: 'lg',
              type: 'email',
              id: 'name',
              placeholder: 'Alamat Email',
              autocomplete: 'off'
            }"
          />
  
          <FormError class="mt-2" :message="form.errors.email" />
        </div>
  
        <div class="flex justify-end gap-2">
          <ease-button
            v-bind="{
              type: 'submit',
              text: 'Submit',
              loading: form.processing
            }"
          />
        </div>
      </form>
    </card-body>
  </card-layout>
</template>