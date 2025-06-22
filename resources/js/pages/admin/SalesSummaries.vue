<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import { useFormat } from '@/composables/useFormat';

const breadcrumbs = [
    {
        title: 'Verkoop Samenvattingen',
        href: '/admin/sales-summaries',
    },
];

const { formatDate } = useFormat();

const files = computed(() => usePage().props.files || []);

function basename(path: string) {
    return path.split(/[\\/]/).pop();
}

function getDateFromFilename(file: string) {
    const match = file.match(/sales_summary_(\d{4})_(\d{2})_(\d{2})/);
    if (match) {
        return formatDate(`${match[1]}-${match[2]}-${match[3]}`);
    }
    return '-';
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Dagelijkse Verkoop Samenvattingen" />
        <div class="container mt-4">
            <h1 class="pb-1 text-xl font-bold">Dagelijkse Verkoop Samenvattingen</h1>
            <p class="text-base">Download hier de automatisch gegenereerde Excel-bestanden met de omzet per dag.</p>

            <div class="mt-4 rounded border">
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
                            <TableCell>{{ getDateFromFilename(file) }}</TableCell>
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
