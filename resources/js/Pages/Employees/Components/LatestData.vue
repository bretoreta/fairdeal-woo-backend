<script setup>
import dayjs from 'dayjs';

import EmptyState from '@/Components/EmptyState.vue';

defineProps({
    latestData: Array
});
</script>
<template>
    <div class="px-4 md:px-[22px] max-w-full md:max-w-auto rounded-md flex-1 min-w-0 pb-10 mt-10" data-aos="fade-up" data-aos-once="true">
        <h2 class="mt-10 text-lg font-medium intro-y">Latest Redemptions</h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 overflow-auto 2xl:overflow-visible">
                <table class="w-full text-left border-spacing-y-[10px] border-separate -mt-2">
                    <thead class="">
                        <tr class="text-sm">
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 border-b-0 whitespace-nowrap"> 
                                CODE
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 border-b-0 whitespace-nowrap"> 
                                CUSTOMER DETAILS 
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 text-center border-b-0 whitespace-nowrap">
                                CAMPAIGN 
                            </th>
                            <th class="font-medium px-5 py-3 dark:border-darkmode-300 text-center border-b-0 whitespace-nowrap">
                                REDEEMED AT 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in latestData">
                            <td class="px-5 dark:border-darkmode-300 first:rounded-l-md last:rounded-r-md w-40 py-4 bg-white border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                <a href="" class="underline decoration-dotted whitespace-nowrap">{{ item.token }}</a>
                            </td>
                            <td class="px-5 py-3 dark:border-darkmode-300 first:rounded-l-md last:rounded-r-md bg-white border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                <a href="" class="font-medium whitespace-nowrap text-sm">{{ item.owner.name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ item.owner.email }}</div>
                            </td>
                            <td class="px-5 py-3 dark:border-darkmode-300 first:rounded-l-md last:rounded-r-md text-center bg-white border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                <p class="text-sm text-gray-500">{{ item.campaign }}</p>
                            </td>
                            <td class="px-5 dark:border-darkmode-300 first:rounded-l-md last:rounded-r-md bg-white border-b-0 shadow-[20px_3px_20px_#0000000b] py-0 relative before:block before:w-px before:h-8 before:bg-slate-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400">
                                <p class="text-center">{{ dayjs(item.redeemed_at).format('ddd, M YYYY') }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="bg-white dark:bg-muted/40">
                    <EmptyState v-if="!latestData.length" title="No Data Yet" subtitle="We'll show data for redemtions done here" />
                </div>
            </div>
        </div>
    </div>
</template>