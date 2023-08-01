<script setup lang="ts">
// cores
import { ref } from 'vue';

// utils
import { can, isAdmin, isEditable } from '@/utils/permissions';

// types
import { File, Timeline, UserPermissions } from '@/types';
import { QTableColumn, useQuasar } from 'quasar';

// comps
import {
  FileCreateDialog,
  FileEditDialog,
  FileDeleteDialog
} from '@/Components/Files/files-page';

const props = defineProps<{
  rows: Array<File>;
  data: {
    model_id: string | number;
    permissions: UserPermissions;
    status_aktivitas: Timeline['status_aktivitas'];
  }
}>();

const $q = useQuasar();

function uploadFile() {
  $q.dialog({
    component: FileCreateDialog,
    componentProps: {
      model_id: props.data.model_id
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function editFile(data: File) {
  $q.dialog({
    component: FileEditDialog,
    componentProps: {
      file: data,
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

function deleteFile(id: File['id_file']) {
  $q.dialog({
    component: FileDeleteDialog,
    componentProps: {
      id_file: id
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top',
    });
  });
}

const columns: Array<QTableColumn> = [
  { name: 'index', label: '#', field: 'index' },
  { name: 'file', label: 'File', field: 'file_name', align: 'left', sortable: true },
  { name: 'download', label: 'Download', field: 'file_path', align: 'left' },
  { name: 'actions', label: 'Actions', field: '', align: 'left' }
];

const tableFullscreen = ref(false);

function toggleFullscreen() {
  tableFullscreen.value = !tableFullscreen.value;
}

const filter = ref('');
</script>

<template>
  <q-table
    flat
    bordered
    row-key="id_rap"
    :rows="rows"
    :columns="columns"
    :filter="filter"
    :rows-per-page-options="[ 10, 15, 20, 25, 50, 0 ]"
    :fullscreen="tableFullscreen"
    class="no-border"
  >
    <template v-slot:top-left>
      <q-btn
        v-if="isAdmin() ? true : can(data.permissions) && isEditable(data)"
        no-caps
        label="Tambah File"
        icon="add"
        color="primary"
        @click="uploadFile"
      />
    </template>

    <template v-slot:top-right>
      <q-input
        dense
        debounce="300"
        v-model="filter"
        placeholder="Search"
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
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
          style="font-weight: bold;"
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

        <q-td key="file" :props="props">
          {{ props.row.file_name }}
        </q-td>

        <q-td key="download" :props="props">
          <q-btn
            flat
            dense
            icon="download"
            color="secondary"
            :href="props.row.file_path"
            :download="props.row.file_name"
          />
        </q-td>

        <q-td key="actions" :props="props">
          <q-btn
            v-if="isAdmin() ? true : can(data.permissions) && isEditable(data)"
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
                    @click="editFile(props.row)"
                  >
                    Edit
                  </q-item-section>
                </q-item>

                <q-separator />
                
                <q-item clickable>
                  <q-item-section
                    class="text-red"
                    @click="deleteFile(props.row.id_file)"
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
</template>