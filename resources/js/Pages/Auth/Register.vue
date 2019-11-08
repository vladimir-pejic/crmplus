<template>
    <div class="bg-indigo-darker min-h-screen justify-center items-center">
        <landing-header />
        <div class="container mx-auto flex-col md:flex-row items-center w-full max-w-sm">
            <form class="mt-8 w-full bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
                <div class="px-10 py-12">
                    <h1 class="text-center font-bold text-3xl">Register Account</h1>
                    <div class="mx-auto mt-6 w-24 border-b-2" />
                    <div class="flex mx-auto">
                        <div class="w-1/2 mr-4 w-auto">
                            <text-input v-model="form.organization" :errors="$page.errors.organization" class="mt-6" label="Organization Name" type="text" autofocus autocapitalize="off" />
                            <text-input v-model="form.first_name" :errors="$page.errors.first_name" class="mt-6" label="First Name" type="text" autofocus autocapitalize="off" />
                            <text-input v-model="form.password" :errors="$page.errors.password" class="mt-6" label="Password" type="password" />
                        </div>
                        <div class="w-1/2 w-auto">
                            <text-input v-model="form.email" :errors="$page.errors.email" label="Email" class="mt-6" type="email" autofocus autocapitalize="off" />
                            <text-input v-model="form.last_name" :errors="$page.errors.last_name" class="mt-6" label="Last Name" type="text" autofocus autocapitalize="off" />
                            <text-input v-model="form.password_confirmation" class="mt-6" label="Confirm Password" type="password" />
                        </div>
                    </div>
                </div>
                <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-between items-center">
                    <a class="hover:underline" tabindex="-1" href="/login">Already registered?</a>
                    <loading-button :loading="sending" class="btn-indigo" type="submit">Register</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import LoadingButton from '@/Shared/LoadingButton'
    import Logo from '@/Shared/Logo'
    import TextInput from '@/Shared/TextInput'
    import LandingHeader from '@/Shared/LandingHeader'

    export default {
        components: {
            LoadingButton,
            Logo,
            TextInput,
            LandingHeader
        },
        props: {
            errors: Object,
        },
        data() {
            return {
                sending: false,
                form: {
                    organization: null,
                    email: null,
                    first_name: null,
                    last_name: null,
                    password: null,
                    confirm_password: null,
                },
            }
        },
        mounted() {
            document.title = 'Login | ' + this.$page.platform;
        },
        methods: {
            submit() {
                this.sending = true;
                this.$inertia.post(this.route('register.attempt'), {
                    organization: this.form.organization,
                    email: this.form.email,
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation
                }).then(() => this.sending = false)
            },
        },
    }
</script>
