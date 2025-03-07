<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { createRadarChartConfig } from '@/Pages/Chat/Chart.config';
import { onMounted, ref } from 'vue';
import ScoreChart from '@/Components/Organisms/Score/ScoreChart.vue';
import { Score } from '@/Types/Evaluation';

const props = defineProps<{ score: Score }>();

interface Dataset {
  label: string;
  value: number;
}
// サンプルデータ（実際の実装では props として渡すか、API から取得するデータを使用します）
const sampleScoreData:Dataset[] = [
  { label: 'スタイル', value: props.score?.style ?? 3 },
  { label: '伝統と革新', value: props.score?.tradition_innovation ?? 3 },
  { label: '内省と感情', value: props.score?.introspective_emotional ?? 3 },
  { label: '色彩感覚', value: props.score?.color_sense ?? 3 },
  { label: '構図', value: props.score?.composition ?? 3 },
  { label: '技術', value: props.score?.technique ?? 3 },
  { label: 'テーマ', value: props.score?.theme ?? 3 },
  { label: 'エネルギー', value: props.score?.energy ?? 3 },
  { label: '独自性', value: props.score?.uniqueness ?? 3 },
];

const goToPrintPage = () => {
  window.location.href = '/dashboard/print';
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg min-h-[500px]">
                    <div class="p-6 text-gray-900">
                        
                        <h3 class="mb-4 text-lg font-medium">
                            あなたのスコア評価
                        </h3>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- スコア概要 -->
                            <div class="p-5 bg-gray-50 rounded-lg">
                                <h4 class="mb-3 text-base font-semibold text-indigo-700">スコアリング評価結果</h4>
                                <p class="mb-4 text-sm text-gray-600">
                                    このスコアはあなたの芸術作品の特徴を評価したものです。各項目のスコアが高いほど、その特徴が強調されています。
                                </p>
                                
                                <div class="grid grid-cols-2 gap-2 p-4 bg-white rounded-md shadow-sm">
                                    <div v-for="item in sampleScoreData" :key="item.label" class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-600">{{ item.label }}:</span>
                                        <span class="text-sm font-bold text-indigo-600">{{ item.value }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- チャート -->
                            <div class="h-80">
                                <ScoreChart :datasets="sampleScoreData" />
                            </div>
                        </div>
                        <div class="flex justify-between w-[580px] h-[40px]">
                            <button @click="goToPrintPage" class=
                            "
                            mt-4 
                            px-4 
                            py-2 
                            h-full
                            bg-blue-500
                            text-white 
                            rounded 
                            hover:cursor-pointer
                            hover:bg-blue-600"
                             >印刷</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
