<script setup>
import { Link, router } from '@inertiajs/vue3';
import { Badge } from '@/Components/ui/badge'

defineProps({
    link: String,
    label: String,
    badge: String,
    active: Boolean,
    showAs: {
        type: String,
        default: 'link'
    }
})
</script>

<template>
    <div>
        <button v-if="showAs === 'button'" class="flex items-center gap-2 rounded-lg p-3 text-gray-800 dark:text-muted-foreground transition-all hover:text-primary" @click="router.post(link)" :class=" { 'bg-muted dark:bg-muted/95 text-primary dark:text-primary' : active }">
            <slot name="icon"></slot>
            <span class="text-sm">{{ label }}</span>
            <Badge v-show="badge" class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full">
                {{ badge }}
            </Badge>
        </button>
        <Link v-else :href="link">
            <div class="flex items-center gap-2 p-2 text-gray-800 dark:text-muted-foreground transition-all hover:text-primary border-b-2 border-transparent" :class=" { '!border-fuchsia-500 text-primary dark:text-primary' : active }">
                <slot></slot>
                <span class="text-sm">{{ label }}</span>
                <Badge v-show="badge" class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full">
                    {{ badge }}
                </Badge>
            </div>
        </Link>
    </div>
</template>