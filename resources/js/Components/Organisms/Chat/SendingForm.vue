<script setup lang="ts">
import { onMounted } from 'vue';
const model = defineModel<string>();

const emit = defineEmits<{
  (e: 'sendMessage', message: string): void;
}>();

const sendMessage = async () => {
  emit('sendMessage', model.value);
  model.value = '';
};


// 音声認識を開始する関数
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

  // 録音開始時に通知
  recognition.onstart = () => {
    console.log('録音開始');
  };

  // 録音終了時に通知
  recognition.onend = () => {
    console.log('録音終了');
  };

  recognition.onresult = (event: SpeechRecognitionEvent) => {
    if (event.results.length > 0) {
      // 認識結果を入力欄に反映
      const transcript = event.results[0][0].transcript;
      model.value = transcript;
    }
  };

  recognition.onerror = (event) => {
    console.error('音声認識エラー:', event);
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
        <!-- 音声認識ボタン -->
        <button
          @click="startVoiceRecognition"
          class="px-6 py-2 bg-green-600 rounded-lg hover:bg-green-700 transition-colors"
        >
          音声認識
        </button>
      </div>
    </div>
  </div>
</template>
