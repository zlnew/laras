<script setup lang="ts">
// cores
import { router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { useQuasar } from 'quasar'

// utils
import { can, isAdmin, isModuleEditable, isRejected } from '@/utils/permissions'

// types
import type { Proyek, RAP } from '@/types'
import type { QTableColumn } from 'quasar'
import type { FormOptions } from '@/Pages/Main/RAPPage.vue'

// comps
import {
  RAPSearchDialog,
  RAPCreateDialog,
  RAPEditDialog,
  RAPDeleteDialog
} from '@/Components/Main/rap-page'
import { ProyekDetailDialog } from '@/Components/Main/proyek-page'

const props = defineProps<{
  rows: RAP[]
  formOptions: FormOptions
}>()

const $q = useQuasar()

function detailProyek (data: Proyek) {
  $q.dialog({
    component: ProyekDetailDialog,
    componentProps: {
      proyek: data
    }
  })
}

function searchRAP () {
  $q.dialog({
    component: RAPSearchDialog,
    componentProps: {
      options: props.formOptions
    }
  })
}

function createRAP () {
  $q.dialog({
    component: RAPCreateDialog,
    componentProps: {
      options: props.formOptions
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function editRAP (data: RAP) {
  $q.dialog({
    component: RAPEditDialog,
    componentProps: {
      rap: data,
      options: props.formOptions
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function deleteRAP (id: RAP['id_rap']) {
  $q.dialog({
    component: RAPDeleteDialog,
    componentProps: {
      id_rap: id
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

const columns: QTableColumn[] = [
  { name: 'index', label: '#', field: 'index' },
  {
    name: 'nama_proyek',
    label: 'Nama Proyek',
    field: 'nama_proyek',
    align: 'left',
    sortable: true
  },
  { name: 'pengguna_jasa', label: 'Pengguna Jasa', field: 'pengguna_jasa', align: 'left', sortable: true },
  { name: 'penyedia_jasa', label: 'Penyedia Jasa', field: 'penyedia_jasa', align: 'left', sortable: true },
  { name: 'tahun_anggaran', label: 'Tahun Anggaran', field: 'tahun_anggaran', align: 'left', sortable: true },
  { name: 'status_rap', label: 'Status', field: 'status_rap', align: 'left', sortable: true },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
]

const tableFullscreen = ref(false)

function toggleFullscreen () {
  tableFullscreen.value = !tableFullscreen.value
}
</script>

<template>
  <div class="q-pa-md">
    <q-table
      flat
      bordered
      row-key="id_rap"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          v-if="can('create & modify rap')"
          no-caps
          label="Tambah RAP"
          icon="add"
          color="primary"
          @click="createRAP"
        />

        <div v-else class="text-h6">List RAP</div>
      </template>

      <template v-slot:top-right>
        <q-btn
          v-if="Object.keys($page.props.query).length"
          flat
          no-caps
          label="Clear Filter"
          icon="clear"
          color="secondary"
          @click="router.visit(route('rap'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchRAP"
        />
        <q-btn
          flat dense
          :icon="tableFullscreen ? 'fullscreen_exit' : 'fullscreen'"
          @click="toggleFullscreen"
          class="q-ml-md"
        />
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            style="font-weight: bold"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="index" :props="props">
            {{ ++props.rowIndex }}
          </q-td>

          <q-td key="nama_proyek" :props="props">
            <q-btn
              flat
              no-caps
              dense
              color="primary"
              :ripple="false"
              :label="props.row.nama_proyek"
              @click="detailProyek(props.row)"
            >
              <q-tooltip anchor="bottom middle" self="top middle">
                Lihat Detail
              </q-tooltip>
          </q-btn>
          </q-td>

          <q-td
            key="pengguna_jasa"
            :props="props"
            @click.prevent="router.visit(route('detail_rap', props.row.id_rap))"
            style="cursor: pointer;"
          >
            {{ props.row.pengguna_jasa }}
          </q-td>

          <q-td
            key="penyedia_jasa"
            :props="props"
            @click.prevent="router.visit(route('detail_rap', props.row.id_rap))"
            style="cursor: pointer;"
          >
            {{ props.row.penyedia_jasa }}
          </q-td>

          <q-td
            key="tahun_anggaran"
            :props="props"
            @click.prevent="router.visit(route('detail_rap', props.row.id_rap))"
            style="cursor: pointer;"
          >
            {{ props.row.tahun_anggaran }}
          </q-td>

          <q-td key="status_rap" :props="props">
            <q-btn
              v-if="isRejected(props.row.status_aktivitas)"
              flat
              dense
              round
              color="grey-6"
              icon="warning"
              size="sm"
            >
              <q-tooltip>Ditolak</q-tooltip>
            </q-btn>

            <Link :href="route('detail_rap', props.row.id_rap)">
              <q-badge
                :color="props.row.status_rap == 400 ? 'red' : 'primary'"
                :label="props.row.status_rap == 400 ? 'Closed' : 'Open'"
              />
            </Link>
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
              v-if="isAdmin() ? true : can('create & modify rap') && isModuleEditable(props.row.status_rap)"
              dense
              flat
              color="blue-grey"
              icon="more_vert"
            >
              <q-menu
                auto-close
                transition-show="scale"
                transition-hide="scale"
              >
                <q-list dense style="min-width: 100px">
                  <q-item clickable>
                    <q-item-section
                      @click="editRAP(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />

                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteRAP(props.row.id_rap)"
                    >
                      Delete
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>

            <q-btn
              v-else
              dense
              flat
              color="grey-6"
              icon="block"
            >
              <q-tooltip>Required permission</q-tooltip>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
