<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Search } from 'lucide-vue-next';
import { nextTick, onMounted, ref } from 'vue';

const API_URL = 'https://www.thecocktaildb.com/api/json/v1/1/';

const loading = ref(true);
const categories = ref<{ strCategory: string }[]>([]);
const cocktails = ref<Record<string, any>[]>([]);
const filter = ref({
    search: '',
    category: 'Cocktail',
});

// Fetch categories from the API
const fetchCategories = async () => {
    loading.value = true;
    await nextTick();

    try {
        const categoriesResponse = await fetch(API_URL + 'list.php?c=list');
        const data = await categoriesResponse.json();
        categories.value = data.drinks;
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};

// Search and filter
const search = () => {
    if (filter.value.search) {
        filter.value.category = 'All';
        searchByName();
    } else {
        filter.value.category = 'Cocktail';
        filterByCategory();
    }
};
const searchByName = async () => {
    loading.value = true;
    await nextTick();

    try {
        const searchResponse = await fetch(API_URL + `search.php?s=${filter.value.search}`);
        const data = await searchResponse.json();
        cocktails.value = data.drinks || [];
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};
const filterByCategory = async () => {
    loading.value = true;
    filter.value.search = '';
    await nextTick();

    try {
        console.log('in try');
        const categoryResponse = await fetch(API_URL + `filter.php?c=${filter.value.category}`);
        console.log(categoryResponse);

        const data = await categoryResponse.json();
        console.log(data);
        cocktails.value = data.drinks || [];
        console.log(cocktails.value);
    } catch (error) {
        console.error('Error fetching data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchCategories();
    search();
});
</script>

<template>
    <header class="container border-b py-4">
        <div class="mx-auto flex w-fit items-center gap-x-2">
            <AppLogo />
        </div>
    </header>

    <main class="container px-4 py-8">
        <!-- Search and filter section -->
        <section class="mb-6 flex flex-col justify-between gap-8 lg:flex-row lg:items-center" v-if="categories">
            <div>
                <h1 class="text-3xl font-bold">Cocktails</h1>
                <p class="text-base">Zoek op een naam van een cocktail in de zoekbalk, of filter en zie alle cocktails per categorie.</p>
            </div>
            <div class="flex flex-col gap-4 md:flex-row md:items-center">
                <Select v-model="filter.category" @update:model-value="filterByCategory" class="max-md:w-full">
                    <SelectTrigger class="w-full md:w-52">
                        <SelectValue placeholder="Selecteer een categorie" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Categorieën</SelectLabel>
                            <SelectItem v-for="(category, index) in categories" :key="index" :value="category.strCategory">
                                {{ category.strCategory }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <div class="relative w-full items-center md:max-w-sm">
                    <Input id="search" v-model="filter.search" type="text" placeholder="Zoek een cocktail op naam" class="pl-10" @input="search" />
                    <span class="absolute inset-y-0 start-0 flex items-center justify-center px-2">
                        <Search class="text-muted-foreground size-6" />
                    </span>
                </div>
            </div>
        </section>
        <p class="text-center" v-else>Er is iets misgegaan...</p>

        <!-- Cocktails list section -->
        <section v-if="loading" class="text-center">
            <div class="flex flex-col items-center justify-center gap-4">
                <svg class="h-8 w-8 animate-spin text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2.93 6.364A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3.93-1.574z"
                    ></path>
                </svg>

                <p class="text-gray-500">Laden...</p>
            </div>
        </section>
        <section v-else-if="cocktails.length">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div v-for="cocktail in cocktails" :key="cocktail.idDrink" class="rounded-lg border shadow-sm transition-shadow hover:shadow-md">
                    <img v-if="cocktail.strDrinkThumb" :src="cocktail.strDrinkThumb" alt="" class="w-full rounded-t-md" />
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">{{ cocktail.strDrink }}</h2>
                        <p class="text-muted-foreground text-sm">
                            <span v-if="cocktail.strCategory">{{ cocktail.strCategory }}</span>
                            <span v-else-if="filter.category !== 'all'">
                                {{ filter.category }}
                            </span>
                        </p>
                        <p class="mt-2 text-sm">{{ cocktail.strInstructions }}</p>
                    </div>
                </div>
            </div>
        </section>
        <p class="my-6 text-center text-gray-600" v-else>Er zijn geen cocktails gevonden.</p>
    </main>

    <footer class="container border-t py-4">
        <p class="text-center text-sm text-gray-500">© {{ new Date().getFullYear() }} De Gouden Draak</p>
    </footer>
</template>

<style scoped></style>
