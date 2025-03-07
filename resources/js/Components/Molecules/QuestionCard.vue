<template>
  <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-xl transition-shadow min-h-64">
    <div class="flex justify-between items-center mb-4">
      <p class="text-gray-600">質問 {{ currentIndex + 1 }}/{{ questionList.length }}</p>
      <p class="text-sm text-gray-500">
        {{ form.answers[questionList[currentIndex].id] !== undefined ? '回答済み' : '未回答' }}
      </p>
    </div>
    
    <h2 class="text-xl font-semibold mb-4">{{ questionList[currentIndex].title }}</h2>
    <p class="text-gray-600 mb-6">{{ questionList[currentIndex].body }}</p>
    
    <div class="mt-4 flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4">
      <RadioButton
        v-for="option in options"
        :key="option.value"
        v-model="form.answers[questionList[currentIndex].id]"
        :value="option.value"
        :isSelected="form.answers[questionList[currentIndex].id] === option.value"
      >
        {{ option.label }}
      </RadioButton>
    </div>
  </div>
</template>

<script setup lang="ts">
export default {
  name: 'QuestionCard'
};
import RadioButton from '@/Components/Atoms/RadioButton.vue';

const props = defineProps<{
  questionList: any[];
  currentIndex: number;
  form: any;
}>();

const options = [
  { value: 1, label: 'はい' },
  { value: -1, label: 'いいえ' },
  { value: 0, label: 'どちらでもない' }
];
</script>
