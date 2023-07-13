<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ModalLayout, ModalHead, ModalBody, ModalFooter } from "@/Components/Modal.vue";
import { FormInput, FormLabel, FormSelect } from "@/Components/Form.vue";
import { Role, User } from '@/types';
import useModalStore from "@/stores/useModalStore";

const modal = useModalStore();

const page = usePage();

const queryParams = page.props.query as User;

defineProps<{
  roles: Array<Role>;
}>();

const form = useForm({
  name: queryParams.name,
  email: queryParams.email,
  role: queryParams.role
});

function submit() {
  form.get(route('users'), {
    onSuccess: () => {
      modal.close();
    }
  });
}
</script>

<template>
  <form @submit.prevent="submit">
    <modal-layout size="xl">
      <modal-head title="Form Pencarian User" />

      <modal-body>
        <div class="w-full mb-4">
          <form-label for="name" value="Nama" />

          <form-input v-model="form.name"
            v-bind="{
              type: 'text',
              id: 'name',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Cari berdasarkan nama'
            }" />
        </div>
  
        <div class="w-full mb-4">
          <form-label for="email" value="Email" />

          <form-input v-model="form.email"
            v-bind="{
              type: 'email',
              id: 'email',
              size: 'lg',
              autocomplete: 'off',
              placeholder: 'Cari berdasarkan email'
            }"
          />
        </div>

        <div class="w-full mb-4">
          <form-label for="role" value="Role/Jabatan" />

          <form-select v-model="form.role"
            v-bind="{
              id: 'role',
              size: 'lg',
            }">
            <option value="">Semua role/jabatan</option>
            <option
              v-for="role in roles"
              :value="role.name">
              {{ role.name }}
            </option>
          </form-select>
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
              text: 'Search',
              loading: form.processing,
              onLoading: () => ({
                text: 'Searching data...',
              })
            }"
          />
        </div>
      </modal-footer>
    </modal-layout>
  </form>
</template>