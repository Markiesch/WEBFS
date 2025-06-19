<script setup lang="ts">
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import { Dish } from '@/types';
import { Heart } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

defineProps<{ dishGroup: Record<string, Dish[]> }>();

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

onMounted(loadFavorites);
</script>

<template>
    <WebsiteLayout title="Menukaart">
        <section class="relative overflow-hidden !border !border-black bg-[#fefebe] p-4">
            <div v-if="dishGroup && Object.keys(dishGroup).length > 0" class="cols">
                <div v-for="[category, dishes] in Object.entries(dishGroup)" :key="category" class="mb-4">
                    <h2 class="!font-bold">{{ category }}</h2>
                    <div v-for="dish in dishes" :key="dish.id">
                        <p class="!mt-1 !mb-0 flex w-full items-center justify-between">
                            <button
                                @click="addDishToFavorites(dish.id)"
                                :class="['!mr-2 !p-0 hover:!text-gray-500', favorites.includes(dish.id) ? '!text-red-500' : '!text-black']"
                            >
                                <Heart class="h-6 w-6" />
                            </button>

                            <span>
                                <span v-html="dish.menu_number + '. ' + dish.name"></span>
                                &nbsp;
                                <span v-if="dish.description" class="!italic" v-html="'(' + dish.description + ')'"></span>
                            </span>
                            <span class="mx-2 flex-1 !border-b !border-dotted !border-black"></span>
                            <span class="whitespace-nowrap">&euro; {{ dish.price }}</span>
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
