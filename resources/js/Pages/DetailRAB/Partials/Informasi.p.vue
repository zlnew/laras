<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { RAB } from '@/types';

defineProps<{
  rab: RAB;
}>();
</script>

<template>
  <card-layout class="w-fit">
    <card-header>
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl">Informasi RAB</h5>
      </div>
    </card-header>
    <card-body>
      <table>
        <tbody>
          <tr>
            <td>Proyek</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-primary">{{ rab.nama_proyek }}</span>
            </td>
          </tr>
          <tr>
            <td>Tahun Anggaran</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-primary">{{ rab.tahun_anggaran }}</span>
            </td>
          </tr>
          <tr>
            <td>Pengguna Jasa</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-primary">{{ rab.pengguna_jasa }}</span>
            </td>
          </tr>
          <tr>
            <td>Status RAB</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span
                class="font-semibold"
                :class="{
                  'text-primary': rab.status_rab == 100,
                  'text-danger': rab.status_rab == 400
                }">
                {{ rab.status_rab_in_string }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </card-body>
  </card-layout>
</template>