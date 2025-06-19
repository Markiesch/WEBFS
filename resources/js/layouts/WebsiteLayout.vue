<script setup lang="ts">
import TopBar from '@/components/website/TopBar.vue';
import WebsiteHeader from '@/components/website/WebsiteHeader.vue';
import { Head } from '@inertiajs/vue3';

interface Props {
    title?: string;
}

withDefaults(defineProps<Props>(), {
    title: 'Welkom',
});
</script>

<template>
    <Head :title="title">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="main-container">
        <TopBar />

        <main>
            <div class="bg-pattern max-md:hidden"></div>
            <WebsiteHeader />

            <slot />
        </main>
    </div>
</template>

<style>
body {
    background-color: darkred;
}
</style>

<style scoped>
.main-container {
    background-color: red;
    margin: 1rem min(3rem, 4vw);
}

main {
    position: relative;
    min-height: calc(100vh - 65px - 2rem);
    padding: min(100px, 20vw);
}

.bg-pattern {
    position: absolute;
    inset: 0.5rem;
    pointer-events: none;
}

.bg-pattern::before {
    content: '';
    position: absolute;
    inset: 0.5rem;
    background-image:
        url('/images/bg-horizontal.svg'), url('/images/bg-vertical.svg'), url('/images/bg-horizontal.svg'), url('/images/bg-vertical.svg');
    background-repeat: repeat-x, repeat-y, repeat-x, repeat-y;
    background-position:
        top center,
        center right,
        bottom center,
        center left;
    background-size:
        50px 26px,
        30px 58px,
        50px 26px,
        30px 58px;
}

.bg-pattern::after {
    content: '';
    position: absolute;
    inset: 0.5rem;
    background-image:
        url('/images/bg-top-left.svg'), url('/images/bg-top-right.svg'), url('/images/bg-bottom-left.svg'), url('/images/bg-bottom-right.svg');
    background-repeat: no-repeat, no-repeat, no-repeat, no-repeat;
    background-position:
        top left,
        top right,
        bottom left,
        bottom right;
    background-size: 100px, 100px, 100px, 100px;
}

@media screen and (max-width: 765px) {
    main {
        padding: 1em;
    }
}
</style>
