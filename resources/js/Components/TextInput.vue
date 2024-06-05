<script setup>
    import { onMounted, ref } from 'vue';

    defineProps({
        modelValue: String,
        placeholder: {
            type: String,
            default: null
        }
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
    <input
        ref="input"
        class="border-gray-300 focus:border-primary focus:ring-primary rounded shadow-sm"
        :value="modelValue"
        :placeholder="placeholder"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
