<script setup>
import QuickStatsItem from './QuickStatsItem.vue';

defineProps({
    dashboardData: Object
});
</script>
<template>
    <div class="grid grid-cols-12 gap-4 w-full mt-10 overflow-hidden">
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <QuickStatsItem :number="dashboardData.redeemedCodes.thisWeek" text="Codes" :percentage="(dashboardData.redeemedCodes.thisWeek - dashboardData.redeemedCodes.lastWeek ) * 100" more-label="redeemed this week" :positive="(dashboardData.redeemedCodes.thisWeek - dashboardData.redeemedCodes.lastWeek ) > 0" data-aos="fade-left" data-aos-once="true">
                <template #icon>
                    <div class="bg-gray-50 dark:bg-muted/40 border text-gray-500 dark:text-gray-300 p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                        </svg>
                    </div>
                </template>
            </QuickStatsItem>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <QuickStatsItem :number="dashboardData.newCodes.thisWeek" text="New Codes" :percentage="(dashboardData.newCodes.thisWeek - dashboardData.newCodes.lastWeek ) * 100" more-label="created this week" :positive="(dashboardData.newCodes.thisWeek - dashboardData.newCodes.lastWeek ) > 0" data-aos="fade-left" data-aos-delay="100" data-aos-once="true">
                <template #icon>
                    <div class="bg-gray-50 dark:bg-muted/40 border text-gray-500 dark:text-gray-300 p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </template>
            </QuickStatsItem>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <QuickStatsItem :number="dashboardData.newCustomers.thisWeek" text="Customers" :percentage="(dashboardData.newCustomers.thisWeek - dashboardData.newCustomers.lastWeek ) * 100" more-label="added this week" :positive="(dashboardData.newCustomers.thisWeek - dashboardData.newCustomers.lastWeek ) > 0" data-aos="fade-left" data-aos-delay="200" data-aos-once="true">
                <template #icon>
                    <div class="bg-gray-50 dark:bg-muted/40 border text-gray-500 dark:text-gray-300 p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                </template>
            </QuickStatsItem>
        </div>
        <div class="col-span-12 md:col-span-6 lg:col-span-3">
            <QuickStatsItem :number="dashboardData.newCustomers.thisWeek" text="Customers" :percentage="(dashboardData.newCustomers.thisWeek - dashboardData.newCustomers.lastWeek ) * 100" more-label="added this week" :positive="(dashboardData.newCustomers.thisWeek - dashboardData.newCustomers.lastWeek ) > 0" data-aos="fade-left" data-aos-delay="200" data-aos-once="true">
                <template #icon>
                    <div class="bg-gray-50 dark:bg-muted/40 border text-gray-500 dark:text-gray-300 p-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                </template>
            </QuickStatsItem>
        </div>
    </div>
</template>