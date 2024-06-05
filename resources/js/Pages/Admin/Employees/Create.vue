<script setup>
import { useForm, Link } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select'

defineProps({
    showrooms: Array,
});

const form = useForm({
    name: '',
    email: '',
    selectedShowroom: '',
    phone: '',
});

const submit = () => {
    form.post(route('admin.employees.store'));
};
</script>

<template>
    <AdminLayout title="Create Employee" page-header="Create Employee" page-sub-header="Create an employee from here.">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 md:col-span-8">
                <form @submit.prevent="submit">
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
                            Save Employee
                        </Button>
                        <Link :href="route('admin.employees.index')" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2" variant="outline">
                            Go Back
                        </Link>
                    </div>
                </form>
            </div>
            <div class="col-span-4">
                <!-- <div data-aos="fade-up" data-aos-delay="200" data-aos-once="true" class="relative p-5 mt-10 border rounded-md bg-yellow-500/20 border-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-1.5 absolute top-0 right-0 w-12 h-12 mt-5 mr-3 text-yellow-600">
                        <line x1="9" y1="18" x2="15" y2="18"></line>
                        <line x1="10" y1="22" x2="14" y2="22"></line>
                        <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"></path>
                    </svg>
                    <h2 class="text-lg font-medium">Tips</h2>
                    <div class="mt-5 font-medium">Parent Category</div>
                    <div class="mt-2 text-xs leading-relaxed text-gray-600 dark:text-gray-500">
                        <div> 
                            This dedicated resource is designed to assist you, the admin, in creating well-informed and effective category items for our e-commerce website. 
                        </div>
                        <div class="mt-2"> 
                            Here, you will find valuable insights, guidelines, and best practices to curate category items that enhance the user experience. From organizing products to optimizing navigation, our tips section empowers you with the knowledge to create intuitive and user-friendly category structures. Utilize this resource to ensure your category items are well-defined, logically organized, and aligned with customer expectations, ultimately driving engagement and boosting conversions.
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </AdminLayout>
</template>