<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />
        <SettingsLayout>
        </SettingsLayout>
    </AppLayout>
</template>
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];
</script>
