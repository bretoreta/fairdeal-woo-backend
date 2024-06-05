<script setup>
import { ref } from 'vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import axios from 'axios';
import relativeTime from 'dayjs/plugin/relativeTime';
import { debounce } from 'lodash';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SlideOver from '@/Components/SlideOver.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import Modal from '@/Components/Modal.vue';

const props = defineProps({
    codes: Object,
});

dayjs.extend(relativeTime);

const showSlideOver = ref(false);
const issuingCode = ref(false);
const issuingCodeToken = ref(null);
const isDeletingCode = ref(false);
const deletingCodeId = ref(null);
const showDeleteModal = ref(false);
const loadingResults = ref(false);
const query = ref(null);
const customers = ref([]);

const form = useForm({
    id: '',
    name: '',
    token: '',
    campaign: '',
    is_used: '',
    is_blocked: '',
});

const editCode = (code) => {
    form.id = code.id
    form.name = code.name
    form.token = code.token
    form.campaign = code.campaign
    form.is_used = code.is_used
    form.is_blocked = code.is_blocked

    showSlideOver.value = true;
}

const confirmDeleteCode = (id) => {
    deletingCodeId.value = id;
    showDeleteModal.value = true;
}

const searchCustomer = debounce(e => {
    loadingResults.value = true;

    axios.get(route('api.users.index', {
        search: e.target.value
    })).then((res) => {
        customers.value = res.data;
    })
    .catch((error) => {
        usePage().props.flash.message = {
            type: 'error',
            message: 'Something went wrong. Please Try again'
        };
    })
    .finally(() => {
        loadingResults.value = false
    });
}, 800)

const issueCodeToCustomer = (customer_id) => {
    router.post(route('admin.codes.issue', issuingCodeToken.value), { customer_id }, {
        preserveScroll: true,
        onSuccess: () => {
            issuingCodeToken.value = null;
            issuingCode.value = false;
        }
    })
}

const deleteCustomer = () => {
    router.delete(route('admin.codes.delete', deletingCodeId.value), {
        preserveScroll: true,
        onStart: visit => {
            isDeletingCode.value = true;
        },
        onFinish: visit => {
            isDeletingCode.value = false;
        },
        onSuccess: () => {
            showDeleteModal.value = false
        }
    });
}

const issueCode = (token) => {
    issuingCodeToken.value = token;
    issuingCode.value = true;
}

const submit = () => {
    form.put(route('admin.codes.update', form.id), {
        onSuccess: () => {
            showSlideOver.value = false;
        }
    });
}

