<script setup lang="ts">
// cores
import { Head, usePage } from '@inertiajs/vue3'

// layout
import Layout from '@/Layouts/AuthenticatedLayout.vue'

// comps
import { UpdateProfileForm, ChangePasswordForm } from '@/Components/Profile/profile-page'

const breadcrumbs = [
  { label: 'Profile', url: '#' },
  { label: 'Edit', url: '#' }
]

const page = usePage()
const user = page.props.auth.user
const role = page.props.auth.role
</script>

<template>
  <Head title="Profile" />
  <layout>

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

    <div class="q-pa-md">
      <div class="row q-col-gutter-x-md">
        <div class="col-12 col-md-7">
          <update-profile-form :data="{ user: user, role: role }" />
        </div>
        <div class="col-12 col-md-5">
          <change-password-form :data="{ user: user }" />
        </div>
      </div>
    </div>

  </layout>
</template>
