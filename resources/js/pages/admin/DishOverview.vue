<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// ShadCN imports
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Dialog, DialogClose, DialogContent, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Gerechten',
        href: '/dishes',
    },
];

const dishes = ref((usePage().props.dishes as any[]) || []);
const pagination = ref((usePage().props.pagination as any) || {});
const form = ref({
    id: null,
    name: '',
    price: '',
    menu_number: '',
    description: '',
    category_id: '',
    is_side_dish: false,
});
const dialogOpen = ref(false);
const isEdit = ref(false);

function openCreateDialog() {
    isEdit.value = false;
    Object.assign(form.value, {
        id: null,
        name: '',
        price: '',
        menu_number: '',
        description: '',
        category_id: '',
        is_side_dish: false,
    });
    dialogOpen.value = true;
}

function openEditDialog(dish: any) {
    isEdit.value = true;
    Object.assign(form.value, { ...dish });
    dialogOpen.value = true;
}

function submitForm() {
    if (isEdit.value && form.value.id) {
        router.patch(`/admin/dishes/${form.value.id}`, form.value, {
            onSuccess: () => {
                dialogOpen.value = false;
                router.reload({ only: ['dishes', 'pagination'] });
            },
        });
    } else {
        router.post('/admin/dishes', form.value, {
            onSuccess: () => {
                dialogOpen.value = false;
                router.reload({ only: ['dishes', 'pagination'] });
            },
        });
    }
}

function deleteDish(id: number) {
    if (confirm('Verwijder dit gerecht?')) {
        router.delete(`/admin/dishes/${id}`, {
            onSuccess: () => router.reload({ only: ['dishes', 'pagination'] }),
        });
    }
}

function gotoPage(page: number) {
    router.get(
        '/admin/dishes',
        { page },
        {
            preserveScroll: true,
        },
    );
}
</script>

<template>
    <Head title="Gerechten" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Gerechten</h2>
                <Button @click="openCreateDialog">Nieuw gerecht</Button>
            </div>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Menu nr</TableHead>
                        <TableHead>Naam</TableHead>
                        <TableHead>Prijs</TableHead>
                        <TableHead>Categorie</TableHead>
                        <TableHead>Bijgerecht</TableHead>
                        <TableHead>Acties</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="dish in dishes" :key="dish.id">
                        <TableCell>{{ dish.menu_number }}</TableCell>
                        <TableCell>{{ dish.name }}</TableCell>
                        <TableCell>€ {{ dish.price }}</TableCell>
                        <TableCell>{{ dish.category?.name ?? dish.category_id }}</TableCell>
                        <TableCell>
                            <Checkbox :checked="dish.is_side_dish" disabled />
                        </TableCell>
                        <TableCell>
                            <Button size="sm" variant="outline" @click="openEditDialog(dish)">Bewerken</Button>
                            <Button size="sm" variant="destructive" class="ml-2" @click="deleteDish(dish.id)"> Verwijderen </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <div class="mt-4 flex justify-center">
                <Pagination v-slot="{ page }" :items-per-page="pagination.per_page" :total="pagination.total" :page="pagination.current_page" @update:page="gotoPage">
                    <PaginationContent v-slot="{ items }">
                        <PaginationPrevious />

                        <template v-for="(item, index) in items" :key="index">
                            <PaginationItem
                                v-if="item.type === 'page'"
                                :value="item.value"
                                :is-active="item.value === page"
                            >
                                {{ item.value }}
                            </PaginationItem>
                        </template>

                        <PaginationNext />
                    </PaginationContent>
                </Pagination>
            </div>
            <Dialog v-model:open="dialogOpen">
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{{ isEdit ? 'Gerecht bewerken' : 'Nieuw gerecht toevoegen' }}</DialogTitle>
                    </DialogHeader>
                    <form @submit.prevent="submitForm" class="mt-2 flex flex-col gap-4">
                        <Input v-model="form.menu_number" placeholder="Menu nummer" required />
                        <Input v-model="form.name" placeholder="Naam" required />
                        <Input v-model="form.price" placeholder="Prijs" type="number" step="0.01" required />
                        <Input v-model="form.category_id" placeholder="Categorie ID" required />
                        <Input v-model="form.description" placeholder="Beschrijving" />
                        <div class="flex items-center gap-2">
                            <Checkbox v-model:checked="form.is_side_dish" />
                            <span>Bijgerecht</span>
                        </div>
                        <DialogFooter>
                            <Button type="submit">{{ isEdit ? 'Opslaan' : 'Toevoegen' }}</Button>
                            <DialogClose as-child>
                                <Button type="button" variant="outline">Annuleren</Button>
                            </DialogClose>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    </AppLayout>
</template>
