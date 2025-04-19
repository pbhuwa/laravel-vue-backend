<template>
    <div class="px-4 py-6">
        <el-tabs v-model="activeTab" type="border-card">
            <el-tab-pane
            v-for="item in tabItems"
            :key="item.href"
            :label="item.title"
            :name="item.href"
            class="w-full justify-start"
            >
                <!-- 👇 Custom label with icon -->
                <template #label>
                    <span class="flex items-center gap-2">
                        <component :is="item.icon" class="w-4 h-4" />
                        {{ item.title }}
                    </span>
                </template>
                <!-- Tab Content -->
                <component :is="item.component" />
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue';

import { UserPen, KeyRound, Paintbrush } from 'lucide-vue-next';

import Profile from '@/components/settings/Profile.vue';
import Password from '@/components/settings/Password.vue';
import Appearance from '@/components/settings/Appearance.vue';

const tabItems = [
  {
    title: 'Profile',
    href: '/settings/profile',
    icon: UserPen,
    component: Profile,
  },
  {
    title: 'Password',
    href: '/settings/password',
    icon: KeyRound,
    component: Password,
  },
  {
    title: 'Appearance',
    href: '/settings/appearance',
    icon: Paintbrush,
    component: Appearance,
  },
];

// 👇 Set default active tab to the href of "Profile"
const activeTab = ref('/settings/profile');
</script>
