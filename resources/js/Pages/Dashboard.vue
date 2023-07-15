<script setup lang="ts">
import Breadrumb from '@/Components/Breadrumb.vue';
import { CardLayout, CardHeader, CardBody } from '@/Components/Card.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ContentLayout from '@/Components/Content.vue';
import { Head } from '@inertiajs/vue3';
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
    </ContentLayout>
  </AuthenticatedLayout>
</template>