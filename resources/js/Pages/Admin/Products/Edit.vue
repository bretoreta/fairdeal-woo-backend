<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Textarea } from '@/Components/ui/textarea'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card'
import { Badge } from '@/Components/ui/badge'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    product: Object
});

const showSlideOver = ref(false);

const form = useForm({
    id: props.product.id,
    name: props.product.name,
    featured: props.product.featured,
    description: props.product.description,
    short_description: props.product.short_description,
    sku: props.product.sku,
    regular_price: props.product.regular_price,
    sale_price: props.product.sale_price,
    manage_stock: props.product.manage_stock,
    stock_quantity: props.product.stock_quantity,
    stock_status: props.product.stock_status,
    product_status: props.product.product_status,
    attributes: props.product.attributes,
    sync_status: props.product.sync_status,
});

const submit = () => {
    form.put(route('admin.products.update', form.id));
}

</script>

<template>
    <AdminLayout title="Edit Product">
        <div class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <form class="mx-auto grid max-w-[59rem] flex-1 auto-rows-max gap-4" @submit.prevent="submit">
                <div class="flex items-center gap-4">
                    <Link class="h-7 w-7 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground" 
                        :href="route('admin.products.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                        <span class="sr-only">Back</span>
                    </Link>
                    <h1 class="flex-1 shrink-0 whitespace-nowrap text-xl font-semibold tracking-tight sm:grow-0">
                        {{ product.name }}
                    </h1>
                    <Badge variant="outline" class="ml-auto capitalize sm:ml-0">
                        {{ product.stock_status }}
                    </Badge>
                    <div class="hidden items-center gap-2 md:ml-auto md:flex">
                        <Button variant="outline" size="sm">
                            Discard
                        </Button>
                        <Button size="sm">
                            Save Product
                        </Button>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-[1fr_250px] lg:grid-cols-3 lg:gap-8">
                    <div class="grid auto-rows-max items-start gap-4 lg:col-span-2 lg:gap-8">
                        <Card>
                            <CardHeader>
                                <CardTitle>Product Details</CardTitle>
                                <CardDescription>
                                    Details about this particular product
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div class="grid gap-6">
                                    <div class="grid gap-3">
                                        <Label for="name">Name</Label>
                                        <Input id="name" type="text" class="w-full"
                                            v-model="form.name"/>
                                    </div>
                                    <div class="grid gap-3">
                                        <Label for="description">Description</Label>
                                        <Textarea id="description"
                                            v-model="form.short_description"
                                            class="min-h-32" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        <div>
                            <QuillEditor 
                                theme="snow" 
                                placeholder='Compose something epic...' 
                                toolbar="full" 
                                contentType="html"
                                v-model:content="form.description" 
                            />
                        </div>
                        <Card>
                            <CardHeader>
                                <CardTitle>Product Prices</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="col-span-2 md:col-span-1">
                                        <Label for="regular_price">Regular Price</Label>
                                        <Input id="regular_price" type="text" class="w-full"
                                            v-model="form.regular_price"/>
                                    </div>
                                    <div class="col-span-2 md:col-span-1">
                                        <Label for="sale_price">Sale Price</Label>
                                        <Input id="sale_price" type="text" class="w-full"
                                            v-model="form.sale_price"/>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                    <div class="grid auto-rows-max items-start gap-4 lg:gap-8">
                        <Card>
                            <CardHeader>
                                <CardTitle>Product Status</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div class="grid gap-6">
                                    <div class="grid gap-3">
                                        <Label for="status">Status</Label>
                                        <Select v-model="form.product_status">
                                            <SelectTrigger id="status" aria-label="Select status">
                                                <SelectValue placeholder="Select status" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="publish">
                                                    Active
                                                </SelectItem>
                                                <SelectItem value="draft">
                                                    Draft
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        <Card class="overflow-hidden">
                            <CardHeader>
                                <CardTitle>Product Images</CardTitle>
                                <CardDescription>
                                    Images are pulled in from the vault.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div class="grid gap-2">
                                    <img alt="Product image" class="aspect-square w-full rounded-md object-cover"
                                        height="300" src="../../../../img/placeholder.svg" width="300">
                                    <div class="grid grid-cols-3 gap-2">
                                        <button>
                                            <img alt="Product image" class="aspect-square w-full rounded-md object-cover"
                                                height="84" src="../../../../img/placeholder.svg" width="84">
                                        </button>
                                        <button>
                                            <img alt="Product image" class="aspect-square w-full rounded-md object-cover"
                                                height="84" src="../../../../img/placeholder.svg" width="84">
                                        </button>
                                        <button
                                            class="flex aspect-square w-full items-center justify-center rounded-md border border-dashed">
                                            <Upload class="h-4 w-4 text-muted-foreground" />
                                            <span class="sr-only">Upload</span>
                                        </button>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        <!-- <Card>
                            <CardHeader>
                                <CardTitle>Archive Product</CardTitle>
                                <CardDescription>
                                    When a product is archived, it won't be shown on the shop or search.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div />
                                <Button size="sm" variant="secondary">
                                    Archive Product
                                </Button>
                            </CardContent>
                        </Card> -->
                    </div>
                </div>
                <div class="flex items-center justify-center gap-2 md:hidden">
                    <Button variant="outline" size="sm">
                        Discard
                    </Button>
                    <Button size="sm">
                        Save Product
                    </Button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>