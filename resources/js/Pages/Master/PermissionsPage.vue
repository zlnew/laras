<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { PermissionsForm } from '@/Components/Master/permissions-page'

// types
import type { Role, UserPermissions } from '@/types'

const breadcrumbs = [
  { label: 'Master', url: '#' },
  { label: 'User Permissions', url: '#' }
]

defineProps<{
  roles: Role[]
  permissions: UserPermissions[]
  role: Role
  rolePermissions: Partial<UserPermissions[]>
}>()
</script>

<template>
  <Head title="User Permissions" />
  <Layout>

    <template #breadcrumbs>
      <q-breadcrumbs align="left">
        <q-breadcrumbs-el
          v-for="breadcrumb in breadcrumbs"
          :key="breadcrumb.label"
          :label="breadcrumb.label"
          v-in-link="breadcrumb.url"
        />
      </q-breadcrumbs>
    </template>

    <permissions-form
      :data="{
        roles,
        permissions,
        role,
        rolePermissions
      }"
    />

  </Layout>
</template>
