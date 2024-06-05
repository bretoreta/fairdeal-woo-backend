<script setup>
import { ref } from 'vue';

const select = ref(null);

defineProps({
    options: Array,
})

defineEmits(['update:modelValue']);

defineExpose({ focus: () => select.value.focus() });

</script>

<template>
    <select 
        ref="select" 
        @input="$emit('update:modelValue', $event.target.value)"
        class="py-3 px-4 block w-full border-gray-300 rounded shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
        <template v-for="item in options">
            <option :value="item" class="capitalize">{{ item }}</option>
        </template>
    </select>
</template>