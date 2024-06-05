<script setup>
import PromoBanner from './PromoBanner.vue';
import CouponBanner from './CouponBanner.vue';
</script>
<template>
    <div class="grid grid-cols-12 mt-10 gap-4">
        <div class="col-span-6">
            <PromoBanner />
        </div>
        <div class="col-span-6">
            <CouponBanner />
        </div>
    </div>
</template>