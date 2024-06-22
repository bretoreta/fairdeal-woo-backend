<script setup>
import { computed, watch, onMounted } from 'vue';
import { useColorMode } from '@vueuse/core'
import { usePage } from '@inertiajs/vue3';
import { Toaster, toast } from 'vue-sonner';

const bannerMsg = computed(() => usePage().props.flash?.message || '');
const theme = useColorMode();

onMounted(() => {
	const bannerMsg = computed(() => usePage().props.flash?.message || '');

	if(bannerMsg.value.type === 'info') {
		toast.info(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'success') {
		toast.success(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'error') {
		toast.error(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'warning') {
		toast.warning(bannerMsg.value.message);
	}
})

watch(bannerMsg, async () => {
	if(bannerMsg.value.type === 'info') {
		toast.info(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'success') {
		toast.success(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'error') {
		toast.error(bannerMsg.value.message);
	}
	else if(bannerMsg.value.type === 'warning') {
		toast.warning(bannerMsg.value.message);
	}
});
</script>

<template>
	<Toaster :theme="theme" />
</template>
