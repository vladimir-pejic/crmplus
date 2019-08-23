<template>
    <div class="w-full container mx-auto p-6">
        <div class="w-full flex items-center justify-between">
            <a :href="route('home')" class="flex items-center text-white hover:text-purple-300 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" style="cursor: pointer;">
                <img src="logo-white.png" width="50" />Shrtd!
            </a>
            <div class="flex w-1/2 justify-end content-center" v-if="!$page.auth.user">
                <span class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 ">
                    <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-yellow-400" :href="route('login')">Login</inertia-link>
                </span>
                <span class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 ">
                    <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-yellow-400" :href="route('register')">Register</inertia-link>
                </span>
            </div>
            <div class="flex w-1/2 justify-end content-center" v-else>
                <span class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 ">
                    <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-yellow-400" :href="route('dashboard')">Welcome, {{ $page.auth.user.first_name }}!</inertia-link>
                </span>
                <span class="inline-block text-white no-underline hover:text-yellow-400 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4">
                    <inertia-link class="block px-6 py-2 hover:bg-indigo hover:text-yellow-400" :href="route('logout')" method="post">Logout</inertia-link>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>