<script setup lang="ts">
import QuestionCard from '@/Components/Molecules/QuestionCard.vue';
import PrimaryButton from '@/Components/Atoms/PrimaryButton.vue';

const props = defineProps<{
  questionList: any[];
  currentIndex: number;
  form: any;
}>();

const emit = defineEmits(['submitAnswers', 'prevQuestion', 'nextQuestion']);

function submitAnswers() {
  emit('submitAnswers');
}

function prevQuestion() {
  emit('prevQuestion');
}

function nextQuestion() {
  emit('nextQuestion');
}
</script>

<template>
  <form @submit.prevent="submitAnswers" class="max-w-2xl mx-auto">
    <QuestionCard
      v-if="questionList.length > 0"
      :questionList="questionList"
      :currentIndex="currentIndex"
      :form="form"
    />
    <div class="flex justify-between mt-6">
      <PrimaryButton
        type="button"
        @click="prevQuestion"
        :isDisabled="currentIndex === 0"
      >
        前へ
      </PrimaryButton>
      
      <div>
        <PrimaryButton
          v-if="currentIndex === questionList.length - 1"
          type="submit"
          :isDisabled="Object.keys(form.answers).length < questionList.length"
        >
          回答を送信
        </PrimaryButton>
      </div>
      
      <PrimaryButton
        type="button"
        @click="nextQuestion"
        :isDisabled="currentIndex === questionList.length - 1"
      >
        次へ
      </PrimaryButton>
    </div>
  </form>
</template>

