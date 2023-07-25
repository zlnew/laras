<script setup lang="ts">
// cores
import { Head } from '@inertiajs/vue3';

// layout
import Layout from '@/Layouts/GuestLayout.vue';

// comps
import { LoginForm, LoginBackground } from '@/Components/Auth/login-page';
</script>

<template>
  <Head title="Login to your account" />
  <layout>
    <div class="row items-center bg-white">
      <login-form />
      <login-background />
    </div>
  </layout>
</template>