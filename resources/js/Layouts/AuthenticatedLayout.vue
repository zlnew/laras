<script setup lang="ts">
import {
  AuthenticatedHeader,
  AuthenticatedLeftDrawer,
  AuthenticatedPageContainer,
  AuthenticatedFooter
} from '@/Components/authenticated-layout';
import { ref } from 'vue';

const leftDrawerOpen = ref(true);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>

<template>
  <q-layout view="lHh lpR fFf" class="bg-grey-2">

    <authenticated-header @toggle-left-drawer="toggleLeftDrawer" />
    <authenticated-left-drawer :left-drawer-open="leftDrawerOpen" />
    <authenticated-page-container><slot></slot></authenticated-page-container>
    <authenticated-footer />
    
  </q-layout>
</template>