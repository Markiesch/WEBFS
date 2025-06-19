<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Dish } from '@/types';
import { Head } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';
import { defineProps } from 'vue';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps<{ dishGroup: Record<string, Dish[]> }>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-5">
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-3 overflow-auto rounded-xl border px-8 py-4">
                    <div v-for="[category, dishes] in Object.entries(dishGroup)" :key="category" class="pb-12">
                        <h2 class="pb-2 !font-bold">{{ category }}</h2>
                        <div v-for="dish in dishes" :key="dish.id" class="flex items-center">
                            <p class="text-muted-foreground basis-[5ch] font-mono">{{ dish.menu_number }}.</p>
                            <p v-html="dish.name" class="grow font-mono"></p>
                            <code class="font-mono pr-4">&euro;{{ dish.price }},-</code>

                            <Button size="icon" variant="ghost">
                                <PlusIcon />
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-2 overflow-auto rounded-xl border"></div>
            </div>
        </div>
    </AppLayout>
</template>
