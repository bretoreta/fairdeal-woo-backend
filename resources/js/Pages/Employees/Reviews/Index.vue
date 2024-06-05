<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Button } from '@/Components/ui/button';
import InputError from '@/Components/InputError.vue';
import { Label } from '@/Components/ui/label';
import { Input } from '@/Components/ui/input';
import { Textarea } from '@/Components/ui/textarea';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card'

const props = defineProps({
    codes: Object,
});

const tones = ref(['Neutral', 'Professional', 'Playful', 'Authoritative', 'Candid', 'Blunt', 'Controversial', 'Informal', 'Formal', 'Naive', 'Personal', 'Learned']);

const form = useForm({
    tone: 'Neutral',
    topic: null,
    addittional_info: null,
});

const submit = () => {
    if(confirm("Please confirm you want to send this propt. This action cannot be reversed!")) {
        form.post(route('admin.reviews.generate'));
    }
}
</script>
<template>
    <EmployeeLayout title="Reviews" page-header="AI Reviews 🤖" page-sub-header="Manage AI Reviews from here.">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="flex flex-wrap items-center col-span-8 mt-2 sm:flex-nowrap" data-aos="fade-up" data-aos-delay="100" data-aos-once="true">
                <form @submit.prevent="submit" class="w-full">
                    <div>
                        <Label>Tone</Label>
                        <Select v-model="form.tone">
                            <SelectTrigger class="mt-1">
                                <SelectValue placeholder="Select a showroom" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem v-for="tone in tones" :key="tone" :value="tone">
                                        {{ tone }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                        <InputError class="mt-2" :message="form.errors.tone" />
                    </div>

                    <div class="mt-4">
                        <Label>Topic</Label>
                        <Input
                            id="topic"
                            v-model="form.topic"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.topic" />
                    </div>

                    <div class="mt-4">
                        <Label>Additional Info</Label>
                        <Textarea
                            id="addittional_info"
                            v-model="form.addittional_info"
                            type="text"
                            :rows="4"
                            class="mt-1 block w-full"
                        />
                        <InputError class="mt-2" :message="form.errors.addittional_info" />
                    </div>
                    
                    <div class="mt-4">
                        <Button :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                            Generate 
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                            </svg>
                        </Button>
                    </div>
                </form>
            </div>
            <div class="col-span-4">
                <Card>
                    <CardHeader>
                        <CardTitle>Propty Summary</CardTitle>
                        <CardDescription>Here's a summary of your prompt that will be generated, make sure everything looks good.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <p class="code"># Generate an authentic google review about <span class="font-semibold text-green-600">{{ form.topic ?? '---Topic---' }}</span>. Use a <span class="font-semibold text-green-600">{{ form.tone }}</span> tone and make the review as original as possible. Here's additional info to help <span class="font-semibold text-green-600">{{ form.addittional_info ?? '---Additional Info---' }}</span></p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </EmployeeLayout>
</template>