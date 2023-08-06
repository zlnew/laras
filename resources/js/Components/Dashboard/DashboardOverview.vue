<script setup lang="ts">
import { router } from '@inertiajs/vue3';

export interface OverviewProps {
  title: string;
  data: string | number | null;
  color?: string;
  href?: string;
}

defineProps<{
  overview: OverviewProps[];
}>();

function visitUrl(url: string | undefined) {
  if (url) {
    router.visit(url);
  }
}
</script>

<template>
  <div class="q-pa-md row items-start q-gutter-md">
    <q-card
      flat
      bordered
      v-for="item in overview"
      :key="item.title"
      :v-ripple="item.href?.length"
      :style="{
        cursor: item.href?.length ? 'pointer' : 'default'
      }"
      @click="visitUrl(item.href)"
    >
      <q-card-section class="bg-white">
        <div class="text-h6">{{ item.data }}</div>
        <div class="text-subtitle2">{{ item.title }}</div>
      </q-card-section>

      <q-separator
        :color="item.color || 'white'"
      />
    </q-card>
  </div>
</template>