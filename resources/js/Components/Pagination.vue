<script setup lang="ts">
import { Pagination } from '@/types';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
  pagination: Pagination;
}>();

const links = computed(() => {
  return props.pagination.links.map(link => {
    const previous = '&laquo; Previous';
    const next = 'Next &raquo;';

    let updatedLabel = '';

    if (link.label === previous) {
      updatedLabel = 'Previous';
    }
    
    else if (link.label === next) {
      updatedLabel = 'Next';
    }
    
    else {
      updatedLabel = link.label
    }

    return {
      ...link,
      label: updatedLabel
    };
  });
});
</script>

<template>
  <div class="m-6 flex justify-between items-center">
    <p class="text-sm">Showing data
      from <span class="text-dark">{{ pagination.from }}</span>
      - <span class="text-dark">{{ pagination.to }}</span>
      out of <span class="text-dark">{{ pagination.total }}</span> total data
    </p>

    <ul class="flex gap-2">
      <li v-for="link in links">
        <Link :href="link.url || ''">
          <ease-button
            :variant="link.active ? 'primary' : 'transparent'"
            :disabled="link.url === null"
            :text="link.label"
          />
        </Link>
      </li>
    </ul>
  </div>
</template>