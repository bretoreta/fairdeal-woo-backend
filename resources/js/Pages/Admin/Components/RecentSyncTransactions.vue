<script setup>
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

defineProps({
    syncTransactions: Array,
});

dayjs.extend(relativeTime);
</script>

<template>
    <div class="divide-y">
        <div v-for="syncTransaction in syncTransactions.slice(0,4)" :key="syncTransaction.id" class="flex gap-x-3 p-4 my-1">
            <div class="flex items-center">
                <div v-if="syncTransaction.data.sync_type == 'pull'" class="bg-teal-100 dark:bg-muted/40 text-teal-500 dark:text-teal-400 dark:border p-3 rounded-full inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div v-if="syncTransaction.data.sync_type == 'push'" class="bg-lime-100 dark:bg-muted/40 text-lime-500 dark:text-lime-400 dark:border p-3 rounded-full inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 dark:text-white">{{ syncTransaction.data.message }}</h4>
                <p class="text-xs text-gray-500">{{ dayjs(syncTransaction.updated_at).fromNow() }}</p>
            </div>
        </div>
        <div v-if="syncTransactions.length > 4" class="flex gap-x-3 p-4 my-1">
            <div class="flex items-center justify-center h-12 w-12 bg-slate-100 dark:bg-muted/40 text-slate-500 dark:text-slate-400 dark:border py-3 px-3.5 rounded-full">
                <p class="font-bold text-xs">+{{ syncTransactions.length - 4 }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 dark:text-white">More Trasactions</h4>
                <p class="text-xs text-gray-500">Made this week</p>
            </div>
        </div>
    </div>
</template>