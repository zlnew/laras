<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormError, FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import { Role } from '@/types';
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

defineProps<{
  roles: Array<Role>;
}>();

const form = useForm({
  name: null,
  email: null,
  password: null,
  role: null
});

function submit() {
  form.post(route('users.store'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="xl">
      <modal-head title="Form Tambah User" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="name" value="Nama Lengkap" />

          <form-input v-model="form.name"
            v-bind="{
              type: 'text',
              id: 'name',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Nama Lengkap',
            }"
          />

          <form-error class="mt-2" :message="form.errors.name" />
        </div>
  
        <div class="w-full mb-4">
          <form-label for="email" value="Email Address" />

          <form-input v-model="form.email"
            v-bind="{
              type: 'email',
              id: 'email',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Email Address'
            }"
          />

          <form-error class="mt-2" :message="form.errors.email" />
        </div>

        <div class="w-full mb-4">
          <form-label for="password" value="Password" />

          <form-input v-model="form.password"
            v-bind="{
              type: 'password',
              id: 'password',
              size: 'lg',
              autocomplete: 'off',
              placeholder: '(Opsional). The default password is: password'
            }"
          />

          <form-error class="mt-2" :message="form.errors.password" />
        </div>

        <div class="w-full mb-4">
          <form-label for="role" value="Role/Jabatan" />

          <form-select v-model="form.role"
            v-bind="{
              id: 'role',
              size: 'lg',
            }">
            <option value="">Pilih Jabatan</option>
            <option
              v-for="role in roles"
              :value="role.name">
              {{ role.name }}
            </option>
          </form-select>

          <form-error class="mt-2" :message="form.errors.role" />
        </div>
      </modal-body>
        
      <modal-footer>
        <ease-button
          @click="modal.close"
          v-bind="{
            variant: 'transparent',
            type: 'button',
            text: 'Close',
          }"
        />
        <div class="space-x-2">
          <ease-button
            v-bind="{
              type: 'submit',
              text: 'Create',
              loading: form.processing,
              onLoading: () => ({
                text: 'Creating data...',
              })
            }"
          />
        </div>
      </modal-footer>
    </modal-layout>
  </form>
</template>