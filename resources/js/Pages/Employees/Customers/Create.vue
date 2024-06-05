<script setup>
import { useForm } from '@inertiajs/vue3';

import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';

defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    email: '',
    username: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('employees.customers.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>  
    <EmployeeLayout title="Customers" page-header="Customers" page-sub-header="Manage customers from here.">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 md:col-span-8">
                <form @submit.prevent="submit" class="pt-4" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
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
                            <Label>Email Address</Label>
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

                    <div class="flex items-center justify-start mt-6">
                        <Button :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                            Create Customer
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </EmployeeLayout>
</template>