<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
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
    icon: 'group',
    label: 'Users',
    link: route('users'),
    active: route().current('users'),
    onlyAdmin: true,
    separator: false,
    sectionTitle: 'Master'
  },
  {
    icon: 'payments',
    label: 'Rekening',
    link: route('rekening'),
    active: route().current('rekening'),
    onlyAdmin: true,
    separator: false,
  },
  {
    icon: 'straighten',
    label: 'Satuan',
    link: route('satuan'),
    active: route().current('satuan'),
    onlyAdmin: true,
    separator: true,
  },
  {
    icon: 'topic',
    label: 'Proyek',
    link: route('proyek'),
    active: route().current('proyek'),
    separator: false,
    sectionTitle: 'Main'
  },
  {
    icon: 'list_alt',
    label: 'RAB',
    link: route('rab'),
    active: route().current('rab') || route().current('detail_rab'),
    separator: false
  },
  {
    icon: 'list_alt',
    label: 'RAPP',
    link: route('rap'),
    active: route().current('rap') || route().current('detail_rap'),
    separator: true
  },
  {
    icon: 'paid',
    label: 'Pengajuan Dana',
    link: route('pengajuan_dana'),
    active: route().current('pengajuan_dana') || route().current('detail_pengajuan_dana'),
    separator: false,
    sectionTitle: 'Keuangan'
  },
  {
    icon: 'paid',
    label: 'Pencairan Dana',
    link: route('pencairan_dana'),
    active: route().current('pencairan_dana') || route().current('detail_pencairan_dana'),
    separator: false
  },
  {
    icon: 'price_check',
    label: 'Penagihan/Invoice',
    link: route('penagihan'),
    active: route().current('penagihan') || route().current('detail_penagihan'),
    separator: true
  },
  {
    icon: 'summarize',
    label: 'Pengajuan Dana',
    link: route('laporan.pengajuan_dana'),
    active: route().current('laporan.pengajuan_dana'),
    separator: false,
    sectionTitle: 'Reports'
  },
  {
    icon: 'summarize',
    label: 'Penagihan/Invoice',
    link: route('laporan.penagihan'),
    active: route().current('laporan.penagihan'),
    separator: false
  }
];

function isAdmin(): boolean {
  const page = usePage();
  const role = page.props.role;

  if (role === 'admin') {
    return true;
  }

  return false;
}
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
        <div v-if="menuItem.onlyAdmin ? isAdmin() : true">
          <q-item v-if="menuItem.sectionTitle">
            <q-item-section class="text-secondary text-weight-bold">
              {{ menuItem.sectionTitle }}
            </q-item-section>
          </q-item>
          
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
        </div>
      </template>

    </q-list>
  </q-drawer>
</template>