<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Muse" />
    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 text-black/70 dark:from-gray-900 dark:via-indigo-950 dark:to-purple-950 dark:text-white/70">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-purple-500 selection:text-white"
        >
            <!-- Decorative elements -->
            <div class="absolute inset-0 overflow-hidden opacity-20">
                <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-purple-400 blur-3xl"></div>
                <div class="absolute top-1/4 left-1/4 h-80 w-80 rounded-full bg-pink-400 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-blue-400 blur-3xl"></div>
                <div class="absolute bottom-1/4 right-1/4 h-80 w-80 rounded-full bg-indigo-400 blur-3xl"></div>
            </div>
            
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-6 lg:grid-cols-2"
                >
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-purple-600 dark:text-purple-400">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.688h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
                            <circle cx="7.5" cy="11.5" r="1.5"></circle>
                            <circle cx="12" cy="8" r="1.5"></circle>
                            <circle cx="16.5" cy="11.5" r="1.5"></circle>
                        </svg>
                        <span class="text-xl font-bold text-purple-700 dark:text-purple-400">Muse</span>
                    </div>
                    
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end gap-6">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-4 py-2 text-black ring-1 ring-purple-500/20 shadow-sm transition-all duration-300 hover:shadow-md hover:ring-purple-500 hover:bg-purple-500/5 focus:outline-none dark:text-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-4 py-2 text-black ring-1 ring-purple-500/20 shadow-sm transition-all duration-300 hover:shadow-md hover:ring-purple-500 hover:bg-purple-500/5 focus:outline-none dark:text-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-sm transition-all duration-300 hover:shadow-md hover:from-purple-700 hover:to-pink-600 focus:outline-none"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6 mb-16">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <div class="flex flex-col justify-center space-y-6">
                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                <span class="block">Discover Art</span>
                                <span class="block text-purple-600 dark:text-purple-400">Powered by AI</span>
                            </h1>
                            <p class="text-xl text-gray-700 dark:text-gray-300">
                                AIがあなたにパーソナライズされた芸術作品をお届けし、デザイナーとのマッチングを促進するプラットフォームを提供します
                            </p>
                            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                                <Link
                                    href="#features"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 px-5 py-3 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                >
                                    作品を探す
                                </Link>
                                <Link
                                    href="#how-it-works"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-white px-5 py-3 text-base font-medium text-purple-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-purple-400 dark:hover:bg-gray-700"
                                >
                                    詳細を見る
                                </Link>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="relative h-64 w-64 sm:h-80 sm:w-80 md:h-96 md:w-96">
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 opacity-20 blur-2xl"></div>
                                <div class="absolute inset-4 rounded-xl bg-gradient-to-br from-white via-white to-white/70 p-6 shadow-2xl dark:from-gray-800 dark:via-gray-800 dark:to-gray-800/70">
                                    <div class="grid h-full grid-cols-2 grid-rows-2 gap-4">
                                        <div class="rounded-lg bg-gradient-to-br from-purple-200 to-indigo-200 dark:from-purple-900/50 dark:to-indigo-900/50"></div>
                                        <div class="rounded-lg bg-gradient-to-br from-pink-200 to-purple-200 dark:from-pink-900/50 dark:to-purple-900/50"></div>
                                        <div class="rounded-lg bg-gradient-to-br from-blue-200 to-indigo-200 dark:from-blue-900/50 dark:to-indigo-900/50"></div>
                                        <div class="rounded-lg bg-gradient-to-br from-indigo-200 to-purple-200 dark:from-indigo-900/50 dark:to-purple-900/50"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="features" class="mt-20">
                        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                            プラットフォームの特徴
                        </h2>
                        <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-purple-600 dark:text-purple-400">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m14.31 8 5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16 3.95 6.06M14.31 16H2.83M16.62 12l-5.74 9.94"></path>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-medium text-gray-900 dark:text-white">AIによる創作</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    あなたの好みや要望に基づいて、AIが独自のアルゴリズムで芸術作品を提供します。
                                </p>
                            </div>
                            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-purple-600 dark:text-purple-400">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-medium text-gray-900 dark:text-white">デザイナーマッチング</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    あなたの好みに合った実際のアーティストやデザイナーとつながることができます。
                                </p>
                            </div>
                            <div class="rounded-xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800">
                                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-purple-600 dark:text-purple-400">
                                        <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                        <line x1="2" x2="22" y1="10" y2="10"></line>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-medium text-gray-900 dark:text-white">作品購入</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    気に入った作品は直接購入して、あなたのコレクションに加えることができます。
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="how-it-works" class="mt-20">
                        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white">
                            利用の流れ
                        </h2>
                        <div class="mt-12 flex flex-col items-center">
                            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                                <li class="mb-10 ml-6">
                                    <div class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-purple-600 dark:bg-purple-500">
                                        <span class="text-white">1</span>
                                    </div>
                                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">アカウント作成</h3>
                                    <p class="text-gray-600 dark:text-gray-400">数ステップで簡単に登録できます。あなたの芸術的好みについて教えてください。</p>
                                </li>
                                <li class="mb-10 ml-6">
                                    <div class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-purple-600 dark:bg-purple-500">
                                        <span class="text-white">2</span>
                                    </div>
                                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">AIが作品を提供します</h3>
                                    <p class="text-gray-600 dark:text-gray-400">あなたの好みに基づいて、AIが独自のアルゴリズムで芸術作品を提供します。</p>
                                </li>
                                <li class="ml-6">
                                    <div class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-purple-600 dark:bg-purple-500">
                                        <span class="text-white">3</span>
                                    </div>
                                    <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">アーティストとつながる</h3>
                                    <p class="text-gray-600 dark:text-gray-400">気に入った作風があれば、その作風に近い実際のアーティストを紹介します。</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                </main>

                <footer class="border-t border-gray-200 py-6 dark:border-gray-700">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-purple-600 dark:text-purple-400">
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.688h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
                                <circle cx="7.5" cy="11.5" r="1.5"></circle>
                                <circle cx="12" cy="8" r="1.5"></circle>
                                <circle cx="16.5" cy="11.5" r="1.5"></circle>
                            </svg>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Muse © 2025</span>
                        </div>
                        <div class="flex gap-4">
                            <a href="#" class="text-sm text-gray-600 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400">利用規約</a>
                            <a href="#" class="text-sm text-gray-600 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400">プライバシーポリシー</a>
                            <a href="#" class="text-sm text-gray-600 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400">お問い合わせ</a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>