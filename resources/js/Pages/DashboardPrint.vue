<template>
  <div>
    <h1>Dashboard Print Page</h1>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <!-- スコア概要 -->
      <div class="p-5 bg-gray-50 rounded-lg">
        <h4 class="mb-3 text-base font-semibold text-indigo-700">スコアリング評価結果</h4>
        <p class="mb-4 text-sm text-gray-600">
          このスコアはあなたの芸術作品の特徴を評価したもので。<br>
          各項目のスコアが高いほど、<br>
          その特徴が強調されています。
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
        <!-- 通常時: ScoreChart (canvas) を表示、印刷時は非表示 -->
          <ScoreChart ref="scoreChartRef" :datasets="sampleScoreData" @chart-rendered="onChartRendered"  />
        <!-- 印刷時/canvas非対応ブラウザ用:  URL の画像を表示 -->


          <img
            :src="chartImageUrl"
            alt="スコアチャート"
            class="h-[800px] w-[800px] object-cover"
          />
        </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref, watchEffect, onMounted } from 'vue';
import ScoreChart from '@/Components/Organisms/Score/ScoreChart.vue';

const props = defineProps({
  score: Object,
});

const chartImageUrl = ref(''); //  データURLを保持
const scoreChartRef = ref(null);

const sampleScoreData = ref([
  { label: 'スタイル', value: props.score?.style ?? 3 },
  { label: '伝統と革新', value: props.score?.tradition_innovation ?? 3 },
  { label: '内省と感情', value: props.score?.introspective_emotional ?? 3 },
  { label: '色彩感覚', value: props.score?.color_sense ?? 3 },
  { label: '構図', value: props.score?.composition ?? 3 },
  { label: '技術', value: props.score?.technique ?? 3 },
  { label: 'テーマ', value: props.score?.theme ?? 3 },
  { label: 'エネルギー', value: props.score?.energy ?? 3 },
  { label: '独自性', value: props.score?.uniqueness ?? 3 },
]);


function onChartRendered(dataURL: string) {
  console.log('onChartRendered', dataURL);
  //chartImageUrl.value = dataURL;
  chartImageUrl.value = dataURL;
}

// props.score が変更されたときに sampleScoreData を更新
watchEffect(() => {
  if (props.score) {
    sampleScoreData.value = [
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
    chartImageUrl.value = ''; // データ更新時に画像をクリア
  }
});

</script>