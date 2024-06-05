<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import QuickStats from '@/Pages/Admin/Components/QuickStats.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs';

defineProps({
    dashboardData: Object,
    latestData: Object,
});

</script>
<template>
    <AdminLayout title="Admin Dashboard" :page-header="'Welcome ' + $page.props.auth.user.name + '✨'" page-sub-header="Here's what's going on today.">
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
                <QuickStats />
            </TabsContent>
            <TabsContent value="sync" class="space-y-4">
                <QuickStats />
            </TabsContent>
        </Tabs>
    </AdminLayout>
</template>