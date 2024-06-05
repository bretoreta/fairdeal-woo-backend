<script setup>
import { Head } from '@inertiajs/vue3';
// import CookieNotice from '@/Components/CookieNotice.vue';
import Banner from '../Components/Banner.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="relative min-h-screen bg-dots-darker bg-gray-100">
        <Head :title="title" />
            <slot></slot>
        <Banner v-if="$page.props.flash.message" />
    </div>
</template>