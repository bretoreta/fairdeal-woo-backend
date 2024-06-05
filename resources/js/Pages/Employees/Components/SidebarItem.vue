<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    tooltip: String,
    link: String,
    active: Boolean,
})
</script>

<template>
    <div>
        <Link :href="link" class="sidebar-icon group" :class="props.active && 'bg-green-800'">    
            <slot></slot>
            <span class="sidebar-tooltip group-hover:scale-100 z-50">
                {{ tooltip }}
            </span>
        </Link>
    </div>
</template>
<style>
    .sidebar-icon {
        @apply relative flex items-center justify-center 
                h-10 w-10 my-2 p-1 mx-auto duration-300
                text-white hover:text-white
                hover:bg-green-700
                rounded-xl transition-all
                ease-linear cursor-pointer;
    }

    .sidebar-tooltip {
        @apply fixed w-auto p-2 m-2 min-w-max left-16
                rounded-md shadow-md text-gray-800 bg-white
                text-sm font-semibold duration-100 scale-0 origin-left;
    }
</style>