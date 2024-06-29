<script setup>
import dayjs from 'dayjs';
import { router } from '@inertiajs/vue3';
import relativeTime from 'dayjs/plugin/relativeTime';

import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import EmptyState from '@/Components/EmptyState.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs';

dayjs.extend(relativeTime);

defineProps({
    notifications: Array
});
</script>

<template>
    <div class="border rounded p-5">
        <div class="pb-2">
            <h4 class="text-lg font-semibold">Notifications Manager</h4>
            <p class="text-gray-500 text-sm">Use this resource to manage notifications you receive for your account.</p>
        </div>
        <div class="pt-4 space-y-4">
            <Tabs default-value="unread" class="space-y-4">
                <TabsList>
                    <TabsTrigger value="unread">
                        <div class="inline-flex items-center gap-x-2">
                            <p>Unread</p>
                            <Badge variant="destructive" v-if="notifications.filter(n => !n.read_at).length">{{ notifications.filter(n => !n.read_at).length }}</Badge>
                        </div>
                    </TabsTrigger>
                    <TabsTrigger value="history">
                        History
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="unread" class="space-y-4">
                    <Button v-if="notifications.filter(n => !n.read_at).length" size="sm" variant="outline" @click="router.post(route('admin.notifications.markallasread'))">
                        Mark All As Read
                    </Button>
                    <div class="grid grid-cols-12 gap-2">
                        <div v-for="notification in notifications.filter(n => !n.read_at)" :key="notification.id" class="col-span-12 md:col-span-7 rounded border">
                            <div class="border-l-4 p-4 rounded" :class="notification.data.message_type == 'success' ?'border-lime-500' : 'border-red-600'">
                                <div class="flex items-center gap-3">
                                    <img :src="notification.data.actor_profile" class="size-10 rounded-full" alt="Actor Image">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-white">{{ notification.data.actor_name }}</h4>
                                        <p class="text-gray-500 text-xs">{{ dayjs(notification.created_at).fromNow() }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-gray-800 dark:text-gray-300">{{ notification.data.message }}</p>
                                </div>
                                <div class="mt-4 p-3 rounded border bg-gray-200 dark:bg-muted/70" v-if="notification.data.message_type == 'exception'">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-300">{{ notification.data.exception_message }}</p>
                                </div>
                                <div class="mt-4 inline-flex gap-x-2" v-if="notification.data.actions">
                                    <Button size="sm" v-if="notification.data.actions?.primary" @click="router.post(notification.data.actions?.primary.action_url)">
                                        {{ notification.data.actions?.primary.action_label }}
                                    </Button>
                                    <Button size="sm" variant="outline" v-if="notification.data.actions?.secondary" @click="router.post(notification.data.actions?.secondary.action_url)">
                                        {{ notification.data.actions?.secondary.action_label }}
                                    </Button>
                                </div>
                            </div>
                            <!-- <div v-if="notification.data.message_type == 'success'">
                                <div class="bg-green-600 size-3 z-2 rounded-full absolute -top-1 -right-1" />
                                <div class="bg-green-600 size-3 rounded-full animate-ping -z-0 absolute -top-1 -right-1" />
                            </div>
                            <div v-if="notification.data.message_type == 'exception'">
                                <div class="bg-orange-600 size-3 z-2 rounded-full absolute -top-1 -right-1" />
                                <div class="bg-orange-600 size-3 rounded-full animate-ping -z-0 absolute -top-1 -right-1" />
                            </div> -->
                        </div>
                    </div>
                    <EmptyState v-if="notifications.filter(n => !n.read_at).length == 0" title="No Notifications" subtitle="Yay! Nothing to report here. Feel free to explore elsewhere dear wanderer" type="info" />
                </TabsContent>
                <TabsContent value="history" class="space-y-4">
                    <div class="grid grid-cols-12 gap-2">
                        <div v-for="notification in notifications.filter(n => n.read_at)" :key="notification.id" class="col-span-12 md:col-span-7 rounded border bg-gray-50 dark:bg-muted/60">
                            <div class="border-l-4 p-4 rounded" :class="notification.data.message_type == 'success' ?'border-lime-500' : 'border-rose-600'">
                                <div class="flex items-center gap-3">
                                    <img :src="notification.data.actor_profile" class="size-10 rounded-full" alt="Actor Image">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-white">{{ notification.data.actor_name }}</h4>
                                        <p class="text-gray-500 text-xs">{{ dayjs(notification.created_at).fromNow() }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-gray-800 dark:text-gray-300">{{ notification.data.message }}</p>
                                </div>
                                <div class="mt-4 p-3 rounded border bg-gray-200 dark:bg-muted/70" v-if="notification.data.message_type == 'exception'">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-300">{{ notification.data.exception_message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <EmptyState v-if="notifications.filter(n => n.read_at).length == 0" title="No Notifications" subtitle="Yay! Nothing to report here. Feel free to explore elsewhere dear wanderer" type="info" />
                </TabsContent>
            </Tabs>
        </div>
    </div>
</template>