<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Dish } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useFormat } from '@/composables/useFormat';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const { formatPrice, formatDate } = useFormat();


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Verkoop overzicht',
        href: '/dashboard',
    },
];

type SaleRecord = {
    created_at: string;
    dish: Dish;
    side_dish: Dish | null;
    note: string | null;
    quantity: number;
    subtotal: number;
};

const props = defineProps<{
    records: SaleRecord[],
    startDate: string,
    endDate: string
}>();

const BTW_PERCENTAGE = 0.09;

const omzet = computed(() => {
    return props.records.reduce((total, record) => total + record.subtotal, 0);
});

const btw = computed(() => {
    return omzet.value * BTW_PERCENTAGE;
});

const omzetExclBtw = computed(() => {
    return omzet.value - btw.value;
});

const startDate = ref(props.startDate);
const endDate = ref(props.endDate);

function maakOverzicht() {
    router.get(
        '/kassa/orders',
        {
            start_date: startDate.value,
            end_date: endDate.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid grid-cols-6 items-center">
                <div class="col-span-2 flex">
                    <div class="flex items-center gap-4 rounded border px-4 py-2">
                        <div>
                            <div class="flex items-center">
                                <p class="w-[10rem] font-medium">Begin datum</p>
                                <Input type="date" class="w-min" v-model="startDate" />
                            </div>
                            <div class="flex items-center">
                                <p class="w-[10rem] font-medium">Eind datum</p>
                                <Input type="date" class="w-min" v-model="endDate" />
                            </div>
                        </div>
                        <div class="grow">
                            <Button size="lg" @click="maakOverzicht">Maak overzicht</Button>
                        </div>
                    </div>
                    <div></div>
                </div>
                <div class="col-span-4 flex gap-12">
                    <div>
                        <h2>Omzet:</h2>
                        <p class="text-2xl font-bold">{{ formatPrice(omzet) }}</p>
                    </div>
                    <div>
                        <h2>BTW:</h2>
                        <p class="text-2xl font-bold">{{ formatPrice(btw) }}</p>
                    </div>
                    <div>
                        <h2>excl. BTW:</h2>
                        <p class="text-2xl font-bold">{{ formatPrice(omzetExclBtw) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Datum</TableHead>
                            <TableHead>Gerecht</TableHead>
                            <TableHead>Notitie</TableHead>
                            <TableHead>Prijs</TableHead>
                            <TableHead>Prijs bijgerecht</TableHead>
                            <TableHead>Aantal</TableHead>
                            <TableHead>Subtotaal</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(record, i) in records" :key="i">
                            <TableCell>{{ formatDate(record.created_at) }}</TableCell>
                            <TableCell>{{ record.dish.name }} <span v-if="record.side_dish" class="text-accent-foreground">(+{{record.side_dish.name}})</span></TableCell>
                            <TableCell>{{ record.note ?? "-" }}</TableCell>
                            <TableCell>{{ formatPrice(record.dish.price) }}</TableCell>
                            <TableCell>{{ record.side_dish ? formatPrice(record.side_dish.price) : "-" }}</TableCell>
                            <TableCell>{{ record.quantity }}</TableCell>
                            <TableCell>{{ formatPrice(record.subtotal) }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <!--            <div class="grid auto-rows-min gap-4 md:grid-cols-3">-->
            <!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
            <!--                    <PlaceholderPattern />-->
            <!--                </div>-->
            <!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
            <!--                    <PlaceholderPattern />-->
            <!--                </div>-->
            <!--                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">-->
            <!--                    <PlaceholderPattern />-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">-->
            <!--                <PlaceholderPattern />-->
            <!--            </div>-->
        </div>
    </AppLayout>
</template>
