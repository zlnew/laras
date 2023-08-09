<script setup lang="ts">
// cores
import { useForm } from '@inertiajs/vue3';
import { useDialogPluginComponent } from 'quasar';

// types
import { RAB } from '@/types';

defineEmits([
  ...useDialogPluginComponent.emits
]);

const { dialogRef, onDialogOK, onDialogCancel, onDialogHide } = useDialogPluginComponent();

const props = defineProps<{
  id_rab: RAB['id_rab'];
}>();

const form = useForm({
  id_rab: props.id_rab,
});

function destroy() {
  form.delete(route('rab.destroy', props.id_rab), {
    onSuccess: (page) => {
      onDialogOK({
        type: 'positive',
        message: page.props.flash.success
      });
    }
  });
}
</script>

<template>
  <q-dialog
    ref="dialogRef"
    :no-backdrop-dismiss="true"
    @hide="onDialogHide"
  >
    <q-card>
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">Delete Confirmation</div>
      </q-card-section>

      <q-separator />

      <q-card-section class="row items-center">
        <q-avatar icon="dangerous" color="red" text-color="white" />
        <span class="q-ml-sm">Are you sure want to delete this data?</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancel" color="primary" @click="onDialogCancel" />
        <q-btn flat label="Yes, delete it" color="red" @click="destroy" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>