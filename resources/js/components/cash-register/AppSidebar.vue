<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ConciergeBell, Martini, ReceiptJapaneseYen, Users, Utensils } from 'lucide-vue-next';
import AppLogo from '../AppLogo.vue';
import { computed } from 'vue';

const page = usePage()
const user = computed(() => page.props.auth.user)

const mainNavItems = computed(() => {
    const items = [
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
    ];
    if (user.value && user.value.name.toLowerCase() === 'admin') {
        items.push({
            title: 'Admin',
            items: [
                {
                    title: 'Menukaart beheren',
                    href: '/admin/dishes',
                    icon: Utensils,
                },
                {
                    title: 'Verkoop samenvattingen',
                    href: '/admin/sales-summaries',
                    icon: ReceiptJapaneseYen,
                },
            ],
        },);
    }
    return items;
});

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
