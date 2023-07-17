<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const props = withDefaults(
    defineProps<{
      size?: 'sm' | 'md' | 'lg';
      modelValue?: string | number | Date | null | undefined;
      options: Array<any>;
      label: string;
    }>(),
    {
      size: 'md',
    }
);

const emit = defineEmits(['update:modelValue']);

onMounted(() => {
  if (searchInput.value?.hasAttribute('autofocus')) {
    searchInput.value?.focus();
  }
});

defineExpose({ focus: () => searchInput.value?.focus() });

const options = ref(props.options);
const isSearching = ref(false);
const search = ref();
const searchInput = ref<HTMLInputElement | null>(null);
const selectedOptionIndex = ref(-1);

const filteredOptions = computed(() => {
  const searchQuery = search.value.toLowerCase().trim();

  if (searchQuery) {
    options.value = props.options;

    return options.value.filter(option => {
      return option[props.label].toLowerCase().includes(searchQuery);
    });
  }

  return props.options;
});

function handleSearchOptions() {
  selectedOptionIndex.value = -1;
  isSearching.value = true;
  options.value = filteredOptions.value;
}

function handleBlur() {
  isSearching.value = false;
}

function handleChooseOption(option: string) {
  search.value = option;
  isSearching.value = false;
  searchInput.value?.blur();
}

function handleArrowDown() {
  if (selectedOptionIndex.value < options.value.length - 1) {
    selectedOptionIndex.value++;
  }
}

function handleArrowUp() {
  if (selectedOptionIndex.value > 0) {
    selectedOptionIndex.value--;
  }
}

function handleEnter() {
  if (selectedOptionIndex.value !== -1) {
    const selectedOption = options.value[selectedOptionIndex.value][props.label];
    handleChooseOption(selectedOption);
  }
}

const baseClasses = [
  'ease-soft block w-full transition rounded-lg shadow-sm',
  'font-normal text-sm text-dark bg-white',
  'border border-light',
  'focus:outline-none focus:border-primary',
  'focus:-outline-offset-1 focus:outline-primary'
];

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm': return 'px-3 py-1';
    case 'lg': return 'px-3 py-3';
    default: return 'px-3 py-2';
  }
});
</script>

<template>
  <div class="relative">
    <input
      type="search"
      :class="[sizeClasses, baseClasses]"
      :value="modelValue"
      ref="searchInput"
      @input="handleSearchOptions"
      @focus="isSearching = true"
      @blur="handleBlur"
      @keydown.down.prevent="handleArrowDown"
      @keydown.up.prevent="handleArrowUp"
      @keydown.enter.prevent="handleEnter"
    />

    <div v-if="isSearching" class="mt-2 absolute max-h-64 overflow-y-auto bg-white w-full rounded-b-lg shadow-soft-2xl">
      <ul class="my-1 space-y-2 text-sm" role="listbox" tabindex="-1">
        <li
          v-if="options.length"
          v-for="(option, index) in options"
          role="option"
          class="py-1 px-4 cursor-pointer hover:text-white hover:bg-primary"
          :class="{ 'text-white bg-primary': selectedOptionIndex === index }"
          @click="handleChooseOption(option.name)">
          {{ option.name }}
        </li>
        <li v-else class="py-1 px-4 text-center">
          No match data is found
        </li>
      </ul>
    </div>
  </div>
</template>
