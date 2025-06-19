<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="mb-10 flex items-center justify-between gap-2">
        <img src="/images/dragon-small.png" alt="Dragon Logo" class="!hidden md:h-16 md:w-16 lg:h-52 lg:w-52" />

        <div>
            <h1 class="text-center !text-5xl !font-bold text-yellow-300">
                Chinees Indische Specialiteiten<br />
                De Gouden Draak
            </h1>

            <div class="mt-4 flex flex-wrap justify-center gap-1">
                <Link
                    :href="route('web.menu')"
                    class="min-w-36 bg-linear-to-b from-sky-200 via-blue-500 to-blue-700 py-[3px] text-center !text-white"
                >
                    Menukaart
                </Link>
                <Link
                    :href="route('web.news')"
                    class="min-w-36 bg-linear-to-b from-sky-200 via-blue-500 to-blue-700 py-[3px] text-center !text-white"
                >
                    Nieuws
                </Link>
                <Link
                    :href="route('web.contact')"
                    class="min-w-36 bg-linear-to-b from-sky-200 via-blue-500 to-blue-700 py-[3px] text-center !text-white"
                >
                    Contact
                </Link>
            </div>
        </div>

        <img src="/images/dragon-small-flipped.png" alt="Dragon Logo Flipped" class="!hidden md:h-16 md:w-16 lg:h-52 lg:w-52" />
    </div>
</template>
