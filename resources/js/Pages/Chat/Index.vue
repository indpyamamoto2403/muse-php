<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { fetchAIResponse, fetchScore } from '@/Pages/Chat/generativeAIResponder';
import { Message } from '@/Types/Chat';
import { getMessages } from '@/Pages/Chat/ChatMessages';
import { getToLocaleTimeString } from '@/Functions/TimeStamp';
import SendingForm from '@/Components/Organisms/Chat/SendingForm.vue';
import ConversationView from '@/Components/Organisms/Chat/ConversationView.vue';
import CompletionModal from '@/Components/Organisms/Chat/CompletionModal.vue';
import ExtractionModal from '@/Components/Organisms/Chat/ExtractionModal.vue';
import AudioWarningModal from '@/Components/Organisms/Chat/AudioWarningModal.vue'; // 新規追加
import axios from 'axios';

const messages = ref<Message[]>([
  {
    id: 1,
    text: 'こんにちは！あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？',
    sender: 'system',
    timestamp: getToLocaleTimeString()
  },
]);

const newMessage = ref('');
const maxCount: number = 3; // トライアル回数
const showScoreExtractionModal = ref(false);
const showCompletionModal = ref(false);
// 音声再生の注意モーダルを初期表示
const showAudioWarningModal = ref(true);

const checkInteractionLimit = () => {
  const userMessagesCount = messages.value.filter(m => m.sender === 'user').length;
  if (userMessagesCount >= maxCount) {
    showCompletionModal.value = true;
    return true;
  }
  return false;
};

// メッセージ送信処理
const sendMessage = async () => {
  if (checkInteractionLimit()) return;

  const prompt = newMessage.value.trim();
  if (!prompt) return;

  const userMessage: Message = getMessages(messages.value.length + 1, 'user', prompt);
  messages.value.push(userMessage);
  newMessage.value = '';

  if (!checkInteractionLimit()) {
    const aiResponseText = await fetchAIResponse(prompt, JSON.stringify(messages.value));
    const aiMessage: Message = getMessages(messages.value.length + 1, 'system', aiResponseText);
    messages.value.push(aiMessage);
  }
};

// 完了モーダル用の処理
const agree = () => {
  showCompletionModal.value = false;
  showScoreExtractionModal.value = true;
  fetchScore(JSON.stringify(messages.value));
};
const disagree = () => {
  showCompletionModal.value = false;
};

// Audio Warning Modal の処理
const handleAudioAgree = async () => {
  showAudioWarningModal.value = false;
  const firstMessage = "おはようございます！今日あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？";
  try {
    const response = await axios.get('/api/voice', { params: { text: firstMessage } });
    const audioURL = response.data.audioURL;
    const audio = new Audio(audioURL);
    await audio.play();
  } catch (error) {
    console.error("Error fetching or playing audio:", error);
  } finally {

    showAudioWarningModal.value = false;
  }
};

const handleAudioDisagree = () => {
  // ユーザーが拒否した場合は、単にモーダルを閉じる
  showAudioWarningModal.value = false;
};

onMounted(() => {
  // マウント時には音声自動再生は行わず、モーダルを表示するだけにしています。
});
</script>

<template>
  <Layout>
    <template #header>
      チャット with AI
    </template>
    <div class="w-full">
      <div class="w-full h-screen flex flex-col relative">
        <ConversationView :messages="messages" />
      </div>
      <div class="w-full bg-red-300">
        <SendingForm 
          v-model="newMessage" 
          @sendMessage="sendMessage"
          :disabled="showCompletionModal"
        />
      </div>

      <!-- 音声再生の注意を促すモーダル -->
      <AudioWarningModal 
        v-if="showAudioWarningModal" 
        @agree="handleAudioAgree" 
        @disagree="handleAudioDisagree"
      />

      <!-- スコアリング実行中モーダル -->
      <ExtractionModal :show="showScoreExtractionModal" />
      <!-- 完了モーダル -->
      <CompletionModal 
        v-if="showCompletionModal" 
        @agree="agree"
        @disagree="disagree"
      />
    </div>
  </Layout>
</template>

<style scoped>
/* スクロールバーのスタイリング */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background-color: #2d3748;
}

::-webkit-scrollbar-thumb {
  background-color: #4a5568;
  border-radius: 9999px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #718096;
}
</style>
