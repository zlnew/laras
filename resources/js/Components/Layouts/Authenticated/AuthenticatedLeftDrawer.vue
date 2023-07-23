<script setup lang="ts">
import { computed } from 'vue';

const props =defineProps<{
  leftDrawerOpen: boolean;
}>();

const leftDrawerOpen = computed(() => {
  return props.leftDrawerOpen;
});

const menuList = [
  {
    icon: 'dashboard',
    label: 'Dashboard',
    link: route('dashboard'),
    active: route().current('dashboard'),
    separator: true,
  },
  {
    icon: 'send',
    label: 'Proyek',
    link: route('proyek'),
    active: route().current('proyek'),
    separator: false
  },
  {
    icon: 'delete',
    label: 'RAB',
    link: route('rab'),
    active: route().current('rab'),
    separator: false
  },
  {
    icon: 'error',
    label: 'RAP',
    link: route('rap'),
    active: route().current('rap'),
    separator: true
  },
  {
    icon: 'settings',
    label: 'Keuangan',
    link: route('keuangan'),
    active: route().current('keuangan'),
    separator: false
  },
  {
    icon: 'feedback',
    label: 'Penagihan/Invoice',
    link: route('keuangan'),
    active: route().current('keuangan'),
    separator: true
  },
  {
    icon: 'report',
    label: 'Laporan Pengajuan Dana',
    link: route('laporan.pengajuan_dana'),
    active: route().current('laporan.pengajuan_dana'),
    separator: false
  },
  {
    icon: 'report',
    label: 'Laporan Penagihan/Invoice',
    link: route('laporan.penagihan'),
    active: route().current('laporan.penagihan'),
    separator: false
  }
]
</script>

<template>
  <q-drawer
    show-if-above
    bordered
    side="left"
    class="q-pa-md q-gutter-y-md"
    v-model="leftDrawerOpen"
  >
    <div style="border: 1px solid blue;">
      <q-img
        no-spinner
        :initial-ratio="4.15"
        src="/storage/logo/logo.webp"
      />
    </div>

    <q-list>

      <template v-for="(menuItem, index) in menuList" :key="index">
        <q-item
          clickable
          v-ripple
          v-in-link="menuItem.link"
          :active="menuItem.active"
        >
          <q-item-section avatar>
            <q-avatar
              rounded
              :color="menuItem.active ? 'primary' : 'blue-grey-1'"
              :text-color="menuItem.active ? 'white' : 'blue-grey'"
              :icon="menuItem.icon"
            />
          </q-item-section>

          <q-item-section
            :class="{
              'text-weight-bold': menuItem.active,
              'text-blue-grey-8': !menuItem.active
            }"
          >
            {{ menuItem.label }}
          </q-item-section>
        </q-item>

        <q-separator :key="'sep' + index"  v-if="menuItem.separator" />
      </template>

    </q-list>
  </q-drawer>
</template>