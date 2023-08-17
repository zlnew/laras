<script setup lang="ts">
// cores
import { router } from '@inertiajs/vue3'
import { useQuasar } from 'quasar'
import { ref } from 'vue'

// comps
import {
  UsersSearchDialog,
  UsersCreateDialog,
  UsersEditDialog,
  UsersDeleteDialog
} from '@/Components/Master/users-page'

// types
import type { Role, User } from '@/types'
import type { QTableColumn } from 'quasar'

const props = defineProps<{
  rows: User[]
  roles: Role[]
}>()

const $q = useQuasar()

function searchUsers () {
  $q.dialog({
    component: UsersSearchDialog,
    componentProps: {
      roles: props.roles
    }
  })
}

function createUser () {
  $q.dialog({
    component: UsersCreateDialog,
    componentProps: {
      roles: props.roles
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function editUser (data: User) {
  $q.dialog({
    component: UsersEditDialog,
    componentProps: {
      user: data,
      roles: props.roles
    }
  }).onOk((payload) => {
    $q.notify({
      type: payload.type,
      message: payload.message,
      position: 'top'
    })
  })
}

function deleteUser (id: User['id']) {
  $q.dialog({
    component: UsersDeleteDialog,
    componentProps: {
      id
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
  {
    name: 'index',
    label: '#',
    field: 'index'
  },
  {
    name: 'name',
    label: 'User',
    field: 'name',
    align: 'left',
    sortable: true
  },
  { name: 'role_name', label: 'Role/Jabatan', field: 'role_name', align: 'left', sortable: true },
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
      row-key="id"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="[ 5, 10, 15, 20, 25, 50, 0 ]"
      :fullscreen="tableFullscreen"
    >
      <template v-slot:top-left>
        <q-btn
          no-caps
          label="Tambah User"
          icon="add"
          color="primary"
          @click="createUser"
        />
      </template>

      <template v-slot:top-right>
        <q-btn
          v-if="Object.keys($page.props.query).length"
          flat
          no-caps
          label="Clear Filter"
          icon="clear"
          color="secondary"
          @click="router.visit(route('users'))"
        />
        <q-btn
          flat
          no-caps
          label="Pencarian"
          icon="search"
          color="primary"
          @click="searchUsers"
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

          <q-td key="name" :props="props">
            <div>{{ props.row.name }}</div>
            <div class="text-blue-grey-8">{{ props.row.email }}</div>
          </q-td>

          <q-td key="role_name" :props="props" class="text-capitalize">
            <q-chip size="sm" :label="props.row.role_name" :ripple="false" />
          </q-td>

          <q-td key="actions" :props="props">
            <q-btn
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
                      @click="editUser(props.row)"
                    >
                      Edit
                    </q-item-section>
                  </q-item>

                  <q-separator />

                  <q-item clickable>
                    <q-item-section
                      class="text-red"
                      @click="deleteUser(props.row.id)"
                    >
                      Delete
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>
