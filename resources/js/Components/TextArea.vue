<script setup>
    import { onMounted, ref } from 'vue';

    defineProps({
        modelValue: String,
        rows: Number,
    });

    defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

    defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        ref="input"
        :rows="rows"
        class="border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>