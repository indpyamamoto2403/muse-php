<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// フォームの状態管理
const form = useForm({
    title: '',
    body: ''
});

// フォーム送信処理
const submit = () => {
    form.post(route('questions.store'), {
        onSuccess: () => {
            // 成功時の処理（リダイレクトなど）
        }
    });
};
</script>

<template>
    <Head title="質問を投稿" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h1 class="text-2xl font-bold mb-6 text-gray-800">質問を投稿</h1>
                        
                        <form @submit.prevent="submit">
                            <!-- タイトル入力 -->
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    タイトル
                                </label>
                                <input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="質問のタイトルを入力してください"
                                    required
                                />
                                <div v-if="form.errors.title" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.title }}
                                </div>
                            </div>
                            
                            <!-- 本文入力 -->
                            <div class="mb-6">
                                <label for="body" class="block text-sm font-medium text-gray-700 mb-1">
                                    質問の詳細
                                </label>
                                <textarea
                                    id="body"
                                    v-model="form.body"
                                    rows="6"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="質問の内容を詳しく記入してください"
                                    required
                                ></textarea>
                                <div v-if="form.errors.body" class="mt-1 text-sm text-red-600">
                                    {{ form.errors.body }}
                                </div>
                            </div>
                            
                            <!-- 送信ボタン -->
                            <div class="flex items-center justify-end">
                                <button
                                    type="button"
                                    class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    @click="$inertia.visit(route('questions.index'))"
                                >
                                    キャンセル
                                </button>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :disabled="form.processing"
                                >
                                    <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    質問を投稿
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>