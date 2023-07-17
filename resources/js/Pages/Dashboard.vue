<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ContentLayout from '@/Components/Content.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed } from 'vue';
import { FormSelectSearch } from '@/Components/Form.vue';

const isSearching = ref(false);
const search = ref();
const searchInput = ref<HTMLInputElement | null>(null);
const selectedOptionIndex = ref(-1);

const label = 'name';
const origins = [
  { name: 'Earth' },
  { name: 'Sun' },
  { name: 'Jupiter' },
  { name: 'Venus' },
  { name: 'Mars' },
  { name: 'Earth' },
  { name: 'Sun' },
  { name: 'Jupiter' },
  { name: 'Venus' },
  { name: 'Mars' },
  { name: 'Earth' },
  { name: 'Sun' },
  { name: 'Jupiter' },
  { name: 'Venus' },
  { name: 'Mars' },
];

const options = ref(origins);

const filteredOptions = computed(() => {
  const searchQuery = search.value.toLowerCase().trim();

  if (searchQuery) {
    options.value = origins;

    return options.value.filter(option => {
      return option[label].toLowerCase().includes(searchQuery);
    });
  }

  return origins;
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
    const selectedOption = options.value[selectedOptionIndex.value][label];
    handleChooseOption(selectedOption);
  }
}
</script>

<template>
  <Head title="Dashboard" />
  
  <AuthenticatedLayout>
    <template v-slot:breadcrumb>
      <Breadrumb v-slot:breadcrumb v-bind="{ second: 'Admin', current: 'Dashboard' }" />
    </template>

    <ContentLayout>
      <CardLayout class="w-1/2">
				<CardHeader>
          <div class="flex justify-between items-center">
						<h5 class="font-bold text-xl text-dark">Dashboard</h5>
          </div>
        </CardHeader>
				<CardBody>
					<div class="flex justify-between items-center">
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt labore eius accusamus ipsa quidem eaque odit, aut ullam minus explicabo minima culpa nobis amet ad mollitia eos et, quasi sint!</p>
					</div>
				</CardBody>
      </CardLayout>

      <!-- <div class="w-1/2">
        <form-select-search
          size="lg"
          :options="origins"
          label="name"
          placeholder="Choose Origin"
        />
      </div> -->
    </ContentLayout>
  </AuthenticatedLayout>
</template>