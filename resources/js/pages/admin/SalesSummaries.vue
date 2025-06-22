<script setup lang="ts">
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
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

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Dagelijkse Verkoop Samenvattingen" />
        <div class="container mt-4">
            <h1 class="text-xl font-bold pb-1">Dagelijkse Verkoop Samenvattingen</h1>
            <p class="text-base">Download hier de automatisch gegenereerde Excel-bestanden met de omzet per dag.</p>

            <div class="rounded border mt-4">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Datum</TableHead>
                            <TableHead>Bestand</TableHead>
                            <TableHead>Acties</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="file in files" :key="file">
                            <TableCell class="col-span-2">{{ file }}</TableCell>
                            <TableCell>{{ basename(file) }}</TableCell>
                            <TableCell>
                                <a :href="route('admin.sales_summaries.download', { filename: basename(file) })" class="btn btn-sm btn-primary"
                                    >Download</a
                                >
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
