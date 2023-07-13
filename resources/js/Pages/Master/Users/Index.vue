<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import ContentLayout from '@/Components/Content.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { CardLayout, CardHeader, CardBody } from "@/Components/Card.vue";
import { TableLayout, THead, TBody, TRow, THeadCell, TBodyCell } from '@/Components/Table.vue';

import { Toast } from "@/utilities/toastify";

import { onUpdated } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { User, Role } from '@/types';
import { Modal } from '@/utilities/modal';

import SearchModal from './Modals/SearchModal.vue';
import CreateModal from './Modals/CreateModal.vue';
import EditModal from './Modals/EditModal.vue';
import DeleteModal from './Modals/DeleteModal.vue';

const page = usePage();

const props = defineProps<{
  users: {
    data: Array<User>,
  },
  roles: Array<Role>
}>();

function searchUser() {
  Modal.pop(SearchModal, {
    roles: props.roles
  });
}

function createUser() {
  Modal.pop(CreateModal, {
    roles: props.roles
  });
}

function updateUser(user: User) {
  Modal.pop(EditModal, {
    user: user,
    roles: props.roles
  });
}

function deleteUser(id: User['id']) {
  Modal.pop(DeleteModal, {
    id: id,
  });
}

onUpdated(() => {
  if (page.props.flash.success) Toast.success(page.props.flash.success);
  if (page.props.flash.error) Toast.error(page.props.flash.error);
});
</script>

<template>
  <Head title="Users" />
  
  <authenticated-layout>
    <template v-slot:breadcrumb>
      <Breadrumb
        v-slot:breadcrumb
        v-bind="{
          second: 'Master',
          current: 'Users'
        }"
      />
    </template>

    <content-layout>
      <card-layout>
        <card-header class="mb-4">
          <div class="flex justify-between items-center">
            <ease-button @click="createUser" slotted>
              <fas-icon icon="fa-solid fa-plus" class="mr-1" /> Tambah User
            </ease-button>
            <ease-button @click="searchUser" variant="transparent" slotted>
              <fas-icon icon="fa-solid fa-search" class="mr-1" /> Pencarian
            </ease-button>
          </div>
        </card-header>

        <card-body table>
          <table-layout>
            <t-head>
              <t-row>
                <t-head-cell value="Nama" />
                <t-head-cell value="Email" />
                <t-head-cell value="Role" />
                <t-head-cell />
              </t-row>
            </t-head>
            <t-body>
              <t-row
                v-if="users.data.length"
                v-for="(user, index) in users.data" :key="user.id"
                v-bind="{ last: index === users.data.length - 1 }">

                <t-body-cell
                  whitespace="nowrap"
                  class="font-semibold text-primary">
                  {{ user.name }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  {{ user.email }}
                </t-body-cell>

                <t-body-cell
                  whitespace="normal"
                  class="capitalize font-semibold text-primary">
                  {{ user.role_name }}
                </t-body-cell>

                <t-body-cell
                  whitespace="nowrap">
                  <div class="flex">
                    <ease-button
                      @click="updateUser(user)"
                      variant="link"
                      text="Edit"
                    />
                    <ease-button
                      @click="deleteUser(user.id)"
                      variant="danger-link"
                      text="Delete"
                    />
                  </div>
                </t-body-cell>

              </t-row>

              <t-row v-else last>

                <t-body-cell
                  colspan="4"
                  text-align="center">
                  User tidak ditemukan
                </t-body-cell>

              </t-row>
            </t-body>
          </table-layout>
        </card-body>
      </card-layout>
    </content-layout>
  </authenticated-layout>
</template>