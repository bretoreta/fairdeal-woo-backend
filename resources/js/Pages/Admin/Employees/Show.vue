<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/customParseFormat';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Dropdown from '@/Components/Dropdown.vue';
import NavbarLink from '../Components/NavbarLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';

dayjs.extend(relativeTime);

const isDeletingEmployee = ref(false);
const showDeleteModal = ref(false);
const deletingEmployeeUsername = ref(null);

const confirmDeleteEmployee = (username) => {
    deletingEmployeeUsername.value = username;
    showDeleteModal.value = true;
}

const deleteEmployee = () => {
    router.delete(route('admin.customers.delete', deletingEmployeeUsername.value), {
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

defineProps({
    employee: Object,
})
</script>

<template>
    <AdminLayout title="Show Employee">
        <div class="px-4 md:px-[22px] max-w-full md:max-w-auto flex-1 min-w-0 min-h-screen pb-10 bg-gray-100">
            <div class="flex items-baseline justify-between pb-4">
                <h2 class="mt-10 text-2xl text-gray-800 font-semibold" data-aos="fade-up">Vewing Employee | {{ employee.name }}</h2>
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
                            <NavbarLink showAs="button" v-if="!employee.email_verified_at" :link="route('admin.employees.verify', employee.username)" label="Verify">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="employee.email_verified_at" :link="route('admin.employees.unverify', employee.username)" label="Unverify">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="employee.status != 'active' && employee.status != 'closed'" :link="route('admin.employees.activate', employee.username)" label="Activate">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="employee.status != 'pending' && employee.status != 'closed'" :link="route('admin.employees.deactivate', employee.username)" label="Deactivate">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="employee.status != 'closed'" :link="route('admin.employees.block', employee.username)" label="Block">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <NavbarLink showAs="button" v-if="employee.status == 'closed'" :link="route('admin.employees.unblock', employee.username)" label="Unblock">
                                <template #icon>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </template>
                            </NavbarLink>
                            <div class="border-t" />
                            <button @click="confirmDeleteEmployee(employee.username)" class="flex items-center gap-2 py-2 px-4 rounded-md duration-200 w-full text-red-500 hover:bg-red-50">
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
                            <h4 class="font-semibold text-gray-800">Employee Details</h4>
                            <p class="text-sm text-gray-500">Information related to this employee</p>
                        </div>
                        <div class="mt-4 flex gap-4">
                            <div class="rounded-md border p-5 w-64 relative">
                                <span v-if="employee.email_verified_at" class="px-4 py-2 rounded-bl-md rounded-tr-md text-xs font-semibold absolute top-0 right-0 bg-green-500 text-white">Verified</span>
                                <span v-if="!employee.email_verified_at" class="px-4 py-2 rounded-bl-md rounded-tr-md text-xs font-semibold absolute top-0 right-0 bg-gray-100 text-gray-800">Unverified</span>
                                <div class="flex flex-col">
                                    <img :src="employee.profile_photo_url" alt="" class="w-20 h-20 rounded-full bg-cover">
                                    <div class="mt-4 pb-4 border-b">
                                        <h5 class="text-gray-800 font-semibold">{{ employee.name }}</h5>
                                        <p class="text-sm text-gray-500">{{ employee.email }}</p>
                                    </div>
                                    <div class="pt-4 flex flex-col gap-4">
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Employee's Station">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 007.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 004.902-5.652l-1.3-1.299a1.875 1.875 0 00-1.325-.549H5.223z" />
                                                <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 009.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 002.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 010 1.5H2.25a.75.75 0 010-1.5H3zm3-6a.75.75 0 01.75-.75h3a.75.75 0 01.75.75v3a.75.75 0 01-.75.75h-3a.75.75 0 01-.75-.75v-3zm8.25-.75a.75.75 0 00-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-5.25a.75.75 0 00-.75-.75h-3z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm capitalize">{{ employee.showroom.name }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Employee Status">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm capitalize">{{ employee.status }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Employee's Phone Number">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">{{ employee.phone }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Employee's Username">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">@{{ employee.username }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 hover:cursor-pointer" title="Employee's Join Date">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-600 flex-shrink-0">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-gray-500 text-sm">Member since {{ dayjs(employee.created_at).format('MMM D, YYYY') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="flex-1 rounded-md border p-5">
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
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmationModal :show="showDeleteModal" @close="showDeleteModal = false">
                <template #title>
                    Confirm Action
                </template>
                <template #content>
                    Are you sure you want to delete this employee? Deleting this employee will also delete any related data and information to this customer!
                </template>
                <template #footer>
                    <div class="flex items-center gap-3">
                        <DangerButton @click="deleteEmployee" :class="{ 'opacity-75': isDeletingEmployee }" :disabled="isDeletingEmployee" :loading="isDeletingEmployee">
                            Delete Employee
                        </DangerButton>
                        <SecondaryButton @click="showDeleteModal = false">Cancel</SecondaryButton>
                    </div>
                </template>
            </ConfirmationModal>
        </div>
    </AdminLayout>
</template>