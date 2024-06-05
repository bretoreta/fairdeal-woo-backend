<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';

defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    campaign: '',
});

const submit = () => {
    form.post(route('admin.codes.store'));
};
</script>

<template>
    
    <AdminLayout>
        <Head title="Create Category" />
        <div class="px-4 md:px-[22px] max-w-full md:max-w-auto flex-1 min-w-0 min-h-screen pb-10 bg-gray-100">
            <h2 class="mt-10 text-lg font-semibold" data-aos="fade-up" data-aos-once="true">Generate New Code</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 md:col-span-8">
                    <form @submit.prevent="submit" class="pt-4" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="campaign" value="Campaign" />
                            <TextArea
                                id="campaign"
                                v-model="form.campaign"
                                type="text"
                                :rows="4"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.campaign" />
                        </div>

                        <div class="flex items-center justify-start mt-6">
                            <PrimaryButton :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                                Generate Code
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                <div class="col-span-4">
                    
                </div>
            </div>
        </div>
    </AdminLayout>
</template>