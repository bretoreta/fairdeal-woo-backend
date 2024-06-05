<script setup>
import { watch } from 'vue';
import { useColorMode } from '@vueuse/core'
import { Head, usePage, router } from '@inertiajs/vue3';
import { Toaster } from '@/Components/ui/sonner';
import { toast } from 'vue-sonner'

import NavbarLink from '@/Pages/Admin/Components/NavbarLink.vue';
import DateRangePicker from '@/Pages/Admin/Components/DateRangePicker.vue';
import { Button } from '@/Components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Input } from '@/Components/ui/input'
import { Sheet, SheetContent, SheetTrigger } from '@/Components/ui/sheet'
import { Label } from '@/Components/ui/label'


const mode = useColorMode();

watch(() => usePage().props.flash?.message , (message, newMessage) => {
    toast(usePage().props.flash?.message.type.toUpperCase(), {
        description: usePage().props.flash?.message.message,
    })
});

defineProps({
    title: String,
    pageHeader: String,
    pageSubHeader: String,
})
</script>
<template>
    <Head :title="title" />
    <div class="border-b sticky top-0 backdrop-blur-md">
        <div class="flex h-16 items-center px-4">
            <div class="relative z-20 flex items-center justify-center bg-muted rounded-md border border-slate-300 dark:bg-white dark:text-muted p-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                </svg>
                <!-- Fairdeal Woo Backend -->
            </div>
            <nav class="flex items-center space-x-4 lg:space-x-6 mx-6">
                <NavbarLink label="Dashboard" :active="route().current('admin.dashboard')" :link="route('admin.dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </NavbarLink>

                <NavbarLink label="Showrooms" :active="route().current('admin.showrooms.*')" :link="route('admin.showrooms.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                </NavbarLink>
                
                <NavbarLink label="Employees" :active="route().current('admin.employees.*')" :link="route('admin.employees.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                    </svg>
                </NavbarLink>

                <NavbarLink label="Products" :active="route().current('admin.employees.*')" :link="route('admin.employees.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </NavbarLink>
            </nav>
            <div class="ml-auto flex items-center space-x-4">
                <div class="w-full flex-1">
                    <form>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute left-2.5 top-2.5 h-5 w-5 text-muted-foreground">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        <Input
                            type="search"
                            placeholder="Search anything..."
                            class="w-full appearance-none bg-background pl-10 shadow-none"
                        />
                        </div>
                    </form>
                </div>
                <DropdownMenu>
                    <DropdownMenuTrigger class="hidden md:flex" as-child>
                        <Button variant="outline" size="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-[1rem] w-[1rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute h-[1rem] w-[1rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                            <span class="sr-only">Toggle theme</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuLabel>Color Mode</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem @click="mode = 'light'">
                            Light
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="mode = 'dark'">
                            Dark
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="mode = 'auto'">
                            System
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="secondary" class="rounded-full">
                            <span class="relative flex-shrink-0 mr-0 md:mr-2">
                                <img class="w-7 h-7 rounded-full" :src="$page.props.auth.user.profile_photo_url" alt="profile" />
                                <span class="absolute right-0 -mb-0.5 bottom-0 w-2 h-2 rounded-full bg-green-500 border border-white dark:border-gray-300"></span>
                            </span>
                            <Label class="hover:cursor-pointer hidden md:block">{{ $page.props.auth.user.name }}</Label>
                            <svg viewBox="0 0 24 24" class="w-4 ml-1 flex-shrink-0 text-gray-400 hidden md:block" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        <span class="sr-only">Toggle user menu</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <div>
                            <div class="py-2 px-4 border-b">
                                <h5 class="text-sm text-gray-800 font-semibold dark:text-white">Hello {{ $page.props.auth.user.name }}!</h5>
                                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $page.props.auth.user.email }}</p>
                                <span class="text-xs text-gray-400 uppercase">{{ $page.props.auth.user.roles[0].name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <NavbarLink :link="route('admin.dashboard')" label="Dashboard">
                                    <template #icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"></path>
                                        </svg>
                                    </template>
                                </NavbarLink>
                                <NavbarLink :link="route('admin.profile.show')" label="My Profile">
                                    <template #icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </template>
                                </NavbarLink>
                                <DropdownMenuSeparator />
                                <button @click="router.post(route('logout'));" class="flex items-center gap-2 py-2 px-4 rounded-md duration-200 w-full text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                    </svg>
                                    <span class="text-sm">Logout</span>
                                </button>
                            </div>
                        </div>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </div>
    <div class="space-y-4 p-8 pt-6">
        <div class="flex items-center justify-between border-b dark:border-gray-700 border-dashed">
            <div class="pb-6">
                <h1 class="text-lg font-semibold md:text-2xl">
                    {{ pageHeader }}
                </h1>
                <p class="text-sm text-muted-foreground">
                    {{ pageSubHeader }}
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <DateRangePicker />
                <Button>Refresh Data</Button>
            </div>
        </div>
        <div class="min-h-screen flex flex-col justify-between">
            <slot />
            <div class="w-full pt-10 text-center">
                <p class="text-xs text-gray-400 dark:text-muted-foreground">Developed and Maintained with ❤️ by Fairdeal Furniture Dev Team</p>
            </div>
        </div>
    </div>
    <Toaster />
</template>