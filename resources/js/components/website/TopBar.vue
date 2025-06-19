<script setup lang="ts">
import Logo from '@/components/website/Logo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex items-center justify-between gap-4 px-[100px] pt-2">
        <Logo />

        <div class="flex-1 overflow-hidden">
            <Marquee class="[--duration:10s]" :fade="true">
                <Link :href="route('web.menu')" class="!font-bold whitespace-nowrap !text-yellow-300">
                    Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
                </Link>
            </Marquee>
        </div>

        <Logo />
    </div>
</template>
