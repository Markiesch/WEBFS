<script setup lang="ts">
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
</script>

<template>
    <WebsiteLayout title="Contact">
        <section class="!border !border-black bg-amber-50 p-4 text-center !font-bold">
            <p class="!mb-6">De Gouden Draak is eenvoudig te vinden, vlak bij het centrum, 5 minuten lopen achter het centraal station.</p>
            <p>Onderwijsboulevard 215, kamer OG112</p>
            <p>5223 DE 's-Hertogenbosch</p>
        </section>
        <section class="bg-gray-200">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2473.432987711052!2d5.284448915590253!3d51.68852110526529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6ee8855f3c5d1%3A0x4c4797f27d227e73!2sOnderwijsboulevard%20215%2C%205223%20DE%20&#39;s-Hertogenbosch!5e0!3m2!1sen!2snl!4v1585055473064!5m2!1sen!2snl"
                width="100%"
                height="450"
                frameborder="0"
                style="border: 0"
                aria-hidden="false"
                tabindex="0"
            ></iframe>
        </section>
    </WebsiteLayout>
</template>

<style scoped></style>
