<script setup>
import { router } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import EmptyState from '@/Components/EmptyState.vue';

defineProps({
    activeSync: Boolean,
    syncable: Boolean,
})

const runSync = () => {
    router.post(route('admin.sync.dispatch'));
}
</script>

<template>
    <div class="border rounded p-5">
        <div class="pb-2">
            <h4 class="text-lg font-semibold">Sync Manager</h4>
            <p class="text-gray-500 text-sm">Use this resource to manage the sync status of the application.</p>
        </div>
        <div class="pt-4 space-y-4">
            <Button @click="runSync" v-if="!activeSync && syncable">
                Run Sync
            </Button>
            <EmptyState v-if="activeSync" title="Sync Running" subtitle="There is an active sync that is currently running in the background. You'll be notified when its done" />
            <EmptyState v-if="!syncable && !activeSync" title="The sky is clear" subtitle="All products have been syncd to the website. Nothing to see here." type="info" />
        </div>
    </div>
</template>