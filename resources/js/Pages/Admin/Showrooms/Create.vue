<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';

defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    location: '',
    phone: '',
});

const submit = () => {
    form.post(route('admin.showrooms.store'));
};
</script>

<template> 
    <AdminLayout title="Create Showroom">
        <div class="max-w-full">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-8">
                    <form @submit.prevent="submit" class="pt-4">
                        <div>
                            <Label>Name</Label>
                            <Input
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
                            <Label>Location</Label>
                            <Input
                                id="location"
                                v-model="form.location"
                                type="text"
                                :rows="4"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.location" />
                        </div>

                        <div class="mt-4">
                            <Label>WhatsApp Number</Label>
                            <Input
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                :rows="4"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <div class="flex items-center gap-4 justify-start mt-6">
                            <Button :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                                Save Showroom
                            </Button>
                            <Link :href="route('admin.showrooms.index')" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                Go Back
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>