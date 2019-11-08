<template>
    <layout :title="`${url.short_url}`">
        <div class="mb-8 flex justify-start max-w-lg">
            <h1 class="font-bold text-3xl">
                <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('urls')">URLs</inertia-link>
                <span class="text-indigo-light font-medium">/</span>
                {{ url.short_url }}
            </h1>
        </div>
        <div class="bg-white rounded shadow overflow-hidden max-w-lg">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <text-input v-model="form.url_code" :errors="$page.errors.url_code" class="pr-6 pb-8 w-full lg:w-1/1" label="Short Code" />
                    <textarea-input v-model="form.long_url" :errors="$page.errors.long_url" class="pr-6 pb-8 w-full lg:w-1/1" label="Long URL" rows="8"/>
                </div>
                <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex items-center">
                    <button v-if="!url.deleted_at" class="text-red hover:underline" tabindex="-1" type="button" @click="destroy">Delete URL</button>
                    <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Update URL</loading-button>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
    import Layout from '@/Shared/Layout'
    import LoadingButton from '@/Shared/LoadingButton'
    import SelectInput from '@/Shared/SelectInput'
    import TextInput from '@/Shared/TextInput'
    import TextareaInput from '@/Shared/TextareaInput'
    import FileInput from '@/Shared/FileInput'
    import TrashedMessage from '@/Shared/TrashedMessage'

    export default {
        components: {
            Layout,
            LoadingButton,
            SelectInput,
            TextInput,
            TextareaInput,
            FileInput,
            TrashedMessage,
        },
        props: {
            url: Object,
        },
        remember: 'form',
        data() {
            return {
                sending: false,
                form: {
                    url_code: this.url.url_code,
                    long_url: this.url.long_url,
                },
            }
        },
        methods: {
            submit() {
                this.sending = true;

                let data = new FormData();
                data.append('url_code', this.form.url_code);
                data.append('long_url', this.form.long_url);

                this.$inertia.post(this.route('urls.update', this.url.id), data)
                    .then(() => {
                        this.sending = false;
                    })
            },
            destroy() {
                if (confirm('Are you sure you want to delete this URL?')) {
                    this.$inertia.delete(this.route('urls.destroy', this.url.id))
                }
            },
            restore() {
                if (confirm('Are you sure you want to restore this URL?')) {
                    this.$inertia.put(this.route('urls.restore', this.url.id))
                }
            },
        },
    }
</script>
