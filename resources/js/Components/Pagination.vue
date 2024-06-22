<script setup>
    import { Link } from '@inertiajs/vue3';
    
    defineProps({
        data: Object
    });
</script>

<template>
    <div class="flex items-center justify-between border rounded-b-md bg-white dark:bg-black px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link 
                :href="data.prev_page_url"
                :preserve-scroll="true"
                :disabled="!prev_page_url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white dark:bg-black px-4 py-2 text-sm 3xl:text-xl font-medium">
                Previous
            </Link>
            <Link 
                :href="data.next_page_url"
                :preserve-scroll="true"
                :disabled="!next_page_url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white dark:bg-black px-4 py-2 text-sm 3xl:text-xl font-medium">
                Next
            </Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm 3xl:text-xl">
                    Showing
                    <span class="font-medium">{{ data.from }}</span>
                    to
                    <span class="font-medium">{{ data.to }}</span>
                    of
                    <span class="font-medium">{{ data.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex space-x-1 rounded-md" aria-label="Pagination">
                    <template v-for="(link, key) in data.links" :key="key">
                        <Link :href="link.url" v-html="link.label" 
                            :preserve-scroll="true"
                            :disabled="!link.active"
                            class="relative inline-flex duration-200 items-center shadow rounded border bg-white dark:bg-black px-[14px] py-2 text-sm font-medium focus:z-20"
                            :class="{ '!bg-fuchsia-600 !text-white !border-fuchsia-600 hover:!bg-fuchsia-700' : link.active }"
                            >
                        </Link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>