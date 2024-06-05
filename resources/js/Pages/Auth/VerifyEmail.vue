<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    props.status = null;
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo data-aos="fade-in" />
        </template>

        <div class="mb-6">
            <h3 class="text-3xl font-extrabold text-gray-900" data-aos="fade-down" data-aos-delay="200">Verify your email</h3>
            <p class="text-gray-500 text-sm mt-2" data-aos="fade-down" data-aos-delay="400">Already a member? <Link :href="route('login')" class="text-blue-500 font-semibold focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-md">Sign to your account</Link></p>
        </div>

        <div class="mb-4 text-sm text-gray-600" data-aos="fade-down" data-aos-delay="600">
            Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600" data-aos="fade-up">
            A new verification link has been sent to the email address you provided in your profile settings.
        </div>

        <form @submit.prevent="submit" data-aos="fade-in" data-aos-delay="800">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-75': form.processing }" :disabled="form.processing" :loading="form.processing">
                    Resend Verification Email
                </PrimaryButton>

                <div>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2"
                    >
                        Log Out
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
