<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/customParseFormat';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Dropdown from '@/Components/Dropdown.vue';
import NavbarLink from '../Components/NavbarLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    customer: Object,
});

dayjs.extend(relativeTime);

const isDeletingCustomer = ref(false);
const showDeleteModal = ref(false);
const deletingCustomerUsername = ref(null);

const confirmDeleteCustomer = (username) => {
    deletingCustomerUsername.value = username;
    showDeleteModal.value = true;
}

const deleteCustomer = () => {
    router.delete(route('admin.customers.delete', deletingCustomerUsername.value), {
        preserveScroll: true,
        onStart: visit => {
            isDeletingCustomer.value = true;
        },
        onFinish: visit => {
            isDeletingCustomer.value = false;
        },
        onSuccess: () => {
            showDeleteModal.value = false
        }
    });
}
</script>

<template>
    
    <AdminLayout>
        <Head title="Show Customer" />
        <div class="px-4 md:px-[22px] max-w-full md:max-w-auto flex-1 min-w-0 min-h-screen pb-10 bg-gray-100">
            <div class="flex items-baseline justify-between pb-4">
                <h2 class="mt-10 text-2xl text-gray-800 font-semibold" data-aos="fade-up">Vewing Customer | {{ customer.name }}</h2>
                <Dropdown :width="48">
                    <template #trigger>
                        <SecondaryButton data-aos="fade-up">
                            <span class="ml-2 text-sm font-semibold">Actions</span>
                            <svg viewBox="0 0 24 24" class="w-4 ml-1 flex-shrink-0 text-gray-400" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </SecondaryButton>
                    </template>
                    <template #content>
                        <div class="py-2 border-b">
                            <p class="text-xs text-gray-800 font-semibold px-2">Quick Actions</p>
                        </div>
                        <div class="flex flex-col">
                            <NavbarLink showAs="button" v-if="!customer.email_verified_at" :link="route('admin.customers.verify', customer.username)" label="Verify">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="customer.email_verified_at" :link="route('admin.customers.unverify', customer.username)" label="Unverify">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="customer.status != 'active' && customer.status != 'closed'" :link="route('admin.customers.activate', customer.username)" label="Activate">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="customer.status != 'pending' && customer.status != 'closed'" :link="route('admin.customers.deactivate', customer.username)" label="Deactivate">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="customer.status != 'closed'" :link="route('admin.customers.block', customer.username)" label="Block">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="customer.status == 'closed'" :link="route('admin.customers.unblock', customer.username)" label="Unblock">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <div class="border-t" />
                            <button @click="confirmDeleteCustomer(customer.username)" class="flex items-center gap-2 py-2 px-4 rounded-md duration-200 w-full text-red-500 hover:bg-red-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="text-sm">Delete</span>
                            </button>
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="grid grid-cols-12 gap-4 mt-5">
                <div class="col-span-12 md:col-span-6 lg:col-span-8">
                    <div class="bg-white rounded-md shadow border p-6 mb-4" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                        <div class="pb-4 border-b">
                            <h4 class="font-semibold text-gray-800">Customer Details</h4>
                            <p class="text-sm text-gray-500">Information related to this customer</p>
                        </div>
                        <div class="mt-4 flex gap-4">
                            <div class="rounded-md border p-5 w-64 relative">
                                <span v-if="customer.email_verified_at" class="px-4 py-2 rounded-bl-md rounded-tr-md text-xs font-semibold absolute top-0 right-0 bg-green-500 text-white">Verified</span>
                                <span v-if="!customer.email_verified_at" class="px-4 py-2 rounded-bl-md rounded-tr-md text-xs font-semibold absolute top-0 right-0 bg-gray-100 text-gray-800">Unverified</span>
                                <div class="flex flex-col">
                                    <img :src="customer.profile_photo_url" alt="" class="w-20 h-20 rounded-full bg-cover">
                                    <div class="mt-4 pb-4 border-b">
                                        <h5 class="text-gray-800 font-semibold">{{ customer.name }}</h5>
                                        <p class="text-sm text-gray-500">{{ customer.email }}</p>
                                    </div>
                                    <div class="py-4 border-b">
                                        <div class="flex items-center gap-2">
                                            <div class="px-4 py-2 bg-gray-50 border rounded-md w-full">
                                                <h5 class="text-gray-800 font-semibold">{{ customer.codes.length }}</h5>
                                                <p class="text-xs text-gray-500">Codes</p>
                                            </div>
                                            <div class="px-4 py-2 bg-gray-50 border rounded-md w-full">
                                                <h5 class="text-gray-800 font-semibold">{{ 0 }}</h5>
                                                <p class="text-xs text-gray-500">Redeems</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-4 flex flex-col gap-4">
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Customer Status">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm capitalize">{{ customer.status }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Customer's Phone Number">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">{{ customer.phone }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Customer's Username">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">@{{ customer.username }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Customer's Join Date">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">Member since {{ dayjs(customer.created_at).format('MMM D, YYYY') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 rounded-md border p-5">
                                <div class="pb-4 border-b">
                                    <h4 class="font-semibold text-gray-800">Promotional Codes</h4>
                                    <p class="text-sm text-gray-500">Promotional codes that have been given to this user</p>
                                </div>
                                <div class="mt-4">
                                    <EmptyState v-if="!customer.codes.length" title="No Code Isssued" subtitle="This user has not been issued any code yet">
                                        <template #action>
                                            <PrimaryButton>Issue Code</PrimaryButton>
                                        </template>
                                    </EmptyState>
                                    <template v-for="code in customer.codes" :key="code.id">
                                        <div class="my-2 border rounded-md px-4 py-2 bg-gray-50">
                                            <h4 class="text-gray-800 font-semibold">{{ code.token }}</h4>
                                            <span class="text-sm text-gray-500">{{ code.campaign }}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <div class="bg-white rounded-md shadow border p-6 mb-4" data-aos="fade-up" data-aos-once="true">
                        <div class="pb-4 border-b">
                            <h4 class="font-semibold text-gray-800">Recent Redeems</h4>
                            <p class="text-sm text-gray-500">Recent redemptions made under this account</p>
                        </div>
                        <div class="mt-4">
                            <div class="flex flex-col w-full">
                                <EmptyState v-if="!customer.codes.length" title="No Redemptions" subtitle="This user has not made any redemptions yet" />
                                <template v-else v-for="code in customer.codes" :key="code.id">
                                    <div v-if="code.redeemed_at && code.is_used" class="my-2 border rounded-md px-4 py-2 bg-gray-50">
                                        <h4 class="text-gray-800 font-semibold">{{ code.token }}</h4>
                                        <p class="text-sm text-gray-500">{{ code.campaign }}</p>
                                        <p class="text-xs text-gray-500">Redeemed {{ dayjs(code.redeemed_at).fromNow() }}</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal :show="showDeleteModal" @close="showDeleteModal = false">
                <template #title>
                    Confirm Action
                </template>
                <template #content>
                    Are you sure you want to delete this customer? Deleting this customer will also delete any related data and information to this customer!
                </template>
                <template #footer>
                    <div class="flex items-center gap-3">
                        <DangerButton @click="deleteCustomer" :class="{ 'opacity-75': isDeletingCustomer }" :disabled="isDeletingCustomer" :loading="isDeletingCustomer">
                            Delete Customer
                        </DangerButton>
                        <SecondaryButton @click="showDeleteModal = false">Cancel</SecondaryButton>
                    </div>
                </template>
            </ConfirmationModal>
        </div>
    </AdminLayout>
</template>