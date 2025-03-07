<template>
  <div class="mb-4 flex justify-center">
    <div class="flex space-x-1">
      <QuestionNavigationButton
        v-for="(_, index) in questionList"
        :key="index"
        @click="goToQuestion(index)"
        :isActive="currentIndex === index"
        :isAnswered="form.answers[questionList[index].id] !== undefined"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import QuestionNavigationButton from '@/Components/Atoms/QuestionNavigationButton.vue';

const props = defineProps<{
  questionList: any[];
  currentIndex: number;
  form: any;
}>();

const emit = defineEmits(['goToQuestion']);

function goToQuestion(index: number) {
  emit('goToQuestion', index);
}
</script>
