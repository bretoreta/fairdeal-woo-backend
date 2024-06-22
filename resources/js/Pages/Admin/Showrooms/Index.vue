<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';

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
    showrooms: Object,
});

dayjs.extend(relativeTime);

const showSlideOver = ref(false);
const isDeletingShowroom = ref(false);
const deletingShowroomId = ref(null);
const showDeleteModal = ref(false);

const form = useForm({
    id: '',
    name: '',
    location: '',
    phone: '',
    google_review_link: '',
});

const editShowroom = (showroom) => {
    form.id = showroom.id
    form.name = showroom.name
    form.location = showroom.location
    form.phone = showroom.phone
    form.google_review_link = showroom.google_review_link

    showSlideOver.value = true;
}

const confirmDeleteShowroom = (id) => {
    deletingShowroomId.value = id;
    showDeleteModal.value = true;
}

const activateShowroom = (id) => {
    router.post(route('admin.showrooms.activate', id), { }, {
        preserveScroll: true,
    })
}

const deactivateShowroom = (id) => {
    router.post(route('admin.showrooms.deactivate', id), { }, {
        preserveScroll: true,
    })
}

const deleteShowroom = () => {
    router.delete(route('admin.showrooms.delete', deletingShowroomId.value), {
        preserveScroll: true,
        onStart: visit => {
            isDeletingShowroom.value = true;
        },
        onFinish: visit => {
            isDeletingShowroom.value = false;
        },
        onSuccess: () => {
            showDeleteModal.value = false
        }
    });
}

const submit = () => {
    form.put(route('admin.showrooms.update', form.id), {
        onSuccess: () => {
            showSlideOver.value = false;
        }
    });
}

</script>
<template>
    <AdminLayout title="Showrooms">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="flex flex-wrap items-center col-span-12 mt-2 sm:flex-nowrap">
                <Button @click="router.visit(route('admin.showrooms.create'))">
                    Create Showroom 
                </Button>
                <div class="hidden mx-auto md:block text-gray-500"> Showing {{ showrooms.from ?? 0 }} to {{ showrooms.to ?? 0 }} of {{ showrooms.total ?? 0 }} showrooms</div>
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
                <table class="w-full border-spacing-y-[10px] border-separate" v-if="showrooms.data.length">
                    <thead>
                        <tr class="font-semibold text-sm bg-white dark:bg-muted/50">
                            <td class="p-4">Name</td>
                            <td class="p-4">Location</td>
                            <td class="p-4">WhatsApp No.</td>
                            <td class="p-4">Employees</td>
                            <td class="p-4">Status</td>
                            <td class="p-4">Created</td>
                            <td class="p-4 text-center"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="showroom in showrooms.data" :key="showroom.id">
                            <tr class="bg-white dark:bg-black dark:text-gray-300">
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <p>{{ showroom.name }}</p>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <span class="text-sm  whitespace-nowrap">{{ showroom.location }}</span>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <span class="text-sm  whitespace-nowrap">{{ showroom.phone }}</span>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <p class="">{{ showroom.users_count }}</p>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <div v-if="showroom.active_promo" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-green-100 dark:bg-green-600 text-green-600 dark:text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Active</span>
                                    </div>
                                    <div v-else class="p-2 inline-flex gap-x-1 items-center rounded-md bg-gray-100 dark:bg-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-semibold pr-1">Inactive</span>
                                    </div>
                                </td>
                                <td class="p-4 first:rounded-l-md last:rounded-r-md border-b-0">
                                    <span class="text-sm ">{{ dayjs(showroom.created_at).fromNow() }}</span>
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
                                            <DropdownMenuLabel>Manage {{ showroom.name }}</DropdownMenuLabel>
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem v-if="showroom.active_promo">
                                                <button @click="deactivateShowroom(showroom.id)" class="w-full text-left">
                                                    Deactivate 
                                                </button>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem v-else>
                                                <button @click="activateShowroom(showroom.id)" class="flex items-center mr-3 text-primary w-full text-left">
                                                    Activate 
                                                </button>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem>
                                                <button @click="editShowroom(showroom)">
                                                    Edit 
                                                </button>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem>
                                                <button @click="confirmDeleteShowroom(showroom.id)" class="text-red-500 w-full text-left">
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
                <Pagination v-if="showrooms.data.length" :data="showrooms" />
                <div v-else class="w-full bg-white dark:bg-muted/40 rounded-md">
                    <EmptyState title="No Showrooms Added" subtitle="Your application has no showrooms yet">
                        <template #action>
                            <Button @click="router.visit(route('admin.showrooms.create'))">Create Showroom</Button>
                        </template>
                    </EmptyState>
                </div>
            </div>
        </div>
        <SlideOver :show="showSlideOver" @close="showSlideOver = false">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Edit {{ form.name }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Edit information related to this showroom</p>
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
                    
                    <div class="mt-4">
                        <Label>Google Reviews Link</Label>
                        <Input
                            id="google_review_link"
                            v-model="form.google_review_link"
                            type="text"
                            :rows="4"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.google_review_link" />
                    </div>
                </form>
            </template>
            <template #footer>
                <div class="flex items-center gap-x-3 justify-start mt-auto">
                    <Button @click="submit" :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                        Update Showroom
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
                Are you sure you want to delete this showroom? Deleting this showroom will also delete any data and information related to this showroom!
            </template>
            <template #footer>
                <div class="flex items-center gap-3">
                    <Button variant="destructive" @click="deleteShowroom" :class="{ 'opacity-75': isDeletingShowroom }" :disabled="isDeletingShowroom" :loading="isDeletingShowroom">
                        Delete Showroom
                    </Button>
                    <Button variant="outline" @click="showDeleteModal = false">Cancel</Button>
                </div>
            </template>
        </ConfirmationModal>
    </AdminLayout>
</template>