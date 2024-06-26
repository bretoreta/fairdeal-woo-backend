<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';

import AdminLayout from '@/Layouts/AdminLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';
import Pagination from '@/Components/Pagination.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import SlideOver from '@/Components/SlideOver.vue';
import InputError from '@/Components/InputError.vue';
import { Button } from '@/Components/ui/button';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Textarea } from '@/Components/ui/textarea'
import { ToggleGroup, ToggleGroupItem } from '@/Components/ui/toggle-group'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'
import { Badge } from '@/Components/ui/badge'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const showSlideOver = ref(false);
const isDeletingProduct = ref(false);
const deletingProduct = ref(null);
const showDeleteModal = ref(false);

const form = useForm({
    id: '',
    name: '',
    location: '',
    phone: '',
    google_review_link: '',
    richtext: ''
});

const submit = () => {
    form.put(route('admin.products.update', form.id), {
        onSuccess: () => {
            showSlideOver.value = false;
        }
    });
}

</script>

<template>
    <AdminLayout title="Create Product">
        <div class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
            <div class="mx-auto grid max-w-[59rem] flex-1 auto-rows-max gap-4">
                <div class="flex items-center gap-4">
                    <Button variant="outline" size="icon" class="h-7 w-7">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                        <span class="sr-only">Back</span>
                    </Button>
                    <h1 class="flex-1 shrink-0 whitespace-nowrap text-xl font-semibold tracking-tight sm:grow-0">
                        Pro Controller
                    </h1>
                    <Badge variant="outline" class="ml-auto sm:ml-0">
                        In stock
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
                                            default-value="Gamer Gear Pro Controller" />
                                    </div>
                                    <div class="grid gap-3">
                                        <Label for="description">Description</Label>
                                        <Textarea id="description"
                                            default-value="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl nec ultricies ultricies, nunc nisl ultricies nunc, nec ultricies nunc nisl nec nunc."
                                            class="min-h-32" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        <div>
                            <QuillEditor 
                                theme="snow" 
                                placeholder='Compose an epic...' 
                                toolbar="full" 
                                v-model:content="form.richtext" 
                            />
                        </div>
                        <Card>
                            <CardHeader>
                                <CardTitle>Product Category</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div class="grid gap-6 sm:grid-cols-3">
                                    <div class="grid gap-3">
                                        <Label for="category">Category</Label>
                                        <Select>
                                            <SelectTrigger id="category" aria-label="Select category">
                                                <SelectValue placeholder="Select category" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="clothing">
                                                    Clothing
                                                </SelectItem>
                                                <SelectItem value="electronics">
                                                    Electronics
                                                </SelectItem>
                                                <SelectItem value="accessories">
                                                    Accessories
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="grid gap-3">
                                        <Label for="subcategory">
                                            Subcategory (optional)
                                        </Label>
                                        <Select>
                                            <SelectTrigger id="subcategory" aria-label="Select subcategory">
                                                <SelectValue placeholder="Select subcategory" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="t-shirts">
                                                    T-Shirts
                                                </SelectItem>
                                                <SelectItem value="hoodies">
                                                    Hoodies
                                                </SelectItem>
                                                <SelectItem value="sweatshirts">
                                                    Sweatshirts
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
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
                                        <Select>
                                            <SelectTrigger id="status" aria-label="Select status">
                                                <SelectValue placeholder="Select status" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="draft">
                                                    Draft
                                                </SelectItem>
                                                <SelectItem value="published">
                                                    Active
                                                </SelectItem>
                                                <SelectItem value="archived">
                                                    Archived
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
                                    Upload an image you'd love to look at
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
                        <Card>
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
                        </Card>
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
            </div>
        </div>
    </AdminLayout>
</template>