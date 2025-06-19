<script setup lang="ts">
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import { Dish } from '@/types';

defineProps<{ dishGroup: Record<string, Dish[]> }>();
</script>

<template>
    <WebsiteLayout title="Menukaart">
        <section class="relative overflow-hidden !border !border-black bg-[#fefebe] p-4">
            <div v-if="dishGroup && Object.keys(dishGroup).length > 0" style="column-count: 2; column-gap: 2em">
                <div v-for="[category, dishes] in Object.entries(dishGroup)" :key="category" class="mb-4">
                    <h2 class="!font-bold">{{ category }}</h2>
                    <div v-for="dish in dishes" :key="dish.id">
                        <p class="!mt-1 !mb-0 flex w-full items-center justify-between">
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

<style scoped></style>
