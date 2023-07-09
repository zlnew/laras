<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';
import { Persetujuan } from '@/types';
import { ll } from '@/utilities/date';

defineProps<{
  persetujuan: Array<Persetujuan>;
}>()
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl">Timeline</h5>
      </div>
    </card-header>
    <card-body table>
      <table-layout>
        <t-head>
          <t-row>
            <t-head-cell value="Status" />
            <t-head-cell value="Oleh" />
            <t-head-cell value="Jabatan" />
            <t-head-cell value="Catatan" />
          </t-row>
        </t-head>
        <t-body>
          <t-row
              v-if="persetujuan.length"
              v-for="(item, index) in persetujuan"
              :key="item.id_persetujuan"
              :last="index === persetujuan.length - 1"
            >
            <t-body-cell class="font-semibold text-primary">{{ item.status }} pada {{ ll(item.created_at) }}</t-body-cell>
            <t-body-cell>{{ item.user_name }}</t-body-cell>
            <t-body-cell class="capitalize">{{ item.user_role }}</t-body-cell>
            <t-body-cell>{{ item.catatan || '-' }}</t-body-cell>
          </t-row>
          <t-row v-else last>
            <t-body-cell colspan="8" textAlign="center">Belum ada status pengajuan</t-body-cell>
          </t-row>
        </t-body>
      </table-layout>
    </card-body>
  </card-layout>
</template>