<script setup lang="ts">
import Logo from '@/components/website/Logo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col items-center justify-between gap-4 pt-2 xl:flex-row xl:px-[100px]">
        <Link :href="route('web.home')">
            <Logo />
        </Link>

        <div class="max-w-full flex-1 overflow-hidden">
            <Marquee class="[--duration:10s]" :fade="true">
                <Link :href="route('web.menu')" class="!font-bold whitespace-nowrap !text-yellow-300">
                    Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
                </Link>
            </Marquee>
        </div>

        <Logo class="max-xl:!hidden" />
    </div>
</template>
