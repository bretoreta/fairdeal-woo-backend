<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import QuickStats from '@/Pages/Admin/Components/QuickStats.vue';
import SyncManager from '@/Pages/Admin/Components/SyncManager.vue';
import NotificationsManager from '@/Pages/Admin/Components/NotificationsManager.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs';

defineProps({
    activeSync: Boolean,
    syncable: Boolean,
    notifications: Array,
    syncTransactions: Array,
    statsData: Array,
});

</script>
<template>
    <AdminLayout title="Admin Dashboard">
        <Tabs default-value="overview" class="space-y-4">
            <TabsList>
                <TabsTrigger value="overview">
                    Overview
                </TabsTrigger>
                <TabsTrigger value="sync">
                    Sync
                </TabsTrigger>
                <TabsTrigger value="notifications">
                    Notifications
                </TabsTrigger>
            </TabsList>
            <TabsContent value="overview" class="space-y-4">
                <QuickStats :syncTransactions="syncTransactions" :statsData="statsData" />
            </TabsContent>
            <TabsContent value="sync" class="space-y-4">
                <SyncManager :activeSync="activeSync" :syncable="syncable" />
            </TabsContent>
            <TabsContent value="notifications" class="space-y-4">
                <NotificationsManager :notifications="notifications" />
            </TabsContent>
        </Tabs>
    </AdminLayout>
</template>