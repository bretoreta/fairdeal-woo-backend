<script setup>
import { Head } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    text: String,
});

const copyToClipboard = async () => {
    try {
      await navigator.clipboard.writeText(props.text);
      alert("Text copied to clipboard.");
    } catch (err) {
      console.error('Failed to copy: ', err);
    }
}
</script>
<template>
    <AdminLayout>
        <Head title="Reviews Result" />
        <div class="px-4 md:px-[22px] max-w-full md:max-w-auto flex-1 min-w-0 min-h-screen pb-10 bg-gray-100">
            <h2 class="mt-10 text-lg font-semibold" data-aos="fade-up" data-aos-once="true">🤖 AI Reviews Result</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="flex flex-wrap items-center col-span-8 mt-2 sm:flex-nowrap" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                    <form @submit.prevent="submit" class="w-full">
                        <div>
                            <InputLabel for="text" value="Review Text" />
                            <TextArea
                                id="text"
                                :value="text"
                                type="text"
                                :rows="5"
                                class="mt-1 block w-full"
                            />
                        </div>
                        
                        <div class="mt-4">
                            <PrimaryButton @click="copyToClipboard">
                                Copy To Clipboard 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>