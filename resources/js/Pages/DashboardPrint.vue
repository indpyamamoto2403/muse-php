<script setup lang="ts">
import { ref } from 'vue';
import ScoreChart from '@/Components/Organisms/Score/ScoreChart.vue';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

const props = defineProps({
  score: Object,
});

const chartImageUrl = ref('');
const scoreChartRef = ref(null);
const pdfContent = ref<HTMLElement | null>(null);

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


async function generatePDF() {
  try {
    // create canvas
    const canvas = await html2canvas(pdfContent.value);
    // generate pdf
    const pdf = new jsPDF('p', 'mm', 'a4');
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const imgProps = pdf.getImageProperties(canvas);
    // to maintain aspect ratio
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

    pdf.addImage(canvas, 'PNG', 0, 0, pdfWidth, pdfHeight, '', 'FAST');
    const pdfBlob = pdf.output('blob');
    const blobUrl = URL.createObjectURL(pdfBlob);
    window.open(blobUrl, '_blank');
    
  } catch (error) {
    console.error('PDF生成エラー:', error);
    alert('PDFの生成に失敗しました');
  }
}
</script>

<template>
  <div>
    <!-- PDFに含めるコンテンツ全体を囲む要素に ref="pdfContent" を追加 -->
    <div ref="pdfContent" class="px-[260px] pt-[220px]">
      <div class="grid grid-cols-1 gap-6 md:grid-cols-1">
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
        <div class="max-h-[400px] max-w-[350px] mx-auto">
          <ScoreChart ref="scoreChartRef" :datasets="sampleScoreData"/>
        </div>
      </div>
    </div>

    <!-- PDF生成用のボタン -->
    <div class="mt-4 print:hidden px-[260px] py-[40px]">
      <button @click="generatePDF" class="px-4 py-2 font-bold text-white bg-indigo-600 rounded hover:bg-indigo-700">
        PDF
      </button>
    </div>
  </div>
</template>
