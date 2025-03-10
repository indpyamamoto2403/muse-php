<script setup lang="ts">
import { ImageQuestionRecord } from '@/Types/ImageQuestionRecord';
const props = defineProps<{ 
    currentRecord: ImageQuestionRecord
 }>();
console.log(props.currentRecord);
</script>
<template>
    <div class="description-container mb-6 p-4 bg-gray-50 rounded border border-gray-200">
        <h3 class="text-lg font-medium mb-2">説明</h3>
        <p class="text-gray-700">{{ currentRecord?.description }}</p>
        <div class="instruction mt-4 font-medium text-center text-blue-600">
        下の2枚の画像から、あなたの好きな方を選んでください
        </div>
    </div>
</template>