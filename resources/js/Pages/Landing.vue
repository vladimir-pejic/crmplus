<template>
    <div class="leading-normal tracking-normal text-gray-900" style="font-family: 'Source Sans Pro', sans-serif;">
        <div class="h-screen pb-14 bg-right bg-cover" style="background-image:url('bg1.jpg');">

            <!-- Header -->
            <landing-header />

            <!-- Service -->
            <div class="container pt-24 md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">

                <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden" style="background-image:url('shrtd-logo.png')">
                    <h1 class="my-4 text-3xl md:text-5xl text-blue-300 hover:text-purple-300 font-bold leading-tight text-center md:text-left slide-in-bottom">Shrtd!</h1>
                    <p class="leading-normal text-white text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-h1">Free and no fuss URL shortening service!</p>
                </div>

                <div class="w-full xl:w-3/5 py-6 overflow-y-hidden">
                    <!-- URL shortening -->
                    <div class="bg-transparent rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb-4" id="url_response">
                            <flash-messages />
                        </div>
                        <div class="mb-4">
                            <input class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline border-4 border-solid border-pink-600" type="text" v-model="form.long_url" placeholder="Enter your URL"/>
                        </div>
                        <div class="mb-4">
                            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none hover:cursor-pointer" type="submit" value="Submit" @click="submit"/>
                        </div>
                    </div>
                </div>

                <div class="w-full pt-16 pb-6 text-sm text-center md:text-left fade-in">
                    <a class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4" data-tippy-content="@twitter_handle" href="https://twitter.com/intent/tweet?url=#">
                        <svg class="fill-current h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M30.063 7.313c-.813 1.125-1.75 2.125-2.875 2.938v.75c0 1.563-.188 3.125-.688 4.625a15.088 15.088 0 0 1-2.063 4.438c-.875 1.438-2 2.688-3.25 3.813a15.015 15.015 0 0 1-4.625 2.563c-1.813.688-3.75 1-5.75 1-3.25 0-6.188-.875-8.875-2.625.438.063.875.125 1.375.125 2.688 0 5.063-.875 7.188-2.5-1.25 0-2.375-.375-3.375-1.125s-1.688-1.688-2.063-2.875c.438.063.813.125 1.125.125.5 0 1-.063 1.5-.25-1.313-.25-2.438-.938-3.313-1.938a5.673 5.673 0 0 1-1.313-3.688v-.063c.813.438 1.688.688 2.625.688a5.228 5.228 0 0 1-1.875-2c-.5-.875-.688-1.813-.688-2.75 0-1.063.25-2.063.75-2.938 1.438 1.75 3.188 3.188 5.25 4.25s4.313 1.688 6.688 1.813a5.579 5.579 0 0 1 1.5-5.438c1.125-1.125 2.5-1.688 4.125-1.688s3.063.625 4.188 1.813a11.48 11.48 0 0 0 3.688-1.375c-.438 1.375-1.313 2.438-2.563 3.188 1.125-.125 2.188-.438 3.313-.875z"></path></svg>
                    </a>
                    <a class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 " data-tippy-content="#facebook_id" href="https://www.facebook.com/sharer/sharer.php?u=#">
                        <svg class="fill-current h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M19 6h5V0h-5c-3.86 0-7 3.14-7 7v3H8v6h4v16h6V16h5l1-6h-6V7c0-.542.458-1 1-1z"></path></svg>
                    </a><br>
                    <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; shrtd.co 2019</a>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
    import LoadingButton from '@/Shared/LoadingButton'
    import Logo from '@/Shared/Logo'
    import TextInput from '@/Shared/TextInput'
    import LandingHeader from '@/Shared/LandingHeader'
    import FlashMessages from '@/Shared/FlashMessages'

    export default {
        components: {
            LoadingButton,
            Logo,
            TextInput,
            LandingHeader,
            FlashMessages
        },
        props: {
            errors: Object,
        },
        data() {
            return {
                sending: false,
                form: {
                    long_url: null,
                },
            }
        },
        mounted() {
            document.title = 'Shrtd'
        },
        methods: {
            submit() {
                this.sending = true;
                this.$inertia.post(this.route('shorten'), {
                    long_url: this.form.long_url
                }).then((res) => {
                    this.sending = false;
                });
            },
        },
    }
</script>
