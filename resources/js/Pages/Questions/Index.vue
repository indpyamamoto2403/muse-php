<script setup lang="ts">
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    questions: {
        id: number;
        title: string;
        body: string;
        created_at?: string;
        user?: {
            name: string;
            avatar?: string;
        };
        tags?: string[];
    }[];
}>();

const searchQuery = ref('');

const filteredQuestions = computed(() => {
    if (!searchQuery.value) return props.questions;
    
    const query = searchQuery.value.toLowerCase();
    return props.questions.filter(question => 
        question.title.toLowerCase().includes(query) || 
        question.body.toLowerCase().includes(query)
    );
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            Question list
        </template>
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- ヘッダーセクション -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-200">質問一覧</h1>
                    <p class="mt-2 text-sm text-slate-300">コミュニティの質問を探索しましょう</p>
                </div>
                
                <div class="flex space-x-4">
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="質問を検索..."
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        />
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <Link
                        :href="route('question.register')"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        質問を投稿
                    </Link>
                </div>
            </div>
            
            <!-- 質問がない場合 -->
            <div v-if="filteredQuestions.length === 0" class="bg-white shadow rounded-lg p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">質問が見つかりません</h3>

            </div>
            
            <!-- 質問一覧 -->
            <div v-else class="space-y-4">
                <div
                    v-for="question in filteredQuestions"
                    :key="question.id"
                    class="bg-white shadow overflow-hidden rounded-lg hover:shadow-md transition-shadow duration-200"
                >
                        <div class="px-6 py-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 hover:text-indigo-600">
                                        {{ question.title }}
                                    </h2>
                                    
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                        {{ question.body }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                
                                <div v-if="question.created_at" class="text-sm text-gray-500">
                                    {{ new Date(question.created_at).toLocaleDateString('ja-JP') }}
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>