<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import { Dish } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Heart } from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';

const props = defineProps<{
    dishGroup: Record<string, Dish[]>;
}>();

const storageKey = 'Dishes';
const favorites = ref<number[]>([]);

function loadFavorites() {
    const stored = localStorage.getItem(storageKey);
    try {
        if (stored != null) {
            favorites.value = JSON.parse(stored) ?? [];
        }
    } catch {
        favorites.value = [];
    }
}

function addDishToFavorites(dishId: number) {
    const index = favorites.value.indexOf(dishId);
    if (index === -1) {
        favorites.value.push(dishId);
    } else {
        favorites.value.splice(index, 1);
    }
    localStorage.setItem(storageKey, JSON.stringify(favorites.value));
}

function getDishById(id: number): Dish | undefined {
    for (const dishes of Object.values(props.dishGroup)) {
        const found = dishes.find((dish) => dish.id === id);
        if (found) return found;
    }
    return undefined;
}

const form = useForm({
    filter: 'all',
});

const favoriteDishes = computed(() => {
    let dishes = favorites.value.map((id) => getDishById(id)).filter((dish): dish is Dish => !!dish);

    switch (form.filter) {
        case 'favorites_asc':
            dishes = dishes.slice().sort((a, b) => a.id - b.id);
            break;
        case 'favorites_desc':
            dishes = dishes.slice().sort((a, b) => b.id - a.id);
            break;
        case 'favorites_name_asc':
            dishes = dishes.slice().sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'favorites_name_desc':
            dishes = dishes.slice().sort((a, b) => b.name.localeCompare(a.name));
            break;
    }
    return dishes;
});

onMounted(loadFavorites);
</script>

<template>
    <WebsiteLayout title="Menukaart">
        <div class="text-end" v-if="favorites.length > 0">
            <form @submit.prevent>
                <select v-model="form.filter" name="filter" class="bg-linear-to-b from-sky-200 via-blue-500 to-blue-700">
                    <option value="all">Alle categorieën</option>
                    <option value="favorites_asc">Favorieten (nummer oplopend)</option>
                    <option value="favorites_desc">Favorieten (nummer aflopend)</option>
                    <option value="favorites_name_asc">Favorieten (naam oplopend)</option>
                    <option value="favorites_name_desc">Favorieten (naam aflopend)</option>
                </select>
                <InputError class="mt-2" :message="form.errors.filter" />
            </form>
        </div>

        <section class="mb-6 !border !border-black bg-[#fefebe] p-4" v-if="favorites.length > 0 && form.filter != 'all'">
            <h2 class="!font-bold">FAVORIETEN</h2>
            <div v-for="dish in favoriteDishes" :key="dish.id">
                <p class="!mt-1 !mb-0 flex w-full items-center justify-between">
                    <button @click="addDishToFavorites(dish.id)" class="!mr-2 !p-0 hover:!text-gray-500">
                        <Heart :class="['h-6 w-6', favorites.includes(dish.id) ? '!fill-red-500' : '']" />
                    </button>
                    <span>
                        <span v-html="dish.menu_number + '. ' + dish.name"></span>
                        &nbsp;
                        <span v-if="dish.description" class="!italic" v-html="'(' + dish.description + ')'"></span>
                    </span>
                    <span class="mx-2 flex-1 !border-b !border-dotted !border-black"></span>
                    <span>&euro; {{ dish.price }}</span>
                </p>
            </div>
        </section>

        <section class="!border !border-black bg-[#fefebe] p-4">
            <div v-if="dishGroup && Object.keys(dishGroup).length > 0" class="cols">
                <div v-for="[category, dishes] in Object.entries(dishGroup)" :key="category" class="mb-4">
                    <h2 class="!font-bold">{{ category }}</h2>
                    <div v-for="dish in dishes" :key="dish.id">
                        <p class="!mt-1 !mb-0 flex w-full items-center justify-between">
                            <button @click="addDishToFavorites(dish.id)" class="!mr-2 !p-0 hover:!text-gray-500">
                                <Heart :class="['h-6 w-6', favorites.includes(dish.id) ? '!fill-red-500' : '']" />
                            </button>

                            <span>
                                <span v-html="dish.menu_number + '. ' + dish.name"></span>
                                &nbsp;
                                <span v-if="dish.description" class="!italic" v-html="'(' + dish.description + ')'"></span>
                            </span>
                            <span class="mx-2 flex-1 !border-b !border-dotted !border-black"></span>
                            <span>&euro; {{ dish.price }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <p v-else>Er zijn geen gerechten gevonden.</p>
        </section>
    </WebsiteLayout>
</template>

<style scoped>
.cols {
    column-count: 2;
    column-gap: 2em;
}

@media screen and (max-width: 1280px) {
    .cols {
        column-count: 1;
    }
}
</style>
