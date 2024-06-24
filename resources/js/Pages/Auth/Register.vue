<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import RegistrationCard from '@/Components/Auth/RegistrationCard.vue';

const form = useForm({
    name: '',
    email: '',
    username: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const getQueryStringValue = (parameter) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(parameter);
}

const submit = () => {
    form.transform(data => ({
        ...data, 
        referrer: getQueryStringValue('ref')
    })).post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <RegistrationCard>
        <template #logo>
            <AuthenticationCardLogo data-aos="fade-in" />
        </template>

        <div class="mb-6">
            <h3 class="text-3xl font-extrabold text-gray-900" data-aos="fade-down" data-aos-delay="200">Register an account</h3>
            <p class="text-gray-500 text-sm mt-2" data-aos="fade-down" data-aos-delay="400">Already a member? <Link :href="route('login')" class="text-blue-500 font-semibold focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md">Sign to your account</Link></p>
        </div>

        <form @submit.prevent="submit" class="pt-4" data-aos="fade-in" data-aos-delay="700" data-aos-duration="1000">
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

            <div class="mt-4 flex items-center space-x-4">
                <div class="w-full">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="w-full">
                    <InputLabel for="username" value="Username" />
                    <TextInput
                        id="username"
                        v-model="form.username"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.username" />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone Number" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4 flex items-center space-x-4">
                <div class="w-full">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="w-full">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            By checking this box I agree to the <a target="_blank" :href="route('terms.show')" class="text-sm font-semibold text-blue-500 hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="text-sm font-semibold text-blue-500 hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-start mt-6">
                <PrimaryButton :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </RegistrationCard>
</template>
