<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import Chart from 'chart.js/auto';
import { createRadarChartConfig } from '@/Pages/Chat/Chart.config';

interface Dataset {
  label: string;
  value: number;
}

const props = defineProps<{
  datasets: Dataset[]
}>();

const chartCanvas = ref<HTMLCanvasElement | null>(null);
const chartInstance = ref<Chart | null>(null); // Chartインスタンスを保持

const emit = defineEmits(['chart-rendered']);


onMounted(() => {
  renderChart();
});

// props.datasets の変更を監視
watch(() => props.datasets, (newDatasets) => {
    updateChart(newDatasets);
}, { deep: true });


// ScoreChart.vue
const renderChart = () => {
  if (chartCanvas.value) {
    chartInstance.value = new Chart(chartCanvas.value, createRadarChartConfig(props.datasets));
    // レンダリング後にデータURLをemit
    const dataUrl = chartCanvas.value.toDataURL();
    setTimeout(() => {
      emit('chart-rendered', dataUrl);
    }, 2000);
  }
};

const updateChart = (newDatasets: Dataset[]) => {
    if (chartInstance.value && chartCanvas.value) {
        // chart.jsのデータを更新
        chartInstance.value.data = createRadarChartConfig(newDatasets).data;
        chartInstance.value.update();
        const dataUrl = chartCanvas.value.toDataURL();
        emit('chart-rendered', dataUrl);

    }
};

</script>

<template>
  <div class="chart-container">
    <canvas ref="chartCanvas" class="block"></canvas>
  </div>
</template>

<style scoped>
.chart-container {
  @apply mt-8 w-full mx-auto flex items-center justify-center;
  position: relative;
  height: 400px; /* キャンバスの高さを指定 */
}
</style>