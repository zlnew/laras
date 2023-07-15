<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { RAP } from '@/types';

defineProps<{
  rap: RAP;
}>();
</script>

<template>
  <card-layout class="w-fit">
    <card-header>
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Informasi RAP</h5>
      </div>
    </card-header>
    <card-body>
      <table>
        <tbody>
          <tr>
            <td>Proyek</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">{{ rap.nama_proyek }}</span>
            </td>
          </tr>
          <tr>
            <td>Tahun Anggaran</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">{{ rap.tahun_anggaran }}</span>
            </td>
          </tr>
          <tr>
            <td>Pengguna Jasa</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">{{ rap.pengguna_jasa }}</span>
            </td>
          </tr>
          <tr>
            <td>Status RAP</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span
                class="font-semibold"
                :class="{
                  'text-primary': rap.status_rap == 100,
                  'text-danger': rap.status_rap == 400
                }">
                {{ rap.status_rap_in_string }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </card-body>
  </card-layout>
</template>