<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { debounce } from 'lodash';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';
import { Button } from '@/Components/ui/button';
import SlideOver from '@/Components/SlideOver.vue';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu';

const props = defineProps({
    employees: Object,
    search: String,
});

dayjs.extend(relativeTime);

const showSlideOver = ref(false);
const isDeletingEmployee = ref(false);
const showDeleteModal = ref(false);
const deletingEmployeeUsername = ref(null);

const form = useForm({
    name: '',
    email: '',
    username: '',
    phone: '',
});

const editEmployee = (employee) => {
    form.name = employee.name
    form.email = employee.email
    form.username = employee.username
    form.phone = employee.phone

    showSlideOver.value = true;
}

const confirmDeleteEmployee = (username) => {
    deletingEmployeeUsername.value = username;
    showDeleteModal.value = true;
}

const searchEmployee = debounce(e => {
    if(e.target.value) {
        router.get(route('admin.employees.index'), {
            search: e.target.value
        }, {
            preserveState: true,
        })
    }
    else {
        router.visit(route('admin.employees.index'), {
            preserveState: true,
        });
    }
}, 800)

const deleteEmployee = () => {
    router.delete(route('admin.employees.delete', deletingEmployeeUsername.value), {
        preserveScroll: true,
        onStart: visit => {
            isDeletingEmployee.value = true;
        },
        onFinish: visit => {
            isDeletingEmployee.value = false;
        },
        onSuccess: () => {
            showDeleteModal.value = false
        }
    });
}

const submit = () => {
    form.put(route('admin.employees.update', form.username), {
        onSuccess: () => {
            showSlideOver.value = false;
        }
    });
}

</script>
<template>
    <AdminLayout title="Employees" page-header="Employees" page-sub-header="Manage employees from here.">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="flex flex-wrap items-center col-span-12 mt-2 sm:flex-nowrap" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                <Link :href="route('admin.employees.create')" class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 rounded-md px-4">
                    Add New Employee 
                </Link>
                <div class="hidden mx-auto md:block text-gray-500"> Showing {{ employees.from ?? 0 }} to {{ employees.to ?? 0 }} of {{ employees.total ?? 0 }} employees</div>
                <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="relative w-72 text-gray-500">
                        <input class="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mt-1 block w-72 pr-10"
                            type="text" placeholder="Search...">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="stroke-1.5 absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-span-12 overflow-x-auto">
                <table class="w-full border-spacing-y-[10px] border-separate" v-if="employees.data.length">
                    <thead>
                        <tr class="font-semibold text-sm">
                            <td class="p-4">Employee</td>
                            <td class="p-4">Phone</td>
                            <td class="p-4">Showroom</td>
                            <td class="p-4">Verification Status</td>
                            <td class="p-4">Status</td>
                            <td class="p-4">Member Since</td>
                            <td class="p-4 text-center">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="employee in employees.data" :key="employee.id">
                            <tr class="bg-white dark:bg-muted/40 dark:text-gray-300">
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                    <div class="flex items-center gap-x-3">
                                        <img :src="employee.profile_photo_url" alt="Profile Photo" class="rounded-full object-cover" width="40" height="40">
                                        <Link :href="route('admin.employee.show', employee.username)" class="flex flex-col underline-effect hover:text-primary duration-200">
                                            <span class="font-medium whitespace-nowrap">{{ employee.name }}</span>
                                            <span class="text-sm text-gray-500">{{ employee.email }}</span>
                                        </Link>
                                    </div>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                    <span class="text-sm text-gray-500">{{ employee.phone }}</span>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                    <p class="text-sm text-gray-500">{{ employee.showroom.name }}</p>
                                    <p class="text-sm text-gray-500">{{ employee.showroom.location }}</p>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                    <div v-if="employee.email_verified_at" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-green-100 dark:bg-primary dark:text-primary-foreground text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Verified</span>
                                    </div>
                                    <div v-else class="p-2 inline-flex gap-x-1 items-center rounded-md bg-gray-100 text-gray-600 dark:bg-muted/70 dark:text-muted-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Unverified</span>
                                    </div>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0 shadow-[20px_3px_20px_#0000000b]">
                                    <div v-if="employee.status == 'active'" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-green-100 text-green-600 dark:bg-primary dark:text-primary-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Active</span>
                                    </div>
                                    <div v-if="employee.status == 'pending'" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-gray-100 text-gray-600 dark:bg-muted/70 dark:text-muted-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Pending</span>
                                    </div>
                                    <div v-if="employee.status == 'review'" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-yellow-100 text-yellow-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Reviewing</span>
                                    </div>
                                    <div v-if="employee.status == 'closed'" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-red-100 text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Banned</span>
                                    </div>
                                </td>
                                <td class="p-4 bg-white dark:bg-muted/40 shadow-[20px_3px_20px_#0000000b]">
                                    <span class="text-sm text-gray-500">{{ dayjs(employee.created_at).fromNow() }}</span>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md w-20 border-b-0 py-0 relative">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger>
                                            <Button variant="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                </svg>
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuLabel>Manage {{ employee.name }}</DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem>
                                                <button @click="editEmployee(employee)" class="w-full text-left">
                                                    Edit 
                                                </button>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem>
                                                <button @click="confirmDeleteEmployee(employee.username)" class="text-red-500 w-full text-left">
                                                    Delete 
                                                </button>
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <Pagination v-if="employees.data.length" :data="employees" />
                <div v-else class="w-full bg-white dark:bg-muted/40 rounded-md">
                    <EmptyState title="No Employees Added" subtitle="Your application has no employees yet">
                        <template #action>
                            <Button @click="router.visit(route('admin.employees.create'))">Create Employee</Button>
                        </template>
                    </EmptyState>
                </div>
            </div>
        </div>
        <SlideOver :show="showSlideOver" @close="showSlideOver = false">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-semibold text-gray-800">Edit {{ form.name }}</h4>
                    <p class="text-sm text-gray-500">Edit information related to this employee</p>
                </div>
            </template>
            <template #content>
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
                                autocomplete="username"
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
            </template>
            <template #footer>
                <div class="flex items-center gap-x-3 justify-start mt-auto">
                    <Button @click="submit" :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                        Update Customer
                    </Button>
                    <Button variant="outline" @click="showSlideOver = false">Cancel</Button>
                </div>
            </template>
        </SlideOver>
        <ConfirmationModal :show="showDeleteModal" @close="showDeleteModal = false">
            <template #title>
                Confirm Action
            </template>
            <template #content>
                Are you sure you want to delete this customer? Deleting this customer will also delete any data and information related to this customer!
            </template>
            <template #footer>
                <div class="flex items-center gap-3">
                    <Button variant="destructive" @click="deleteEmployee" :class="{ 'opacity-75': isDeletingEmployee }" :disabled="isDeletingEmployee" :loading="isDeletingEmployee">
                        Delete Customer
                    </Button>
                    <Button variant="outline" @click="showDeleteModal = false">Cancel</Button>
                </div>
            </template>
        </ConfirmationModal>
    </AdminLayout>
</template>