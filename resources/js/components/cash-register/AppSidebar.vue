<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ConciergeBell, Martini, ReceiptEuro, ReceiptJapaneseYen, Users, Utensils } from 'lucide-vue-next';
import AppLogo from '../AppLogo.vue';

const mainNavItems: { title: string; items: NavItem[] }[] = [
    {
        title: 'Kassa',
        items: [
            {
                title: 'Dashboard',
                href: '/kassa/dashboard',
                icon: ConciergeBell,
            },
            {
                title: 'Verkoop overzicht',
                href: '/kassa/orders',
                icon: ReceiptJapaneseYen,
            },
        ],
    },
    {
        title: 'Restaurant',
        items: [
            {
                title: 'Bezoekers registreren',
                href: '/restaurant/visitors',
                icon: Users,
            },
            {
                title: 'Tafels afrekenen',
                href: '/restaurant/tables',
                icon: ReceiptEuro,
            },
        ],
    },
    {
        title: 'Tablet',
        items: [
            {
                title: 'Cocktails',
                href: '/tablet/cocktails',
                icon: Martini,
            },
        ],
    },
    {
        title: 'Admin',
        items: [
            {
                title: 'Menukaart beheren',
                href: '/admin/menu',
                icon: Utensils,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>
        <hr class="mb-2" />

        <SidebarContent>
            <template v-for="navGroup in mainNavItems" :key="navGroup.title">
                <NavMain :items="navGroup.items" :title="navGroup.title" />
            </template>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
