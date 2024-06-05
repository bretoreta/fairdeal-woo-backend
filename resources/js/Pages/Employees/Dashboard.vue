<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import QuickStats from './Components/QuickStats.vue';
import LatestData from './Components/LatestData.vue';

defineProps({
    dashboardData: Object,
    latestData: Array,
});

</script>
<template>
    <EmployeeLayout title="Employee Dashboard" :page-header="'Welcome ' + $page.props.auth.user.name + '✨'" page-sub-header="Here's what's going on today.">
        <QuickStats :dashboard-data="dashboardData" />
        <!-- <FinancialReport /> -->
        <!-- <AdvertisementBanners /> -->
        <LatestData :latest-data="latestData" />
    </EmployeeLayout>
</template>