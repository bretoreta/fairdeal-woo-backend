<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    subtitle: String,
    height: {
        type: String,
        default: '48'
    },
    type: {
        type: String,
        default: 'warning'
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
                <div class="bg-fuchsia-50 dark:bg-muted/40 text-fuchsia-500 dark:text-fuchsia-400 dark:border p-3 rounded inline-flex">
                    <svg v-if="props.type == 'warning'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>

                    <svg v-if="props.type == 'info'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
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