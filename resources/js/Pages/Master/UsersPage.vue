<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue';

// comps
import { UsersTable } from '@/Components/Master/users-page';

// types
import { Role, User } from '@/types';

const breadcrumbs = [
  { label: 'Master', url: '#' },
  { label: 'Users', url: '#' }
];

defineProps<{
  users: Array<User>;
  roles: Array<Role>;
}>();
</script>

<template>
  <Head title="Users" />
  <Layout>

    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        />
      </q-breadcrumbs>
    </template>

    <users-table
      :rows="users"
      :roles="roles"
    />

  </Layout>
</template>