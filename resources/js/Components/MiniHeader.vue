<template>
    <div class="bg-white border-b">
        <div class="px-32 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <LanguageSelector />
                </div>
                <div class="flex items-center text-gray-500">
                    <div class="inline-flex items-center space-x-2 border-r border-gray-200 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-primary">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm">+254 706 725 685</p>
                    </div>
                    <div class="inline-flex items-center space-x-2 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-primary">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                        <p class="text-sm">info@biasharayako.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import LanguageSelector from '@/Components/LanguageSelector.vue';
</script>