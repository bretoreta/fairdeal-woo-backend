<script setup>
defineProps({
    text: String,
    active: Boolean,
})
</script>
<template>
    <div class="border-b-2 p-3 transition-all duration-300 cursor-pointer" :class="active? 'border-green-500' : 'border-transparent hover:border-green-500'">
        <p class="text-sm" :class="active ? 'text-green-600' : 'text-gray-800'">{{ text }}</p>
    </div>
</template>