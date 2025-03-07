<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

const props = defineProps<{
  questions: any[];
}>();

// Inertia の useForm を使ってフォームの状態を管理
const form = useForm({
  answers: {} as Record<number, number> // 質問IDに対して回答値を格納
});

// 質問リストに index を追加
const questionList = props.questions.map((question, index) => ({
  ...question,
  index: index + 1
}));

// 現在表示している質問のインデックス
const currentIndex = ref(0);

// スライド方向を管理（左右のアニメーション用）
const slideDirection = ref('next');

// 質問切り替えのアニメーション完了フラグ
const isTransitioning = ref(false);

// 現在の質問データ
const currentQuestion = computed(() => questionList[currentIndex.value]);

// 次の質問へ移動
function nextQuestion() {
  if (currentIndex.value < questionList.length - 1 && !isTransitioning.value) {
    slideDirection.value = 'next';
    isTransitioning.value = true;
    setTimeout(() => {
      currentIndex.value++;
      isTransitioning.value = false;
    }, 300); // トランジションの持続時間と合わせる
  }
}

// 前の質問へ移動
function prevQuestion() {
  if (currentIndex.value > 0 && !isTransitioning.value) {
    slideDirection.value = 'prev';
    isTransitioning.value = true;
    setTimeout(() => {
      currentIndex.value--;
      isTransitioning.value = false;
    }, 300); // トランジションの持続時間と合わせる
  }
}

// 特定の質問へ移動
function goToQuestion(index: number) {
  if (index === currentIndex.value || isTransitioning.value) return;
  
  slideDirection.value = index > currentIndex.value ? 'next' : 'prev';
  isTransitioning.value = true;
  setTimeout(() => {
    currentIndex.value = index;
    isTransitioning.value = false;
  }, 300); // トランジションの持続時間と合わせる
}

// 進捗状況を計算（％）
function getProgress() {
  // 回答済みの質問数を数える
  const answeredCount = Object.keys(form.answers).length;
  return Math.round((answeredCount / questionList.length) * 100);
}

// すべての質問に回答したかどうか
const allQuestionsAnswered = computed(() => {
  return Object.keys(form.answers).length >= questionList.length;
});

// フォーム送信
function submitAnswers() {
  const payload = Object.entries(form.answers).map(([questionId, answerId]) => ({
    question_id: Number(questionId), 
    answer_id: answerId,
  }));

  console.log(payload);

  axios.post(route('chat.answer'), payload)
    .then(() => {
      alert('回答を受け付けました');
    })
    .catch(() => {
      alert('回答の送信に失敗しました');
    });
}

function refreshPage() {
  location.reload();
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between w-full">
        <div>AIQuestions</div>

      </div>
    </template>
    <div class="flex items-center">
          <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-2">
            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500 ease-out" :style="{ width: `${getProgress()}%` }"></div>
          </div>
          <div class="text-sm text-white">{{ getProgress() }}%</div>
        </div>
    <div class="w-full py-8 px-4">
      <!-- カルーセルナビゲーション -->
      <div class="mb-6 flex justify-center">
        <div class="flex space-x-2">
          <button
            v-for="(_, index) in questionList"
            :key="index"
            @click="goToQuestion(index)"
            :class="[
              'w-3 h-3 rounded-full transition-all duration-200',
              currentIndex === index ? 'bg-blue-500 scale-125' : 'bg-gray-300',
              form.answers[questionList[index].id] !== undefined ? 'ring-2 ring-blue-300' : ''
            ]"
          ></button>
        </div>
      </div>

      <form @submit.prevent="submitAnswers" class="max-w-2xl mx-auto">
        <div class="relative overflow-hidden" style="min-height: 320px;">
          <div
            class="transition-all duration-300 ease-in-out absolute w-full"
            :class="{
              'translate-x-full opacity-0': isTransitioning && slideDirection === 'next',
              '-translate-x-full opacity-0': isTransitioning && slideDirection === 'prev',
              'translate-x-0 opacity-100': !isTransitioning
            }"
          >
            <div v-if="questionList.length > 0" class="bg-white shadow-md rounded-lg p-6 hover:shadow-xl transition-shadow">
              <div class="flex justify-between items-center mb-4">
                <p class="text-gray-600">質問 {{ currentIndex + 1 }}/{{ questionList.length }}</p>
                <p class="text-sm" :class="form.answers[currentQuestion.id] !== undefined ? 'text-green-500' : 'text-gray-400'">
                  {{ form.answers[currentQuestion.id] !== undefined ? '回答済み' : '未回答' }}
                </p>
              </div>
              
              <h2 class="text-xl font-semibold mb-4">{{ currentQuestion.title }}</h2>
              <p class="text-gray-600 mb-6">{{ currentQuestion.body }}</p>
              
              <div class="mt-4 flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4">
                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all duration-200 hover:bg-blue-50"
                  :class="form.answers[currentQuestion.id] === 1 ? 'bg-blue-100 border-blue-300 transform scale-105' : ''">
                  <input
                    type="radio"
                    v-model="form.answers[currentQuestion.id]"
                    :value="1"
                    class="mr-2"
                  />
                  はい
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all duration-200 hover:bg-blue-50"
                  :class="form.answers[currentQuestion.id] === -1 ? 'bg-blue-100 border-blue-300 transform scale-105' : ''">
                  <input
                    type="radio"
                    v-model="form.answers[currentQuestion.id]"
                    :value="-1"
                    class="mr-2"
                  />
                  いいえ
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all duration-200 hover:bg-blue-50"
                  :class="form.answers[currentQuestion.id] === 0 ? 'bg-blue-100 border-blue-300 transform scale-105' : ''">
                  <input
                    type="radio"
                    v-model="form.answers[currentQuestion.id]"
                    :value="0"
                    class="mr-2"
                  />
                  どちらでもない
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="flex justify-between mt-6">
          <button
            type="button"
            @click="prevQuestion"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded disabled:opacity-50 transition-all duration-200 hover:bg-gray-300"
            :disabled="currentIndex === 0 || isTransitioning"
          >
            前へ
          </button>
          
          <button
            type="button"
            @click="nextQuestion"
            class="px-4 py-2 bg-blue-500 text-white rounded disabled:opacity-50 transition-all duration-200 hover:bg-blue-600"
            :disabled="currentIndex === questionList.length - 1 || isTransitioning"
          >
            次へ
          </button>
        </div>
      </form>

      <div class="mt-8 text-center" v-if="!allQuestionsAnswered">
        <p class="text-gray-600">すべての質問に回答してください ({{ Object.keys(form.answers).length }}/{{ questionList.length }})</p>
      </div>
      
      <div class="mt-8 text-center" v-else>
        <button 
          type="button" 
          @click="submitAnswers" 
          class="px-6 py-3 bg-green-500 text-white font-bold rounded-lg shadow hover:bg-green-600 transition-all duration-200 transform hover:scale-105"
        >
          すべての回答を送信
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* 追加のアニメーション用スタイル */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.fade-enter-active {
  animation: fadeIn 0.3s;
}

.fade-leave-active {
  animation: fadeIn 0.3s reverse;
}
</style>