<script setup lang="ts">
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
import { NewsPost } from '@/types';

defineProps<{ newsPosts: NewsPost[] }>();
</script>

<template>
    <WebsiteLayout title="Nieuws">
        <section class="!border !border-black bg-amber-50 p-4 text-center !font-bold">
            <div v-if="newsPosts.length > 0">
                <div v-for="(post, index) in newsPosts" :key="post.id" :class="[{ 'mb-4 !border-b pb-4': index !== newsPosts.length - 1 }]">
                    <h2>{{ post.title }}</h2>
                    <p>{{ post.content }}</p>
                </div>
            </div>
            <p v-else>Er zijn momenteel geen nieuwsberichten beschikbaar.</p>
        </section>
    </WebsiteLayout>
</template>

<style scoped></style>
