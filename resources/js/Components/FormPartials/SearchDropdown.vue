<script setup lang="ts">
import { watch } from 'vue';
import { onMounted } from 'vue';
import vSelect from 'vue-select';
import Fuse from 'fuse.js';
import useValueStore from '@/stores/useValueStore';

import 'vue-select/dist/vue-select.css';

defineOptions({
  inheritAttrs: false
});

const emit = defineEmits(['update:modelValue']);

const props = defineProps<{
  modelValue: string | number | boolean | null | undefined;
  label?: string;
  index: string;
  options: unknown[];
  searchKeys: string[];
  placeholder: string;
}>();

const value = useValueStore();

watch(value.$state, (value) => {
  emit('update:modelValue', value.state);
});

onMounted(() => {
  value.set(props.modelValue);
});

function fuseSearch(options: any, search: string) {
  const fuse = new Fuse(options, {
    keys: props.searchKeys,
    shouldSort: true,
  });

  return search.length && fuse.search(search).map(({ item }) => item);
}
</script>

<template>
  <v-select
    class="search-dropdown"
    :placeholder="placeholder"
    :label="label"
    :options="options"
    :reduce="(option: never) => option[index]"
    :filter="fuseSearch"
    v-model="value.state"
  >
    <template #option="option">
      <slot name="option" v-bind="option"></slot>
    </template>

    <template #selected-option="option">
      <slot name="selected-option" v-bind="option"></slot>
    </template>
  </v-select>
</template>