</script>
<template>
    <AdminLayout>
        <Head title="Codes" />
        <div class="px-4 md:px-[22px] max-w-full md:max-w-auto flex-1 min-w-0 min-h-screen pb-10 bg-gray-100">
            <h2 class="mt-10 text-lg font-semibold" data-aos="fade-up" data-aos-once="true">Codes</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="flex flex-wrap items-center col-span-12 mt-2 sm:flex-nowrap" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                    <Link :href="route('admin.codes.create')" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-primary border-2 border-transparent sm:w-auto rounded-md hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:bg-green-800">
                        Add New Code 
                    </Link>
                    <div class="hidden mx-auto md:block text-gray-500"> Showing {{ codes.from ?? 0 }} to {{ codes.to ?? 0 }} of {{ codes.total ?? 0 }} codes</div>
                    <div class="w-full mt-3 sm:w-auto sm:mt-0 sm:ml-auto md:ml-0">
                        <div class="relative w-72 text-gray-500">
                            <input class="disabled:bg-gray-100 disabled:cursor-not-allowed transition duration-200 ease-in-out text-sm border-gray-200 shadow-sm rounded-md placeholder:text-gray-400/90 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:border-green-500 focus:border-opacity-40 w-72 pr-10 !box"
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
                <div class="col-span-12 overflow-x-auto" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
                    <table class="w-full border-spacing-y-[10px] border-separate" v-if="codes.data.length">
                        <thead>
                            <tr class="text-gray-800 font-semibold text-sm">
                                <td class="p-4">Code Name</td>
                                <td class="p-4">Token</td>
                                <td class="p-4">Campaign</td>
                                <td class="p-4">Status</td>
                                <td class="p-4">Created</td>
                                <td class="p-4 text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="code in codes.data" :key="code.id">
                                <tr>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md bg-white border-b-0">
                                        <p class="font-semibold">{{ code.name }}</p>
                                    </td>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md bg-white border-b-0">
                                        <span class="text-sm text-gray-500 whitespace-nowrap">{{ code.token }}</span>
                                    </td>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md bg-white border-b-0">
                                        <p class="text-gray-500">{{ code.campaign }}</p>
                                    </td>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md bg-white border-b-0">
                                        <div v-if="!code.is_used" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-green-100 text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                            <span class="text-xs font-semibold pr-1">Active</span>
                                        </div>
                                        <div v-if="code.is_used" class="p-2 inline-flex gap-x-1 items-center rounded-md bg-gray-100 text-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-xs font-semibold pr-1">Used</span>
                                        </div>
                                    </td>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md bg-white border-b-0">
                                        <span class="text-sm text-gray-500">{{ dayjs(code.created_at).fromNow() }}</span>
                                    </td>
                                    <td class="p-4 first:rounded-l-md last:rounded-r-md w-56 bg-white border-b-0 py-0 relative before:block before:w-px before:h-8 before:bg-gray-200 before:absolute before:left-0 before:inset-y-0 before:my-auto before:dark:bg-darkmode-400">
                                        <div class="flex items-center justify-center">
                                            <button @click="issueCode(code.token)" class="flex items-center mr-3 text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-1.5 w-4 h-4 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                </svg>
                                                Issue 
                                            </button>

                                            <button @click="editCode(code)" class="flex items-center mr-3 text-blue-500">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                    <polyline points="9 11 12 14 22 4"></polyline>
                                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                                </svg> 
                                                Edit 
                                            </button>

                                            <button @click="confirmDeleteCode(code.id)" class="flex items-center text-red-500">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="stroke-1.5 w-4 h-4 mr-1">
                                                    <path d="M3 6h18"></path>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg> 
                                                Delete 
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <Pagination v-if="codes.data.length" :data="codes" />
                    <div v-else class="w-full bg-white rounded-md">
                        <EmptyState title="No Codes Added" subtitle="Your application has no codes yet">
                            <template #action>
                                <PrimaryButton @click="router.visit(route('admin.codes.create'))">Create Code</PrimaryButton>
                            </template>
                        </EmptyState>
                    </div>
                </div>
            </div>
            <SlideOver :show="showSlideOver" @close="showSlideOver = false">
                <template #header>
                    <div class="flex flex-col">
                        <h4 class="text-lg font-semibold text-gray-800">Edit {{ form.name }}</h4>
                        <p class="text-sm text-gray-500">Edit information related to this customer</p>
                    </div>
                </template>
                <template #content>
                    <form @submit.prevent="submit">
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
                    </form>
                </template>
                <template #footer>
                    <div class="flex items-center gap-x-3 justify-start mt-auto">
                        <PrimaryButton @click="submit" :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                            Update Code
                        </PrimaryButton>
                        <SecondaryButton @click="showSlideOver = false">Cancel</SecondaryButton>
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
                        <DangerButton @click="deleteCustomer" :class="{ 'opacity-75': isDeletingCode }" :disabled="isDeletingCode" :loading="isDeletingCode">
                            Delete Code
                        </DangerButton>
                        <SecondaryButton @click="showDeleteModal = false">Cancel</SecondaryButton>
                    </div>
                </template>
            </ConfirmationModal>
            <Modal :show="issuingCode" @close="issuingCode = false">
                <div class="p-5">
                    <div class="flex items-center gap-4">
                        <TextInput @input="searchCustomer" class="w-full" v-model="query" placeholder="Search customer" />
                        <PrimaryButton>
                            <svg v-if="!loadingResults" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <svg v-if="loadingResults" class="w-6 h-6" stroke="#ffffff" width="200" height="200" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" style="transform:scale(0.8);">
                                <g fill="none" fill-rule="evenodd">
                                    <g transform="translate(1 1)" stroke-width="2">
                                        <circle stroke-opacity=".25" cx="18" cy="18" r="18"/>  
                                        <path d="M36 18c0-9.94-8.06-18-18-18">
                                            <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur=".5s" repeatCount="indefinite"/>
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </PrimaryButton>
                    </div>
                    <div class="mt-6">
                        <EmptyState v-if="customers.length == 0" title="Search Customer" subtitle="Search a customer to issue code" />
                        <div v-else>
                            <template v-for="customer in customers.slice(0, 9)" :key="customer.id">
                                <button @click="issueCodeToCustomer(customer.id)" class="my-2 w-full text-left hover:border-primary duration-200 border rounded-md px-4 py-2">
                                    <h4 class="text-gray-800 font-semibold">{{ customer.name }}</h4>
                                    <span class="text-sm text-gray-500">{{ customer.email }}</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>