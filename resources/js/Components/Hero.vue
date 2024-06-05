<script setup>
import { Link} from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-gray-100 hero-banner">
        <section class="py-10 sm:py-10">
            <div class="mx-auto max-w-[83rem] sm:px-0 pb-10">
                <div class="mx-auto relative">
                    <div class="max-w-[60rem] bg-white border rounded-md shadow-md p-10">
                        <h1 class="px-2 text-gray-500 text-lg">All-in-one online rental shop, made for One and All</h1>
                        <p class="mt-2 text-4xl font-bold leading-tight text-gray-900 sm:leading-tight sm:text-5xl lg:text-7xl lg:leading-tight">
                            Get Your Business <br> An Online Shop <br>
                            <span class="relative inline-flex sm:inline">
                                <span class="bg-gradient-to-r from-green-500 via-teal-700 to-purple-500 blur-md filter opacity-30 w-full h-full absolute inset-0"></span>
                                <span class="relative">At Affordable Prices</span>
                            </span>
                        </p>

                        <div class="px-8 sm:items-center sm:justify-start sm:px-0 sm:space-x-5 sm:flex mt-14">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('register')"
                                title="Register a new account with BiasharaYako"
                                class="inline-flex items-center justify-center w-full px-6 py-3 text-lg text-white transition-all duration-200 bg-primary border-2 border-transparent sm:w-auto rounded-md hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:bg-green-800"
                                role="button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                Register An Account
                            </Link>

                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('login')"
                                title="Login to an existing account"
                                class="inline-flex items-center justify-center w-full px-6 py-3 mt-4 text-lg font-semibold text-gray-900 transition-all duration-200 border-2 border-gray-400 sm:w-auto sm:mt-0 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 hover:bg-gray-900 focus:bg-gray-900 hover:text-white focus:text-white hover:border-gray-900 focus:border-gray-900"
                                role="button"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                Login To Your Account
                            </Link>
                        </div>
                    </div>
                    <div class="absolute top-10 -right-20">
                        <img src="../../img/hero-banner-asset@4x.png" alt="Hero Asset Banner" class="w-[650px] object-contain">
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>