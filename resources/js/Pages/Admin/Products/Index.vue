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
import { Badge } from '@/Components/ui/badge';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'

const props = defineProps({
    products: Object,
    activeSync: Boolean,
});

dayjs.extend(relativeTime);

const showSlideOver = ref(false);
const isDeletingProduct = ref(false);
const deletingProduct = ref(null);
const showDeleteModal = ref(false);

const formatter = new Intl.NumberFormat("en-GB", {
    style: "currency",
    currency: "KSH",
    minimumFractionDigits: 2
});

const form = useForm({
    id: '',
    name: '',
    location: '',
    phone: '',
    google_review_link: '',
});

const editProduct = (showroom) => {
    form.id = showroom.id
    form.name = showroom.name
    form.location = showroom.location
    form.phone = showroom.phone
    form.google_review_link = showroom.google_review_link

    showSlideOver.value = true;
}

const confirmDeleteProduct = (id) => {
    deletingProduct.value = id;
    showDeleteModal.value = true;
}

const featureProduct = (id) => {
    router.post(route('admin.products.feature', id), { }, {
        preserveScroll: true,
    })
}

const unFeatureProduct = (id) => {
    router.post(route('admin.products.unfeature', id), { }, {
        preserveScroll: true,
    })
}

const deleteProduct = () => {
    router.delete(route('admin.products.delete', deletingProduct.value), {
        preserveScroll: true,
        onStart: visit => {
            isDeletingProduct.value = true;
        },
        onFinish: visit => {
            isDeletingProduct.value = false;
        },
        onSuccess: () => {
            showDeleteModal.value = false
        }
    });
}

const submit = () => {
    form.put(route('admin.products.update', form.id), {
        onSuccess: () => {
            showSlideOver.value = false;
        }
    });
}

</script>
<template>
    <AdminLayout title="Products">
        <div>
            <div class="grid flex-1 items-start gap-4 md:gap-8">
                <Tabs default-value="all">
                    <div class="flex items-center">
                        <TabsList>
                            <TabsTrigger value="all">
                                All Products
                            </TabsTrigger>
                            <TabsTrigger value="archived" class="hidden sm:flex">
                                Archived
                            </TabsTrigger>
                        </TabsList>
                        <div class="ml-auto flex items-center gap-2">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="outline" class="h-9 gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5">
                                            <path d="M3 6h18"></path><path d="M7 12h10"></path><path d="M10 18h4"></path>
                                        </svg>
                                        <span class="sr-only sm:not-sr-only sm:whitespace-nowrap">Filter</span>
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent align="end">
                                    <DropdownMenuLabel>Filter by</DropdownMenuLabel>
                                    <DropdownMenuSeparator />
                                    <DropdownMenuItem checked>All</DropdownMenuItem>
                                    <DropdownMenuItem>Synced</DropdownMenuItem>
                                    <DropdownMenuItem>Unsynced</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                            <Button variant="outline" class="h-9 gap-1" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </svg>
                                <span class="sr-only sm:not-sr-only sm:whitespace-nowrap">Export</span>
                            </Button>
                            <Button class="h-9 gap-1" @click="router.visit(route('admin.products.pull'))" v-if="products.data.length == 0" :disabled="activeSync">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span class="sr-only sm:not-sr-only sm:whitespace-nowrap">Pull Products</span>
                            </Button>
                        </div>
                    </div>
                    <TabsContent v-if="products.data.length" value="all">
                        <Card>
                            <CardHeader>
                                <CardTitle>Products</CardTitle>
                                <CardDescription> Manage your products and view their sync status.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <!-- <TableHead class="hidden w-[100px] sm:table-cell">
                                                <span class="sr-only">img</span>
                                            </TableHead> -->
                                            <TableHead>Product Details</TableHead>
                                            <TableHead class="text-center">Status</TableHead>
                                            <TableHead class="hidden md:table-cell text-right w-fit">
                                                Price
                                            </TableHead>
                                            <TableHead class="hidden md:table-cell">
                                                Last Modified
                                            </TableHead>
                                            <TableHead class="hidden md:table-cell">
                                                Sync Status
                                            </TableHead>
                                            <TableHead>
                                                <span class="sr-only">Actions</span>
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow v-for="product in products.data" :key="product.id">
                                            <!-- <TableCell class="hidden sm:table-cell">
                                                Image
                                            </TableCell> -->
                                            <TableCell class="font-medium">
                                                <h4>{{ product.name }}</h4>
                                                <div class="-ml-2.5 mt-2 inline-flex gap-x-2 flex-wrap">
                                                    <Badge v-for="category in product.categories" variant="secondary" :key="category.id" class="capitalize">
                                                        {{ category.name }}
                                                    </Badge>
                                                </div>
                                            </TableCell>
                                            <TableCell class="w-20 text-center">
                                                <Badge variant="outline" class="capitalize">
                                                    {{ product.stock_status }}
                                                </Badge>
                                            </TableCell>
                                            <TableCell class="hidden md:table-cell text-right w-40 font-mono">
                                                {{ formatter.format(product.regular_price) }}
                                            </TableCell>
                                            <TableCell class="hidden md:table-cell w-40">
                                                {{ dayjs(product.updated_at).fromNow() }}
                                            </TableCell>
                                            <TableCell class="hidden md:table-cell w-32">
                                                <svg v-if="product.sync_status == 'synced'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-lime-600 dark:text-lime-500">
                                                    <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                                </svg>
                                                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM6.75 9.25a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd" />
                                                </svg>
                                            </TableCell>
                                            <TableCell class="w-20">
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger as-child>
                                                        <Button aria-haspopup="true" size="icon" variant="ghost">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                            </svg>
                                                            <span class="sr-only">Toggle menu</span>
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent align="end">
                                                        <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                                        <DropdownMenuItem>
                                                            <Link :href="route('admin.products.edit', product.id)" class="w-full">Edit</Link>
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem disabled>Delete</DropdownMenuItem>
                                                    </DropdownMenuContent>
                                                </DropdownMenu>
                                            </TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
            <Pagination v-if="products.data.length" :data="products" />
            <div v-if="!products.data.length && activeSync" class="w-full bg-white dark:bg-muted/40 rounded-md mt-4">
                <EmptyState title="Sync Running" subtitle="There is an active sync that is currently running in the background. You'll be notified when its done" />
            </div>
            <div v-if="!products.data.length && !activeSync" class="w-full bg-white dark:bg-muted/40 rounded-md mt-4">
                <EmptyState title="No Products Added" subtitle="Your application has no products yet">
                    <template #action>
                        <Button @click="router.visit(route('admin.products.pull'))">Pull Products</Button>
                    </template>
                </EmptyState>
            </div>
        </div>
        <SlideOver :show="showSlideOver" @close="showSlideOver = false">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Edit {{ form.name }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Edit information related to this product</p>
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
                    <Button variant="destructive" @click="deleteProduct" :class="{ 'opacity-75': isDeletingProduct }" :disabled="isDeletingProduct" :loading="isDeletingProduct">
                        Delete Showroom
                    </Button>
                    <Button variant="outline" @click="showDeleteModal = false">Cancel</Button>
                </div>
            </template>
        </ConfirmationModal>
    </AdminLayout>
</template>