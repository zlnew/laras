<script setup lang="ts">
defineEmits(['toggleLeftDrawer']);
</script>

<template>
  <q-header class="bg-transparent text-blue-grey-10">
    <q-toolbar class="q-pa-sm">
      <q-btn dense flat round icon="menu" @click="$emit('toggleLeftDrawer')" />
      
      <q-toolbar-title>
        <div class="q-pa-md q-gutter-sm text-subtitle1">
          <q-breadcrumbs align="left">
            <q-breadcrumbs-el label="Dashboard" v-in-link="route('dashboard')" />
            <q-breadcrumbs-el label="Overview" />
          </q-breadcrumbs>
        </div>
      </q-toolbar-title>

      <q-item clickable v-ripple class="rounded-borders">
        <q-item-section side>
          <q-avatar size="48px">
            <img src="https://cdn.quasar.dev/img/avatar.png" />
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>{{ $page.props.auth.user.name }}</q-item-label>
          <q-item-label caption class="text-capitalize">{{ $page.props.role }}</q-item-label>
        </q-item-section>

        <q-menu fit>
          <q-list style="min-width: 100px">
            <q-item clickable>
              <q-item-section>Profile</q-item-section>
            </q-item>
            <q-separator />

            <q-item clickable v-in-link:post="route('logout')">
              <q-item-section class="text-red-10">Logout</q-item-section>
            </q-item>
          </q-list>
        </q-menu>
      </q-item>
    </q-toolbar>
  </q-header>
</template>