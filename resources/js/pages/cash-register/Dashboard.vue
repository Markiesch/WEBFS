<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Dish } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { MinusIcon, PlusIcon } from 'lucide-vue-next';
import { computed, defineProps, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{ dishGroup: Record<string, Dish[]>, commonNotes: string[] }>();

type Selection = {
    dish: Dish;
    note: string;
    quantity: number;
};

const maxDishQuantity = 99;
const note = ref('');
const selectedDishes = ref<Selection[]>([]);

const addDishToSelection = (dish: Dish) => {
    // Find by both dish id and note
    const existingSelection = selectedDishes.value.find(
        (selection) => selection.dish.id === dish.id && selection.note === note.value
    );
    if (existingSelection) {
        existingSelection.quantity = Math.min(existingSelection.quantity + 1, maxDishQuantity);
    } else {
        selectedDishes.value.push({ dish, quantity: 1, note: note.value });
    }
    note.value = '';
};

const filter = ref({
    text: '',
    category: '',
});

const subtractDishFromSelection = (dish: Dish, noteValue: string) => {
    // Find by both dish id and note
    const selectionIndex = selectedDishes.value.findIndex(
        (selection) => selection.dish.id === dish.id && selection.note === noteValue
    );
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

const allCategories = Object.keys(props.dishGroup);

const filteredDishes = computed(() => {
    return Object.entries(props.dishGroup).reduce(
        (acc, [category, dishes]) => {
            if (filter.value.category && category !== filter.value.category) {
                return acc;
            }

            const textFilter = filter.value.text.toLowerCase().trim();

            const filteredDishes = dishes.filter((dish) => (dish.menu_number + dish.name).toLowerCase().includes(textFilter));
            if (filteredDishes.length > 0) {
                acc[category] = filteredDishes;
            }
            return acc;
        },
        {} as Record<string, Dish[]>,
    );
});

const clearSelection = () => {
    selectedDishes.value = [];
};

const submit = () => {
    router.post(
        route('admin.order.create'),
        {
            dishes: selectedDishes.value.map((item) => ({
                dish_id: item.dish.id,
                price: item.dish.price,
                quantity: item.quantity,
                note: item.note,
            })),
        },
        {
            preserveScroll: true,
            onError: (errors) => {
                console.error('Error submitting selection:', errors);
            },
        },
    );
    clearSelection();
};

const resetFilters = () => {
    filter.value.text = '';
    filter.value.category = '';
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-5">
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-3 overflow-auto rounded-xl border px-8 py-4">
                    <div class="flex gap-2 pb-4">
                        <div class="grid grow grid-cols-2 gap-2">
                            <Input v-model="filter.text" placeholder="zoeken op naam of id..." />
                            <Select v-model="filter.category">
                                <SelectTrigger class="w-full">
                                    <SelectValue placeholder="Selecteer een categorie" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Categorieën</SelectLabel>
                                        <SelectItem v-for="(category, index) in allCategories" :key="index" :value="category">
                                            {{ category }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                        <Button @click="resetFilters">reset filters</Button>
                    </div>
                    <!-- Dish list -->
                    <div v-for="[category, dishes] in Object.entries(filteredDishes)" :key="category" class="pb-12">
                        <h2 class="pb-2 !font-bold">{{ category }}</h2>
                        <div v-for="dish in dishes" :key="dish.id" class="flex items-center">
                            <p class="text-muted-foreground basis-[5ch] font-mono">{{ dish.menu_number }}.</p>
                            <p v-html="dish.name" class="grow font-mono"></p>
                            <code class="pr-4 font-mono">{{ formatPrice(dish.price) }}</code>

                            <Dialog>
                                <DialogTrigger as-child>
                                    <Button size="sm" variant="ghost"  class="ml-2">toevoegen</Button>
                                </DialogTrigger>
                                <DialogContent class="sm:max-w-[425px]">
                                    <DialogHeader>
                                        <DialogTitle>Gerecht toegevoegen</DialogTitle>
                                        <DialogDescription class="text-muted-foreground mt-2">
                                            <span class="font-bold">Menu nummer:</span> {{ dish.menu_number }}<br />
                                            <span class="font-bold">Naam:</span> {{ dish.name }}<br />
                                            <span class="font-bold">Prijs:</span> {{ formatPrice(dish.price) }}
                                        </DialogDescription>
                                        <DialogDescription>Optioneel: voeg een notitie toe</DialogDescription>
                                        <Input v-model="note" />

                                        <DialogDescription class="mt-2" v-if="commonNotes.length">
                                            <p class="text-muted-foreground">Veelgebruikte notities:</p>
                                            <div class="flex gap-2" >
                                                <Button
                                                    v-for="(item, index) in commonNotes"
                                                    :key="index"
                                                    :variant="note === item ? 'default' : 'secondary'"
                                                    @click="note = item">
                                                    {{item}}
                                                </Button>
                                            </div>
                                        </DialogDescription>
                                    </DialogHeader>
                                    <DialogFooter>
                                        <DialogClose>
                                            <Button type="button" variant="secondary" @click="addDishToSelection(dish)">toevoegen</Button>
                                        </DialogClose>
                                    </DialogFooter>
                                </DialogContent>
                            </Dialog>
                        </div>
                    </div>
                </div>
                <div class="border-sidebar-border/70 dark:border-sidebar-border col-span-2 overflow-auto rounded-xl border p-4">
                    <div class="flex items-center justify-between border-b pb-4">
                        <h2 class="!font-bold">Selected Dishes</h2>
                        <Button :disabled="!selectedDishes.length" @click="clearSelection">verwijderen</Button>
                    </div>
                    <div v-if="selectedDishes.length === 0" class="text-muted-foreground py-2">Geen gerechten geselecteerd.</div>
                    <div v-for="selection in selectedDishes" :key="selection.dish.id + '-' + selection.note" class="flex items-center">
                        <p class="text-muted-foreground basis-[5ch] font-mono">{{ selection.dish.menu_number }}.</p>
                        <p v-html="selection.dish.name" class="grow font-mono"></p>
                        <span v-if="selection.note" class="ml-2 italic text-xs text-muted-foreground">({{ selection.note }})</span>
                        <div>
                            <Button size="sm" variant="ghost" class="ml-4 !px-1" @click="subtractDishFromSelection(selection.dish, selection.note)">
                                <MinusIcon />
                            </Button>
                            <span class="text-muted-foreground px-2 font-mono"> x{{ selection.quantity.toString().padStart(2, '0') }} </span>
                            <Button
                                size="sm"
                                variant="ghost"
                                :disabled="selection.quantity >= maxDishQuantity"
                                class="!px-1"
                                @click="selection.quantity++"
                            >
                                <PlusIcon />
                            </Button>
                        </div>
                        <div class="ml-4 basis-[6ch] border-l text-right">
                            <code class="font-mono">{{ formatPrice(selection.dish.price) }}</code>
                        </div>
                    </div>
                    <hr />
                    <div class="flex items-center">
                        <p class="text-muted-foreground grow basis-[5ch] font-mono">TOTAL</p>

                        <div class="ml-4 basis-[6ch] border-l text-right">
                            <code class="font-mono">{{ formatPrice(totalPrice) }}</code>
                        </div>
                    </div>

                    <Dialog>
                        <DialogTrigger as-child>
                            <Button :disabled="!selectedDishes.length" @click="submit">afrekenen</Button>
                        </DialogTrigger>
                        <DialogContent class="sm:max-w-[425px]">
                            <DialogHeader>
                                <DialogTitle>Gelukt!</DialogTitle>
                                <DialogDescription> De bestelling is succesvol geplaatst.</DialogDescription>
                            </DialogHeader>
                            <DialogFooter>
                                <DialogClose>
                                    <Button type="button" variant="secondary">OK</Button>
                                </DialogClose>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
