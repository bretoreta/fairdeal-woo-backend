<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    salespersons: Object,
    search: String,
});

dayjs.extend(relativeTime);

</script>
<template>
    <AdminLayout title="Leaderboard" page-header="Sales Persons Leaderboard" page-sub-header="View stats about clicks from sales people from here.">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 overflow-x-auto" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
                <table class="w-full border-spacing-y-[10px] border-separate" v-if="salespersons.data.length">
                    <thead>
                        <tr class="font-semibold text-sm">
                            <td class="p-4">Pos</td>
                            <td class="p-4">Sales Person</td>
                            <td class="p-4">Showroom</td>
                            <td class="p-4">Phone</td>
                            <td class="p-4">Clicks Count</td>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(salesperson, index) in salespersons.data" :key="salesperson.id">
                            <tr class="bg-white dark:bg-muted/40">
                                <td class="p-4 w-10 first:rounded-l-md last:rounded-r-md dark:bg-muted/40 border-b-0 border-r">
                                    <div class="bg-zinc-100 dark:bg-zinc-800 px-2 rounded-md">
                                        <p class="text-lg font-bold text-zinc-500 dark:text-white">{{ index + 1 }}</p>
                                    </div>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <div class="flex items-center gap-x-3">
                                        <img :src="salesperson.profile_photo_url" alt="Profile Photo" class="rounded-full object-cover" width="40" height="40">
                                        <Link :href="route('admin.salesperson.show', salesperson.username)" class="flex flex-col underline-effect hover:text-primary duration-200">
                                            <span class="font-medium whitespace-nowrap">{{ salesperson.name }}</span>
                                            <span class="text-sm text-gray-500">{{ salesperson.email }}</span>
                                        </Link>
                                    </div>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <p class="text-sm text-gray-500">{{ salesperson.showroom.name }}</p>
                                    <p class="text-sm text-gray-500">{{ salesperson.showroom.location }}</p>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <span class="text-sm text-gray-500">{{ salesperson.phone }}</span>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <p class="text-sm text-gray-500">{{ salesperson.clicks_count }}</p>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <Pagination v-if="salespersons.data.length" :data="salespersons" />
                <div v-else class="w-full bg-white dark:bg-muted/40 rounded-md">
                    <EmptyState title="No Data Available" subtitle="Your application has no data available yet." />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>