<script setup>
defineProps({
    number: Number,
    text: String,
    percentage: Number,
    positive: Boolean,
    moreLabel: String,
    numberIsCurrency: {
        type: Boolean,
        default: false,
    },
})
</script>
<template>
    <div class="relative">
        <div class="bg-white dark:bg-muted/40 rounded-md border p-5">
            <div class="flex items-center gap-2">
                <slot name="icon"></slot>
                <div class="mt-1 font-semibold text-gray-800 dark:text-white">{{ text }}</div>
                <div class="ml-auto flex">
                    <div class="cursor-pointer py-[3px] flex rounded-full text-xs p-2 items-center font-medium w-fit h-fit" :class="positive ? ' bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
                        <svg v-if="positive" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-1.5 w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-1.5 w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
                        </svg>
                        {{ percentage }}% 
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div v-if="numberIsCurrency" class="text-3xl font-semibold text-gray-900 dark:text-gray-200 leading-8">
                    <sup class="font-medium text-sm">Ksh </sup>
                    {{ number.toLocaleString('en-Us') }}
                </div>
                <div v-else class="text-3xl font-semibold text-gray-900 dark:text-gray-200 leading-8">
                    {{ number }}
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ moreLabel }}</span>
            </div>
        </div>
    </div>
</template>