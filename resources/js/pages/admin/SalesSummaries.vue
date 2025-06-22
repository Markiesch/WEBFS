<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Dagelijkse Verkoop Samenvattingen" />
    <div class="container mt-4">
      <h1>Dagelijkse Verkoop Samenvattingen</h1>
      <p>Download hier de automatisch gegenereerde Excel-bestanden met de omzet per dag.</p>
      <ul class="list-group mt-3">
        <li v-for="file in files" :key="file" class="list-group-item d-flex justify-content-between align-items-center">
          {{ basename(file) }}
          <a :href="route('admin.sales_summaries.download', { filename: basename(file) })" class="btn btn-sm btn-primary">Download</a>
        </li>
        <li v-if="files.length === 0" class="list-group-item">Geen samenvattingen gevonden.</li>
      </ul>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const breadcrumbs = [
  {
    title: 'Verkoop Samenvattingen',
    href: '/admin/sales-summaries',
  },
];

const files = computed(() => usePage().props.files || []);
function basename(path: string) {
  return path.split(/[\\/]/).pop();
}
</script>
