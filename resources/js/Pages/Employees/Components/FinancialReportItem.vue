<script setup>
defineProps({
    number: Number,
    text: String,
    percentage: Number,
    positive: Boolean,
    numberIsCurrency: {
        type: Boolean,
        default: false,
    },
})
</script>
<template>
    <div>
        <div class="text-xs text-slate-500 uppercase">{{ text }}</div>
        <div class="mt-1.5 flex items-center">
            <div class="font-semibold">{{ numberIsCurrency ? number.toLocaleString('en-Us', {style:"currency", currency:"KSH"}) : number }}</div>
            <div class="cursor-pointer py-[3px] flex rounded-full text-xs p-2 items-center font-medium w-fit h-fit ml-auto" :class="positive ? ' bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
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
</template>