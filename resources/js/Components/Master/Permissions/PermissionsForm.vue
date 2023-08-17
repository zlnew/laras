<script setup lang="ts">
// cores
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { useQuasar } from 'quasar'

// types
import type { Role, UserPermissions } from '@/types'

const splitterModel = ref()

const props = defineProps<{
  data: {
    roles: Role[]
    permissions: UserPermissions[]
    role: Role
    rolePermissions: Partial<UserPermissions[]>
  }
}>()

const selection = ref(props.data.rolePermissions)

const $q = useQuasar()

function synchronize () {
  router.post(route('permissions.sync', props.data.role.id), {
    permissions: selection.value
  }, {
    onSuccess: (page) => {
      $q.notify({
        color: 'positive',
        message: page.props.flash.success,
        position: 'top'
      })
    }
  })
}

function changeRole (role: string) {
  router.get(route('permissions', { role }), undefined, {
    preserveScroll: true
  })
}
</script>

<template>
  <div class="q-pa-md">
    <q-card flat bordered style="width: fit-content;">
      <q-card-section>
        <div class="flex justify-between q-gutter-col-sm">
          <div class="text-h6">Edit Permissions</div>
          <q-btn
            flat
            dense
            label="Save Changes"
            color="primary"
            @click="synchronize"
          />
        </div>
      </q-card-section>

      <q-card-section>
        <q-splitter v-model="splitterModel">

          <template v-slot:before>
            <div
              v-for="role in data.roles"
              :key="role.id"
              class="q-pr-sm"
            >
              <q-btn
                flat
                dense
                no-caps
                :label="role.name"
                :color="data.role.name === role.name ? 'primary' : 'secondary'"
                align="left"
                style="width: 100%;"
                class="text-capitalize"
                @click="changeRole(role.name)"
              />
            </div>
          </template>

          <template v-slot:after>
            <div
              v-for="permission in data.permissions"
              :key="permission"
              class="q-pl-sm text-capitalize"
            >
              <q-checkbox
                v-model="selection"
                :val="permission"
                :label="permission"
              />
            </div>
          </template>

        </q-splitter>
      </q-card-section>
    </q-card>
  </div>
</template>
