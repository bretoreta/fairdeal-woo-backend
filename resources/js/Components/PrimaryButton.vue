<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    loading: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <button :type="type" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-primary border-2 border-transparent sm:w-auto rounded-md hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:bg-green-800">
        <slot />
        <span v-show="loading" class="ml-2 text-white">
            <svg class="w-4 h-4 motion-safe:animate-spin" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
            </svg>
        </span>
    </button>
</template>
