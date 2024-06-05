<template>
    <div class="min-h-screen bg-gray-100 grid grid-cols-12">
        <div class="flex flex-col items-center justify-center col-span-12 md:col-span-8">
            <div class="w-full sm:max-w-3xl">
                <div class="px-6">
                    <slot name="logo" />
                </div>

                <div class="w-full sm:max-w-3xl mt-6 p-6 overflow-hidden">
                    <slot />
                </div>
            </div>
        </div>
        <div class="hidden md:grid md:col-span-4 overflow-hidden">
            <img data-aos="fade-left" data-aos-delay="700" data-aos-duration="1000" src="https://res.cloudinary.com/dwl8bmexk/image/upload/v1684634282/behzad-ghaffarian-9hthGUJq6pY-unsplash_wox1tw.jpg" alt="Account Image" class="h-screen w-full object-cover">
        </div>
    </div>
</template>
