<script setup lang="ts">
// cores
import { useDialogPluginComponent } from 'quasar'

// utils
import { toRupiah } from '@/utils/money'
import { fullDate } from '@/utils/date'
import { toFloat } from '@/utils/number'

// types
import type { Proyek } from '@/types'

defineEmits([
  ...useDialogPluginComponent.emits
])

const { dialogRef, onDialogCancel, onDialogHide } = useDialogPluginComponent()

interface JoinedQuery {
  id_user: number
  pic: string
  nama_bank: string
  nomor_rekening: string
  nama_rekening: string
}

defineProps<{
  proyek: Proyek & JoinedQuery
}>()
</script>

<template>
  <q-dialog
    ref="dialogRef"
    @hide="onDialogHide"
  >
    <q-card style="width: 700px; max-width: 80vw;">
      <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Detail Proyek</div>
          <q-space />
          <q-btn
            flat
            round
            dense
            icon="close"
            @click="onDialogCancel"
          />
        </q-card-section>

      <q-separator />

      <q-card-section class="scroll">
        <div class="q-gutter-md">
          <div class="row">
            <div class="col-12">
              <div class="text-secondary text-weight-bold text-caption">Nama Proyek</div>
              <div class="text-subtitle-2">{{ proyek.nama_proyek }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-6">
              <div class="text-secondary text-weight-bold text-caption">Nomor Kontrak</div>
              <div class="text-subtitle-2">{{ proyek.nomor_kontrak }}</div>
            </div>

            <div class="col-6">
              <div class="text-secondary text-weight-bold text-caption">Tanggal Kontrak</div>
              <div class="text-subtitle-2">{{ fullDate(proyek.tanggal_kontrak) }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-6">
              <div class="text-secondary text-weight-bold text-caption">Nomor SPMK</div>
              <div class="text-subtitle-2">{{ proyek.nomor_spmk }}</div>
            </div>

            <div class="col-6">
              <div class="text-secondary text-weight-bold text-caption">Tanggal SPMK</div>
              <div class="text-subtitle-2">{{ fullDate(proyek.tanggal_spmk) }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Pengguna Jasa</div>
              <div class="text-subtitle-2">{{ proyek.pengguna_jasa }}</div>
            </div>

            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Penyedia Jasa</div>
              <div class="text-subtitle-2">{{ proyek.penyedia_jasa }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Tahun Anggaran</div>
              <div class="text-subtitle-2">{{ proyek.tahun_anggaran }}</div>
            </div>

            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Durasi (Hari)</div>
              <div class="text-subtitle-2">{{ proyek.durasi }}</div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Tanggal Mulai</div>
              <div class="text-subtitle-2">{{ fullDate(proyek.tanggal_mulai) }}</div>
            </div>

            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Tanggal Selesai</div>
              <div class="text-subtitle-2">{{ fullDate(proyek.tanggal_selesai) }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-12">
              <div class="text-secondary text-weight-bold text-caption">Nilai Kontrak</div>
              <div class="text-subtitle-2">{{ toRupiah(toFloat(proyek.nilai_kontrak)) }}</div>
            </div>
          </div>

          <q-separator />

          <div class="row">
            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">PIC</div>
              <div class="text-subtitle-2">{{ proyek.pic }}</div>
            </div>

            <div class="col-12 col-md-6">
              <div class="text-secondary text-weight-bold text-caption">Rekening Pembayaran</div>
              <div class="text-subtitle-2">{{ proyek.nama_bank }}: {{ proyek.nomor_rekening }} - {{ proyek.nama_rekening }}</div>
            </div>
          </div>

        </div>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>
