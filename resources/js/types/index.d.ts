import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface NewsPost {
    id: number;
    title: string;
    content: string;
    created_at: string;
    updated_at: string;
}

export interface Category {
    id: number;
    name: string;
}

export interface Dish {
    id: number;
    name: string;
    price: number;
    menu_number: string;
    description: string;
    category: Category;
    created_at: string;
    updated_at: string;
}

export interface Table {
    id: number;
}

export interface TableGuest {
    id: number;
    birthdate: string;
    has_deluxe_menu: boolean;
}

export type BreadcrumbItemType = BreadcrumbItem;
