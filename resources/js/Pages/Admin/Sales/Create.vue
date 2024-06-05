<script setup>
import { useForm, Link } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';

defineProps({
    showrooms: Array,
});

const form = useForm({
    name: '',
    email: '',
    selectedShowroom: '',
    phone: '',
    image_uuid: null,
});

const setImageUuid = (uuid) => {
    form.image_uuid = JSON.parse(uuid);
}

const setImageUuidToNull = () => {
    form.image_uuid = null;
}

const submit = () => {
    form.post(route('admin.salesperson.store'));
};
</script>

<template>
    <AdminLayout title="Create Sales Person" page-header="Create Sales Person" page-sub-header="Create a sales person from here.">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 md:col-span-8">
                <form @submit.prevent="submit" class="pt-4" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                    <div>
                        <ImageUpload @done="(uuid) => setImageUuid(uuid)" @revert="setImageUuidToNull" />
                    </div>
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

                    <div class="mt-4 flex items-center space-x-4">
                        <div class="w-full">
                            <Label>Email</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autocomplete="email"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="w-full">
                            <Label>Showroom</Label>
                            <Select v-model="form.selectedShowroom">
                                <SelectTrigger class="mt-1">
                                    <SelectValue placeholder="Select a showroom" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="item in showrooms" :key="item.id" :value="item">
                                            {{ item.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError class="mt-2" :message="form.errors.username" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <Label>Phone Number</Label>
                        <Input
                            id="phone"
                            v-model="form.phone"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div class="flex items-center gap-4 justify-start mt-6">
                        <Button :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                            Create Sales Person
                        </Button>
                        <Link :href="route('admin.salesperson.index')" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2" variant="outline">
                            Go Back
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>