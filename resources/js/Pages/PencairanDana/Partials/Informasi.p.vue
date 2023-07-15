<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Keuangan, PencairanDana } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
  keuangan: Keuangan;
  pencairan_dana: PencairanDana;
}>();

const pencairan_dana = computed(() => {
  const status_pencairan_in_string = props.pencairan_dana.status_pencairan == 400
    ? 'Closed'
    : 'Open';

  return {
    ...props.pencairan_dana,
    status_pencairan_in_string: status_pencairan_in_string
  };
});
</script>

<template>
  <card-layout class="w-fit">
    <card-header>
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Informasi Pencairan Dana</h5>
      </div>
    </card-header>
    <card-body>
      <table>
        <tbody>
          <tr>
            <td>Proyek</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">
                {{ keuangan.nama_proyek }}
              </span>
            </td>
          </tr>
          <tr>
            <td>Tahun Anggaran</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">
                {{ keuangan.tahun_anggaran }}
              </span>
            </td>
          </tr>
          <tr>
            <td>Pengguna Jasa</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">
                {{ keuangan.pengguna_jasa }}
              </span>
            </td>
          </tr>
          <tr>
            <td>Keperluan</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">
                {{ keuangan.keperluan }}
              </span>
            </td>
          </tr>
          <tr>
            <td>Status Pencairan</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span
                class="font-semibold"
                :class="{
                  'text-primary': pencairan_dana.status_pencairan == 100,
                  'text-danger': pencairan_dana.status_pencairan == 400
                }">
                {{ pencairan_dana.status_pencairan_in_string }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </card-body>
  </card-layout>
</template>