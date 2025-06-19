<script setup lang="ts">
import WebsiteLayout from '@/layouts/WebsiteLayout.vue';
</script>

<template>
    <WebsiteLayout title="Home">
        <section class="!border !border-black bg-amber-50 p-4 text-center !font-bold">
            <p class="!mx-auto !mb-10 max-w-3xl">
                Al jaren is De Gouden Draak een begrip als het gaat om de beste afhaalgerechten in 's-Hertogenbosch. Graag trakteren we u op
                authentieke gerechten uit de Cantonese keuken.
            </p>

            <p class="!text-2xl underline">Speciale Studentenaanbieding</p>
            <h2 class="!my-6 !text-4xl">Chinese Rijsttafel (2 personen)</h2>

            <p>Maak een keuze uit 3 van onderstaande keuzegerechten:</p>
            <div class="my-6 flex flex-wrap justify-center md:gap-10">
                <ul class="md:text-end">
                    <li>Koe Loe Yuk</li>
                    <li>Tjap Tjoy</li>
                    <li>Babi Pangang</li>
                </ul>
                <ul class="md:text-left">
                    <li>Foe Yong Hai</li>
                    <li>Garnalen met Gebakken Knoflook</li>
                    <li>Kipfilet in Zwarte Bonen saus</li>
                </ul>
            </div>

            <p>Met witte rijst. (Nasi of bami voor meerprijs mogelijk.)</p>

            <p class="!mt-6 !text-4xl">Prijs: €21,00</p>
        </section>
    </WebsiteLayout>
</template>
