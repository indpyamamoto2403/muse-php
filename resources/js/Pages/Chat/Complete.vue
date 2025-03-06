<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Score } from '@/Types/Evaluation';
import ScoreChart from '@/Components/Organisms/Score/ScoreChart.vue';

const props = defineProps<{ score: Score }>();

interface Dataset {
  label: string;
  value: number;
}

const datasets: Dataset[] = [
  { label: 'スタイル', value: props.score.style },
  { label: '伝統と革新', value: props.score.tradition_innovation },
  { label: '内省と感情', value: props.score.introspective_emotional },
  { label: '色彩感覚', value: props.score.color_sense },
  { label: '構図', value: props.score.composition },
  { label: '技術', value: props.score.technique },
  { label: 'テーマ', value: props.score.theme },
  { label: 'エネルギー', value: props.score.energy },
  { label: '独自性', value: props.score.uniqueness },
];
</script>

<template>
  <AuthenticatedLayout>
    <div class="container">
      <div class="card">
        <h2 class="title">スコアリング評価結果</h2>
        <p class="description">
          <span class="font-bold">おめでとうございます！<br /></span>
          以下のスコアは、あなたの芸術作品に対する評価です。スコアは、<br/>
          あなたの作品の特徴を表しています。スコアが高ければ高いほど、<br/>
          その特徴が強調されています。このスコアは、あなたに合う作品が<br/>
          どのようなものかを知るためのデータとして使用されます。
        </p>
        <div class="score-grid">
          <div v-for="dataset in datasets" :key="dataset.label">
            <span class="label">{{ dataset.label }}</span>：
            <span class="value">{{ dataset.value }}</span>
          </div>
        </div>
        
        <!-- 外部コンポーネントとしてのチャート -->
        <ScoreChart :datasets="datasets" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.container {
  @apply min-h-screen text-white flex items-center justify-center p-6;
}

.card {
  @apply bg-white bg-opacity-10 rounded-xl shadow-xl p-8 max-w-3xl w-full mb-10;
}

.title {
  @apply text-6xl font-extrabold tracking-tight text-yellow-400 mb-8 text-center;
}

.description {
  @apply text-black text-xl leading-relaxed mb-8 text-center;
}

.score-grid {
  @apply bg-gray-700 bg-opacity-75 rounded-lg shadow-md p-6 grid grid-cols-2 gap-y-4 gap-x-8 max-w-md mx-auto text-left mb-8;
}

.label {
  @apply font-semibold;
}

.value {
  @apply text-yellow-400 text-lg font-bold;
}
</style>