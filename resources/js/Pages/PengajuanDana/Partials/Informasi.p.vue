<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { Keuangan, PengajuanDana } from '@/types';
import { ll } from '@/utilities/date';
import { computed } from 'vue';

const props = defineProps<{
  keuangan: Keuangan;
  pengajuan_dana: PengajuanDana;
}>();

const pengajuan_dana = computed(() => {
  const tanggal_pengajuan_in_string = props.pengajuan_dana.tanggal_pengajuan
    ? ll(props.pengajuan_dana.tanggal_pengajuan)
    : 'Belum diajukan';
  const status_pengajuan_in_string = props.pengajuan_dana.status_pengajuan == 400
    ? 'Closed'
    : 'Open';

  return {
    ...props.pengajuan_dana,
    tanggal_pengajuan_in_string: tanggal_pengajuan_in_string,
    status_pengajuan_in_string: status_pengajuan_in_string
  };
});
</script>

<template>
  <card-layout class="w-fit">
    <card-header>
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Informasi Pengajuan Dana</h5>
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
                {{ pengajuan_dana.tanggal_pengajuan_in_string }}
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
                  'text-primary': pengajuan_dana.status_pengajuan == 100,
                  'text-danger': pengajuan_dana.status_pengajuan == 400
                }">
                {{ pengajuan_dana.status_pengajuan_in_string }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </card-body>
  </card-layout>
</template>