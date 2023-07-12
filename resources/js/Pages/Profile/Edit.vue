<script setup lang="ts">
import { Head, usePage } from "@inertiajs/vue3";
import { onUpdated } from "vue";
import { Toast } from "@/utilities/toastify";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Content from "@/Components/Content.vue";
import Breadrumb from "@/Components/Breadrumb.vue";
import ProfileSection from "./Partials/Profile.p.vue";
import PasswordSection from "./Partials/Password.p.vue";

const page = usePage();

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Profile" />
  
  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'User',
          current: 'Profile'
        }"
      />
    </template>

    <Content>
      <div class="grid grid-cols-3 gap-4">
        <div class="col-span-2">
          <profile-section />
        </div>
        
        <password-section />
      </div>
    </Content>
  </authenticated-layout>
</template>