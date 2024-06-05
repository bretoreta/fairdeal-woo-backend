<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';

import Dropdown from '@/Components/Dropdown.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import EmptyState from '@/Components/EmptyState.vue';
import NavbarLink from './NavbarLink.vue';

defineProps({
    title: String,
});

const searchingCodes = ref(false);
const zeroResultsFound = ref(false);
const loadingResults = ref(false);
const query = ref(null);
const codes = ref([]);

const searchCode = debounce(e => {
    loadingResults.value = true;

    if(query.value) {
        axios.get(route('api.codes.index', {
            search: query.value
        })).then((res) => {
            if(res.data.length == 0) {
                zeroResultsFound.value = true;
                usePage().props.flash.message = {
                    type: 'info',
                    message: 'No Active Code Found. Please try another code'
                };
            }
            codes.value = res.data;
        })
        .catch((error) => {
            usePage().props.flash.message = {
                type: 'error',
                message: 'Something went wrong. Please Try again'
            };
        })
        .finally(() => {
            loadingResults.value = false;
        });
    }
    else {
        codes.value = [];
        zeroResultsFound.value = false;
        loadingResults.value = false
    }
}, 800)

const redeemCode = (code) => {
    router.post(route('admin.codes.redeem', code), {}, {
        preserveState: false
    });
}

</script>
<template>
    <div class="sticky top-0 z-[60] w-full">
        <div class="bg-white py-2 px-6 border flex justify-between">
            <div class="flex items-center">
                <div class="rounded border py-2 px-4 flex items-center gap-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                    <span class="text-sm">{{ $page.props.showroom }}</span>
                </div>
            </div>
            <div class="flex items-center gap-x-3 divide-x">
                <div class="flex items-center gap-3">
                    <button class="flex items-center p-2 rounded-md hover:bg-gray-50 duration-200">
                        <span class="relative flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                        </span>
                    </button>
                    <button @click="searchingCodes = true" class="flex items-center p-2 rounded-md hover:bg-gray-50 duration-200">
                        <span class="relative flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>
                    </button>
                    <Dropdown :width="72">
                        <template #trigger>
                            <button class="flex items-center p-2 rounded-md hover:bg-gray-50 duration-200">
                                <span class="relative flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                    </svg>
                                    <!-- <span class="absolute top-0 -mb-0.5 bottom-0 w-2 h-2 rounded-full bg-red-500 border border-white"></span>
                                    <span class="absolute top-0 -mb-0.5 bottom-0 w-2 h-2 rounded-full bg-red-500 border border-white animate-ping"></span> -->
                                </span>
                            </button>
                        </template>
                        <template #content>
                            <div class="p-4">
                                <div class="pb-2 border-b">
                                    <h5 class="text-sm text-gray-800 font-semibold">Notifications</h5>
                                    <p class="text-xs text-gray-500">Read your notifications from here</p>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <div>
                                        <img src="../../../../svg/empty_state.svg" alt="Empty State" class="h-56">
                                        <p class="mt-6 text-sm text-gray-600 text-center">No Notifications Yet</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </Dropdown>
                </div>
                <Dropdown :width="56">
                    <template #trigger>
                        <button class="flex items-center px-4 py-2 ml-2 rounded-md hover:bg-gray-50 duration-200">
                            <span class="relative flex-shrink-0">
                                <img class="w-7 h-7 rounded-full" :src="$page.props.auth.user.profile_photo_url" alt="profile" />
                                <span class="absolute right-0 -mb-0.5 bottom-0 w-2 h-2 rounded-full bg-green-500 border border-white"></span>
                            </span>
                            <span class="ml-2 text-sm font-semibold text-gray-600">{{ $page.props.auth.user.name }}</span>
                            <svg viewBox="0 0 24 24" class="w-4 ml-1 flex-shrink-0 text-gray-400" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <div>
                            <div class="py-2 px-4 border-b">
                                <h5 class="text-sm text-gray-800 font-semibold">Hello {{ $page.props.auth.user.name }}!</h5>
                                <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
                                <span class="text-xs text-gray-400 uppercase">{{ $page.props.auth.user.roles[0].name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <NavbarLink :link="route('employee.dashboard')" label="Dashboard">
                                    <template #icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"></path>
                                        </svg>
                                    </template>
                                </NavbarLink>
                                <NavbarLink :link="route('employees.profile.show')" label="My Profile">
                                    <template #icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </template>
                                </NavbarLink>
                                <div class="border-t" />
                                <button @click="router.post(route('logout'));" class="flex items-center gap-2 py-2 px-4 rounded-md duration-200 w-full text-red-500 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                    </svg>
                                    <span class="text-sm">Logout</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
        <Modal :show="searchingCodes" @close="searchingCodes = false">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <!-- <TextInput @input="searchCode" class="w-full" v-model="query" placeholder="Search code..." /> -->
                    <div class="relative w-full text-gray-500">
                        <input @input="searchCode" v-model="query" class="disabled:bg-gray-100 disabled:cursor-not-allowed transition duration-200 ease-in-out text-sm border-gray-200 shadow-sm rounded-md placeholder:text-gray-400/90 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:border-green-500 focus:border-opacity-40 w-full pr-10"
                            type="text" placeholder="Search...">
                        <svg v-if="!loadingResults" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="stroke-1.5 absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <svg v-if="loadingResults" class="stroke-1.5 absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" stroke="currentColor" width="200" height="200" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" style="transform:scale(0.8);">
                            <g fill="none" fill-rule="evenodd">
                                <g transform="translate(1 1)" stroke-width="2">
                                    <circle stroke-opacity=".25" cx="18" cy="18" r="18"/>  
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                        <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur=".5s" repeatCount="indefinite"/>
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <EmptyState v-if="codes.length == 0 && !zeroResultsFound" title="Search Code" subtitle="Search a code to show details" />
                    <EmptyState v-if="zeroResultsFound" title="No Code Found" subtitle="We couldn't find this code. Has it been redeemed?" />
                    <div v-else>
                        <template v-for="code in codes.slice(0, 9)" :key="code.id">
                            <div class="my-2 border rounded-md px-4 py-2 flex justify-between">
                                <div>
                                    <h4 class="text-gray-800 font-semibold">{{ code.token }}</h4>
                                    <span class="text-sm text-gray-500">{{ code.owner.name }}</span>
                                </div>
                                <SecondaryButton :disabled="code.is_used" @click="redeemCode(code.token)"> {{ code.is_used ? 'Used' : 'Redeem' }}</SecondaryButton>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>