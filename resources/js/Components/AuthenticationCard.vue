<script setup>
import Banner from '@/Components/Banner.vue';
import { cn } from '@/lib/utils'
import { buttonVariants } from '@/Components/ui/button'

defineProps({
    title: String,
    subtitle: String,
});
</script>

<template>
    <div class="container relative hidden h-screen flex-col items-center justify-center md:grid lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div class="relative hidden h-full flex-col bg-muted p-10 text-white dark:border-r lg:flex">
            <div class="absolute inset-0 bg-slate-900" />
                <div class="relative z-20 flex items-center text-lg font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>
                    Fairdeal Woo Backend
                </div>
                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <footer class="text-sm">
                            Developed with ❤️ by Fairdeal Furniture Development Team
                        </footer>
                    </blockquote>
                </div>
            </div>
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        {{ subtitle }}
                    </p>
                </div>
                <slot></slot>
                <p class="px-8 text-center text-sm text-muted-foreground">
                    By clicking continue, you agree to our
                    <a href="/terms" class="underline underline-offset-4 hover:text-primary">
                        Terms of Service
                    </a>
                    and
                    <a href="/privacy" class="underline underline-offset-4 hover:text-primary">
                        Privacy Policy
                    </a>.
                </p>
            </div>
        </div>
        <Banner />
    </div>
</template>
