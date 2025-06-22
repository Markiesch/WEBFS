<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Dish } from '@/types';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menukaart',
        href: '/menu',
    },
];

// defineProps<{ dishes: Record<string, Dish[]> }>();
//
// const filter = reactive({
//     text: '',
//     category: '',
// });
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-5">
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-3 overflow-auto rounded-xl border px-8 py-4">
                    <div class="flex gap-2 pb-4">
                        <div class="grid grow grid-cols-2 gap-2">
<!--                            <Input v-model="filter.text" placeholder="zoeken op naam of id..." />-->
                            <!--                            <Select v-model="filter.category">-->
                            <!--                                <SelectTrigger class="w-full">-->
                            <!--                                    <SelectValue placeholder="Selecteer een categorie" />-->
                            <!--                                </SelectTrigger>-->
                            <!--                                <SelectContent>-->
                            <!--                                    <SelectGroup>-->
                            <!--                                        <SelectLabel>Categorieën</SelectLabel>-->
                            <!--                                        <SelectItem v-for="(category, index) in allCategories" :key="index" :value="category">-->
                            <!--                                            {{ category }}-->
                            <!--                                        </SelectItem>-->
                            <!--                                    </SelectGroup>-->
                            <!--                                </SelectContent>-->
                            <!--                            </Select>-->
                        </div>
                        <Button>reset filters</Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
