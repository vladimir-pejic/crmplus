<template>
    <layout title="URLs">
        <h1 class="mb-8 font-bold text-3xl">URLs</h1>
        <div class="mb-6 flex justify-between items-center">
            <search-filter v-model="form.search" class="w-full max-w-sm mr-4" @reset="reset" />
            <inertia-link class="btn-indigo" :href="route('urls.create')">
                <span>Create</span>
                <span class="hidden md:inline">Urls</span>
            </inertia-link>
        </div>
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full whitespace-normal">
                <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Short URL</th>
                    <th class="px-6 pt-6 pb-4">Clicks</th>
                    <th class="px-6 pt-6 pb-4">Long URL</th>
                </tr>
                <tr v-for="url in urls.data" :key="url.id" class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center focus:text-indigo" :href="route('urls.edit', url.id)">
                            {{ url.short_url }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('urls.edit', url.id)" tabindex="-1">
                            {{ url.clicks }}
                        </inertia-link>
                    </td>
                    <td class="border-t">
                        <inertia-link class="px-6 py-4 flex items-center" :href="route('urls.edit', url.id)" tabindex="-1">
                            {{ url.long_url }}
                        </inertia-link>
                    </td>
                    <td class="border-t w-px">
                        <inertia-link class="px-4 flex items-center" :href="route('urls.edit', url.id)" tabindex="-1">
                            <icon name="cheveron-right" class="block w-6 h-6 fill-grey" />
                        </inertia-link>
                    </td>
                </tr>
                <tr v-if="urls.data.length === 0">
                    <td class="border-t px-6 py-4" colspan="4">No organizations found.</td>
                </tr>
            </table>
        </div>
        <pagination :links="urls.links" />
    </layout>
</template>

<script>
    import _ from 'lodash'
    import Icon from '@/Shared/Icon'
    import Layout from '@/Shared/Layout'
    import Pagination from '@/Shared/Pagination'
    import SearchFilter from '@/Shared/SearchFilter'

    export default {
        components: {
            Icon,
            Layout,
            Pagination,
            SearchFilter,
        },
        props: {
            urls: Object,
            filters: Object,
        },
        data() {
            return {
                form: {
                    search: this.filters.search,
                },
            }
        },
        watch: {
            form: {
                handler: _.throttle(function() {
                    let query = _.pickBy(this.form)
                    this.$inertia.replace(this.route('organizations', Object.keys(query).length ? query : { remember: 'forget' }))
                }, 150),
                deep: true,
            },
        },
        methods: {
            reset() {
                this.form = _.mapValues(this.form, () => null)
            },
        },
    }
</script>
