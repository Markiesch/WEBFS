<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Table } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { BadgeCheck } from 'lucide-vue-next';
import { computed, defineProps, ref } from 'vue';

// Props
defineProps<{ tables: Table[] }>();

// Variables
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Restaurant',
        href: '#',
    },
    {
        title: 'Bezoekers registreren',
        href: '/restaurant/visitors',
    },
];
const guests = ref<{ birthdate: string; has_deluxe_menu: boolean }[]>([]);
const dateOfBirth = ref<string>();
const hasDeluxeMenu = ref(false);
const form = useForm({
    table: null,
    guests: computed(() => guests.value) as unknown as { [key: string]: string | boolean | null },
});
const success = ref<boolean>(false);

//
// Functions
const addGuestToTable = (guest: { birthdate: string; has_deluxe_menu: boolean }) => {
    if (!guest.birthdate) return;

    guests.value.push({
        birthdate: guest.birthdate || '',
        has_deluxe_menu: guest.has_deluxe_menu || false,
    });
    dateOfBirth.value = '';
    hasDeluxeMenu.value = false;
    success.value = false;
};
const age = (d: string) => {
    const [jj, mm, dd] = d.split('-').map(Number);
    const g = new Date(jj, mm - 1, dd);
    const v = new Date();
    return v.getFullYear() - g.getFullYear() - (v < new Date(v.getFullYear(), g.getMonth(), g.getDate()) ? 1 : 0);
};
const submit = () => {
    success.value = false;
    form.post('/restaurant/visitors/save', {
        onSuccess: () => {
            guests.value = [];
            dateOfBirth.value = '';
            hasDeluxeMenu.value = false;
            form.reset();
            success.value = true;
        },
    });
};
</script>

<template>
    <Head title="Bezoekers registreren" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="my-4 px-8" v-if="success">
            <Alert variant="success">
                <BadgeCheck class="h-4 w-4" />
                <AlertTitle>De bezoekers zijn geregistreerd!</AlertTitle>
                <AlertDescription>De gasten zijn gekoppeld aan de tafel.</AlertDescription>
            </Alert>
        </div>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl px-8 py-4 md:flex-row md:justify-between md:gap-12">
            <div class="md:flex-1">
                <h1 class="text-2xl font-bold">Bezoekers registreren</h1>
                <p class="text-base">
                    Selecteer een tafel en voeg in het <span class="max-md:hidden">rechter</span><span class="md:hidden">onderstaande</span> paneel
                    gasten toe. Deze verschijnen automatisch in de lijst.
                </p>
                <form @submit.prevent="submit" class="mt-6">
                    <!-- Select Table -->
                    <div>
                        <Label for="table" class="mb-2">Tafel</Label>
                        <Select v-model="form.table" required>
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Selecteer een tafel" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Tafels</SelectLabel>
                                    <SelectItem v-for="(table, index) in tables" :key="index" :value="table.id">
                                        Tafel
                                        {{ table.id }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.table" />
                    </div>

                    <!-- Guest list -->
                    <div class="my-4 border-t border-b py-4">
                        <h3 class="font-bold">Gasten (max. 8)</h3>
                        <p v-if="guests.length == 0" class="text-base text-gray-600">Er zijn nog geen gasten toegevoegd</p>
                        <div v-for="(guest, index) in guests" :key="index" class="flex items-center justify-between p-2">
                            <p class="flex gap-2 text-base">
                                <span>{{ index + 1 }}</span>
                                <span class="text-gray-400">|</span>
                                <span>
                                    {{ new Date(guest.birthdate).toLocaleDateString('nl-NL') }}
                                    ({{ age(guest.birthdate) }} jaar)
                                </span>
                                <span class="text-gray-400">|</span>
                                <span>Deluxe menu: {{ guest.has_deluxe_menu ? 'Ja' : 'Nee' }}</span>
                            </p>
                            <button type="button" @click="guests.splice(index, 1)" class="text-base text-red-500 hover:text-red-700">
                                Verwijder
                            </button>
                        </div>
                    </div>

                    <Button type="submit">Tafel opslaan</Button>
                </form>
            </div>

            <!-- Add guest Form -->
            <div>
                <div class="min-w-[20vw] rounded-md border p-4" v-if="guests.length < 8">
                    <h2 class="font-bold">Gasten toevoegen</h2>

                    <div>
                        <Label class="mb-2" for="birthdate">Geboortedatum</Label>
                        <Input
                            id="birthdate"
                            type="date"
                            placeholder="dd-mm-jjjj"
                            v-model="dateOfBirth"
                            :min="'01-01-' + (new Date().getFullYear() - 120).toString()"
                            :max="new Date().toLocaleDateString('nl-NL')"
                            class="w-full"
                            required
                            title="Gebruik het formaat dd-mm-jjjj"
                        />
                    </div>

                    <div class="mt-4">
                        <Label class="mb-2" for="deluxeMenu">Deluxe menu</Label>
                        <Switch id="deluxeMenu" v-model="hasDeluxeMenu" />
                    </div>

                    <div class="mt-4">
                        <Button variant="outline" @click="addGuestToTable({ birthdate: dateOfBirth ?? '', has_deluxe_menu: hasDeluxeMenu })">
                            Voeg gast toe
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
