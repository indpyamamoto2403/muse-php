<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 pt-6 sm:justify-center sm:pt-0 dark:from-gray-900 dark:via-indigo-950 dark:to-purple-950 dark:text-white/70"
    >
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden opacity-20 z-0">
            <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-purple-400 blur-3xl"></div>
            <div class="absolute top-1/4 left-1/4 h-80 w-80 rounded-full bg-pink-400 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-blue-400 blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 h-80 w-80 rounded-full bg-indigo-400 blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-purple-600 dark:text-purple-400" />
            </Link>
        </div>

        <div
            class="relative z-10 mt-6 w-full overflow-hidden bg-white/90 backdrop-blur-sm px-6 py-4 shadow-lg border border-purple-100 sm:max-w-md sm:rounded-xl dark:bg-gray-800/90 dark:border-purple-900/30"
        >
            <slot />
        </div>

        <!-- Optional brand text below the form -->
        <div class="relative z-10 mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>ArtisanAI — パーソナライズされた芸術体験</p>
        </div>
    </div>
</template>