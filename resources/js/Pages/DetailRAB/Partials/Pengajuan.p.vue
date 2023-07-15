<script setup lang="ts">
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import { FormLabel, FormTextarea } from '@/Components/Form.vue';
import { RAB } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  id_rab: RAB['id_rab'],
  uraian_length: number,
}>();

const form = useForm({
  catatan: null,
});

function submit() {
  form.post(route('rab.submit', props.id_rab));
}
</script>

<template>
  <card-layout class="h-fit">
    <card-header class="mb-2">
      <div class="flex justify-between items-center">
        <h5 class="font-bold text-xl text-dark">Submit</h5>
      </div>
    </card-header>
    <card-body>
      <div class="flex justify-between items-center space-x-4">
        <div class="w-full mb-4">
          <form-label value="Catatan" />
          <form-textarea v-model="form.catatan" placeholder="Beri catatan (Opsional)" />
        </div>
  
        <div class="flex justify-end space-x-2">  
          <form @submit.prevent="submit">
            <ease-button v-bind="{
              type: 'submit',
              text: 'Submit',
              disabled: uraian_length < 1,
            }" />
          </form>
        </div>
      </div>
    </card-body>
  </card-layout>
</template>