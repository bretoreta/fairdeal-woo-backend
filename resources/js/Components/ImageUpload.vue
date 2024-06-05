<script setup>
import { ref } from 'vue';
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import { router, usePage } from '@inertiajs/vue3';

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const props = defineProps({
    allowMultiple: {
        type: Boolean,
        default: false,
    }
})

const image = ref(null);
const emit = defineEmits(['done', 'revert']);
const csrfToken = usePage().props.csrf_token;

const handleFilePondOnLoad = (res) => {
    emit('done', res);
    return res;
}

const handleFilePondRevert = (uniqueId, load, error) => {
    const uuid = JSON.parse(uniqueId);
    try {
        router.delete(route('web.images.delete', uuid), {
            preserveScroll: true,
            onSuccess: () => {
                emit('revert', uuid);
                load()
            }
        })
    } catch (error) {
        
    }
}
</script>

<template>
    <file-pond name="image" ref="pond" v-bind:allow-multiple="allowMultiple" accepted-file-types="image/jpeg, image/png" :server="{
        url: '',
        process: {
            url: '/images/upload',
            method: 'POST',
            withCredentials: true,
            onload: handleFilePondOnLoad,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        },
        revert: handleFilePondRevert
    }" v-bind:files="image" required />
</template>