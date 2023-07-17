<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Keuangan, Penagihan } from '@/types';
import { ll } from '@/utilities/date';
import { computed } from 'vue';

const props = defineProps<{
  keuangan: Keuangan;
  penagihan: Penagihan;
}>();

const penagihan = computed(() => {
  const tanggal_pengajuan_in_string = props.penagihan.tanggal_pengajuan
    ? ll(props.penagihan.tanggal_pengajuan)
    : 'Belum diajukan';
  const status_penagihan_in_string = props.penagihan.status_penagihan == 400
    ? 'Closed'
    : 'Open';

  return {
    ...props.penagihan,
    tanggal_pengajuan_in_string: tanggal_pengajuan_in_string,
    status_penagihan_in_string: status_penagihan_in_string
  };
});
</script>

<template>
  <card-layout class="w-fit">
    <card-header>
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Informasi Penagihan</h5>
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
            <td>Tanggal Pengajuan</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span class="font-medium text-dark">
                {{ penagihan.tanggal_pengajuan_in_string }}
              </span>
            </td>
          </tr>
          <tr>
            <td>Status Pengajuan</td>
            <td class="pl-6 pr-3">:</td>
            <td>
              <span
                class="font-semibold"
                :class="{
                  'text-primary': penagihan.status_penagihan == 100,
                  'text-danger': penagihan.status_penagihan == 400
                }">
                {{ penagihan.status_penagihan_in_string }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </card-body>
  </card-layout>
</template>