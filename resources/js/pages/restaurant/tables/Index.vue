<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Restaurant',
        href: '#',
    },
    {
        title: 'Tafels afrekenen',
        href: '/restaurant/tables',
    },
];
</script>

<template>
    <Head title="Tafels afrekenen" />

    <AppLayout :breadcrumbs="breadcrumbs"> hier komt de tables page</AppLayout>
</template>
