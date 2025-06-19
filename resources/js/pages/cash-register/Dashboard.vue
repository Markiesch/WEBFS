<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Dish } from '@/types';
import { Head } from '@inertiajs/vue3';
import { MinusIcon, PlusIcon } from 'lucide-vue-next';
import { computed, defineProps, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps<{ dishGroup: Record<string, Dish[]> }>();

type Selection = {
    dish: Dish;
    quantity: number;
};

const maxDishQuantity = 99;

const selectedDishes = ref<Selection[]>([]);
const addDishToSelection = (dish: Dish) => {
    const existingSelection = selectedDishes.value.find((selection) => selection.dish.id === dish.id);
    if (existingSelection) {
        existingSelection.quantity = Math.min(existingSelection.quantity + 1, maxDishQuantity);
    } else {
        selectedDishes.value.push({ dish, quantity: 1 });
    }
};

const subtractDishFromSelection = (dish: Dish) => {
    const selectionIndex = selectedDishes.value.findIndex((selection) => selection.dish.id === dish.id);
    if (selectionIndex !== -1) {
        const selection = selectedDishes.value[selectionIndex];
        if (selection.quantity > 1) {
            selection.quantity--;
        } else {
            selectedDishes.value.splice(selectionIndex, 1);
        }
    }
};

const totalPrice = computed(() => {
    return selectedDishes.value.reduce((total, selection) => {
        return total + selection.dish.price * selection.quantity;
    }, 0);
});

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2,
    }).format(price);
};
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
                            <code class="pr-4 font-mono">{{ formatPrice(dish.price) }}</code>

                            <Button size="icon" variant="ghost" @click="addDishToSelection(dish)" class="ml-2">
                                <PlusIcon />
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-2 overflow-auto rounded-xl border p-4">
                    <h2 class="pb-2 !font-bold">Selected Dishes</h2>
                    <div v-if="selectedDishes.length === 0" class="text-muted-foreground">No dishes selected.</div>
                    <div v-for="selection in selectedDishes" :key="selection.dish.id" class="flex items-center">
                        <p class="text-muted-foreground basis-[5ch] font-mono">{{ selection.dish.menu_number }}.</p>
                        <p v-html="selection.dish.name" class="grow font-mono"></p>
                        <div>
                            <Button size="sm" variant="ghost" class="ml-4 !px-1" @click="subtractDishFromSelection(selection.dish)">
                                <MinusIcon />
                            </Button>
                            <span class="text-muted-foreground px-2 font-mono"> x{{ selection.quantity.toString().padStart(2, '0') }} </span>
                            <Button
                                size="sm"
                                variant="ghost"
                                :disabled="selection.quantity >= maxDishQuantity"
                                class="!px-1"
                                @click="addDishToSelection(selection.dish)"
                            >
                                <PlusIcon />
                            </Button>
                        </div>
                        <div class="border-l basis-[6ch] text-right ml-4">
                            <code class="font-mono">{{ formatPrice(selection.dish.price) }}</code>
                        </div>
                    </div>
                    <hr />
                    <div class="flex items-center">
                        <p class="text-muted-foreground basis-[5ch] font-mono grow">TOTAL</p>

                        <div class="border-l basis-[6ch] text-right ml-4">
                            <code class="font-mono">{{ formatPrice(totalPrice) }}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
