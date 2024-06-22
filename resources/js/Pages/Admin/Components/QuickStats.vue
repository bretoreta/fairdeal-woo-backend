<script setup>
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import RecentSyncTransactions from './RecentSyncTransactions.vue';
import EmptyState from '@/Components/EmptyState.vue';

defineProps({
    syncTransactions: Array,
    statsData: Array,
});
</script>
<template>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">
                    Total Products
                </CardTitle>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5 4a3 3 0 0 1 6 0v1h.643a1.5 1.5 0 0 1 1.492 1.35l.7 7A1.5 1.5 0 0 1 12.342 15H3.657a1.5 1.5 0 0 1-1.492-1.65l.7-7A1.5 1.5 0 0 1 4.357 5H5V4Zm4.5 0v1h-3V4a1.5 1.5 0 0 1 3 0Zm-3 3.75a.75.75 0 0 0-1.5 0v1a3 3 0 1 0 6 0v-1a.75.75 0 0 0-1.5 0v1a1.5 1.5 0 1 1-3 0v-1Z" clip-rule="evenodd" />
                </svg>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">
                    {{ statsData.totalProducts }}
                </div>
                <!-- <p class="text-xs text-muted-foreground">
                    +20.1% from last month
                </p> -->
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">
                    Waiting Sync
                </CardTitle>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M4.5 9.75a6 6 0 0 1 11.573-2.226 3.75 3.75 0 0 1 4.133 4.303A4.5 4.5 0 0 1 18 20.25H6.75a5.25 5.25 0 0 1-2.23-10.004 6.072 6.072 0 0 1-.02-.496Z" clip-rule="evenodd" />
                </svg>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">
                    {{ statsData.waitingSyncProducts }}
                </div>
                <!-- <p class="text-xs text-muted-foreground">
                    +180.1% from last month
                </p> -->
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">
                    Synced Products
                </CardTitle>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M10.5 3.75a6 6 0 0 0-5.98 6.496A5.25 5.25 0 0 0 6.75 20.25H18a4.5 4.5 0 0 0 2.206-8.423 3.75 3.75 0 0 0-4.133-4.303A6.001 6.001 0 0 0 10.5 3.75Zm2.03 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v4.94a.75.75 0 0 0 1.5 0v-4.94l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                </svg>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">
                    {{ statsData.syncedProducts }}
                </div>
                <!-- <p class="text-xs text-muted-foreground">
                    +19% from last month
                </p> -->
            </CardContent>
        </Card>
        <Card>
            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                <CardTitle class="text-sm font-medium">
                    Synced Products
                </CardTitle>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z" clip-rule="evenodd" />
                </svg>
            </CardHeader>
            <CardContent>
                <div class="text-2xl font-bold">
                    {{ statsData.syncedProducts }}
                </div>
                <!-- <p class="text-xs text-muted-foreground">
                    +201 since last hour
                </p> -->
            </CardContent>
        </Card>
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
        <Card class="col-span-4">
            <CardHeader>
                <CardTitle>Overview</CardTitle>
                <CardDescription>
                    An overview of a total of <b>{{ syncTransactions.length }}</b> syncs made this week.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <EmptyState title="Charts Coming Soon" subtitle="We will show charts here. This feature is still in development." />
            </CardContent>
        </Card>
        <Card class="col-span-4 md:col-span-3">
            <CardHeader>
                <CardTitle>Recent Sync Transactions</CardTitle>
                <CardDescription>
                    Showing a total of <b>{{ syncTransactions.length }}</b> syncs made this week.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <RecentSyncTransactions :syncTransactions="syncTransactions" />
            </CardContent>
        </Card>
    </div>
</template>