<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    subtitle: String,
    height: {
        type: String,
        default: '48'
    }
});

const heightClass = computed(() => {
    return {
        '48': 'min-h-48',
        '56': 'min-h-56',
    }[props.height.toString()];
});

</script>

<template>
    <div class="border-2 border-dashed w-full rounded-md" :class="heightClass">
        <div class="flex flex-col justify-center h-full px-10 py-6">
            <div class="my-2">
                <div class="bg-fuchsia-50 dark:bg-muted/40 dark:border p-3 rounded inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-fuchsia-500 dark:text-fuchsia-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <div class="my-2">
                <h4 class="font-semibold text-gray-800 dark:text-white">{{ title }}</h4>
                <p class="text-sm text-gray-500">{{ subtitle }}</p>
            </div>
            <div class="my-2">
                <slot name="action"></slot>
            </div>
        </div>
    </div>
</template>