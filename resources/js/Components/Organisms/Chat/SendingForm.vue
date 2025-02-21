<script setup lang="ts">
import { ref } from 'vue';
const model = defineModel<string>();

// 録音状態を管理するリアクティブ変数
const isRecording = ref(false);

const emit = defineEmits<{
  (e: 'sendMessage', message: string): void;
}>();

const sendMessage = async () => {
  emit('sendMessage', model.value);
  model.value = '';
};

const startVoiceRecognition = () => {
  // ブラウザによっては webkitSpeechRecognition となるため対応
  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  if (!SpeechRecognition) {
    console.error('このブラウザは Speech Recognition API をサポートしていません。');
    return;
  }

  const recognition = new SpeechRecognition();
  recognition.lang = 'ja-JP'; // 日本語で認識
  recognition.interimResults = false; // 暫定結果は不要
  recognition.maxAlternatives = 1; // 最も高い信頼度の結果のみ

  recognition.onstart = () => {
    console.log('録音開始');
    isRecording.value = true;
  };

  recognition.onend = () => {
    console.log('録音終了');
    isRecording.value = false;
  };

  recognition.onresult = (event: SpeechRecognitionEvent) => {
    if (event.results.length > 0) {
      const transcript = event.results[0][0].transcript;
      model.value = transcript;
    }
  };

  recognition.onerror = (event) => {
    console.error('音声認識エラー:', event);
    isRecording.value = false;
  };

  recognition.start();
};
</script>

<template>
  <!-- 固定されたメッセージ入力エリア -->
  <div class="fixed bottom-0 left-0 left-64 right-0 w-full p-4 bg-gray-900 border-t border-gray-700 z-50 mx-auto">
    <div class="container mx-auto">
      <div class="flex space-x-4">
        <input
          v-model="model"
          @keyup.enter="sendMessage"
          placeholder="メッセージを入力..."
          class="flex-1 px-4 py-2 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <button
          @click="sendMessage"
          class="px-6 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors"
        >
          送信
        </button>
        <!-- 録音中の場合、スピナーがテキストの左側に表示 -->
        <button
          @click="startVoiceRecognition"
          :disabled="isRecording"
          :class="[
            'flex items-center px-6 py-2 rounded-lg transition-colors',
            isRecording ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'
          ]"
        >
          <template v-if="isRecording">
            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
          </template>
          {{ isRecording ? "録音中..." : "音声認識" }}
        </button>
      </div>
    </div>
  </div>
</template>
