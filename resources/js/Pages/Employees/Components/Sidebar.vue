<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import SidebarItem from './SidebarItem.vue';

import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const showSupportModal = ref(false);
const showBugReportModal = ref(false);

const form = useForm({
    email: '',
    subject: '',
    message: '',
});

const form2 = useForm({
    email: '',
    subject: '',
    message: '',
});

const sendSupportEmail = () => {
    form.post(route('support.send'), {
        onSuccess: () => {
            showSupportModal.value = false;
        }
    });
}

const sendBugReport = () => {
    form2.post(route('bugs.send'), {
        onSuccess: () => {
            showBugReportModal.value = false;
        }
    });
}
</script>
<template>
    <div class="w-20 bg-green-900 p-4 h-screen fixed left-0 top-0 m-0 flex flex-col text-white shadow-xl pt-8 pb-2 z-30">
        <div class="flex flex-col overflow-y-auto flex-1 sidebar mt-6">
            <SidebarItem tooltip="Dashboard" :active="route().current('employee.dashboard') && true" :link="route('employee.dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
            </SidebarItem>

            <SidebarItem tooltip="Customers" :active="route().current('employees.customers.*') && true" :link="route('employees.customers.index')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </SidebarItem>
        </div>
        <div class="flex flex-col border-t border-green-700">
            <button @click="showSupportModal = true" class="relative group flex items-center justify-center h-10 w-10 my-2 p-1 mx-auto duration-300 text-white hover:text-white hover:bg-green-700 rounded-xl transition-all ease-linear cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
                <span class="fixed w-auto p-2 m-2 min-w-max left-16 rounded-md shadow-md text-gray-800 bg-white text-sm font-semibold duration-100 scale-0 origin-left group-hover:scale-100 z-50">
                    Support
                </span>
            </button>

            <button @click="showBugReportModal = true" class="relative group flex items-center justify-center h-10 w-10 my-2 p-1 mx-auto duration-300 text-white hover:text-white hover:bg-green-700 rounded-xl transition-all ease-linear cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="fixed w-auto p-2 m-2 min-w-max left-16 rounded-md shadow-md text-gray-800 bg-white text-sm font-semibold duration-100 scale-0 origin-left group-hover:scale-100 z-50">
                    Report Bug
                </span>
            </button>
        </div>
        <Modal :show="showSupportModal" @close="showSupportModal = false">
            <div class="p-5">
                <form @submit.prevent="sendSupportEmail">
                    <div class="border-b pb-3">
                        <h4 class="text-gray-800 font-semibold">Submit Support Request</h4>
                        <p class="text-sm text-gray-500">Send a request to our support team and we'll reply promptly</p>
                    </div>
                    <div class="pt-5">
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
    
                        <div class="mt-4">
                            <InputLabel for="subject" value="Subject" />
                            <TextInput
                                id="subject"
                                v-model="form.subject"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="mt-2" :message="form.errors.subject" />
                        </div>
    
                        <div class="mt-4">
                            <InputLabel for="message" value="Message" />
                            <TextArea
                                id="message"
                                v-model="form.message"
                                type="message"
                                :rows="4"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.message" />
                        </div>
    
                        <div class="flex items-center justify-start mt-6">
                            <PrimaryButton :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                                Send Request
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>
        <Modal :show="showBugReportModal" @close="showBugReportModal = false">
            <div class="p-5">
                <form @submit.prevent="sendBugReport">
                    <div class="border-b pb-3">
                        <h4 class="text-gray-800 font-semibold">Submit Bug Report</h4>
                        <p class="text-sm text-gray-500">Send a request to our development team and we'll address the bug promptly</p>
                    </div>
                    <div class="pt-5">
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                v-model="form2.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form2.errors.email" />
                        </div>
    
                        <div class="mt-4">
                            <InputLabel for="subject" value="Subject" />
                            <TextInput
                                id="subject"
                                v-model="form2.subject"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="off"
                            />
                            <InputError class="mt-2" :message="form2.errors.subject" />
                        </div>
    
                        <div class="mt-4">
                            <InputLabel for="message" value="Message" />
                            <TextArea
                                id="message"
                                v-model="form2.message"
                                type="message"
                                :rows="4"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form2.errors.message" />
                        </div>
    
                        <div class="flex items-center justify-start mt-6">
                            <PrimaryButton :class="{ 'opacity-75': form2.processing }" :disabled="form2.processing" :loading="form2.processing">
                                Send Request
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>