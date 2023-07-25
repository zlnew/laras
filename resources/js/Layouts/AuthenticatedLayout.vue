<script setup lang="ts">
// cores
import { ref } from 'vue';

// comps
import {
  AuthenticatedHeader,
  AuthenticatedLeftDrawer,
  AuthenticatedPageContainer,
  AuthenticatedFooter
} from '@/Components/Layouts/authenticated-layout';

const leftDrawerOpen = ref(true);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>

<template>
  <q-layout view="lHh lpR fFf" class="bg-grey-2">
    
    <authenticated-header
      @toggle-left-drawer="toggleLeftDrawer"
    >
      <template #breadcrumbs>
        <slot name="breadcrumbs"></slot>
      </template>
    </authenticated-header>

    <authenticated-left-drawer
      :left-drawer-open="leftDrawerOpen"
    />

    <authenticated-page-container>
      <slot></slot>
    </authenticated-page-container>

    <authenticated-footer />
    
  </q-layout>
</template>