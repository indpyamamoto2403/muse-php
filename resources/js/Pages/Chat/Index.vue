<script setup lang="ts">
import { ref, computed, nextTick, watch } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { getAIResponse } from '@/Pages/Chat/generativeAIResponder';
import { Message } from '@/Types/Chat';
import { getToLocaleTimeString } from '@/Functions/TimeStamp';
import SendingForm from '@/Components/Organisms/Chat/SendingForm.vue';
import ConversationView from '@/Components/Organisms/Chat/ConversationView.vue';
import CompletionModal from '@/Components/Organisms/Chat/CompletionModal.vue';

const messages = ref<Message[]>([
  { id: 1, text: 'こんにちは！あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？', sender: 'other', timestamp: getToLocaleTimeString() },
]);
const newMessage = ref('');
const interactionCount = ref(0);
const maxCount:number = 2; // トライアル回数
const showCompletionModal = ref(false);



// やり取り回数を計算
const checkInteractionLimit = () => {
  // ユーザーメッセージ数をカウント（初期メッセージを考慮）
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

  // ユーザーメッセージ追加
  const userMessage: Message = {
    id: messages.value.length + 1,
    text: prompt,
    sender: 'user',
    timestamp: getToLocaleTimeString(),
  };
  messages.value.push(userMessage);
  newMessage.value = '';

  // AI応答取得
  const aiResponseText = await getAIResponse(prompt, JSON.stringify(messages.value));
  const aiMessage: Message = {
    id: messages.value.length + 1,
    text: aiResponseText,
    sender: 'other',
    timestamp: getToLocaleTimeString(),
  };
  messages.value.push(aiMessage);

  // やり取り回数チェック
  checkInteractionLimit();
};

// モーダル閉じ処理
const closeModal = () => {
  showCompletionModal.value = false;
  // 必要に応じて追加処理（例: チャットリセット）
};
</script>

<template>
  <Layout>
    <div class="container mx-auto h-screen flex flex-col relative">
      <h1 class="text-2xl font-bold p-4 border-b border-gray-700 text-white">Chat INDP</h1>
      
      <ConversationView :messages="messages" />
    </div>

    <!-- メッセージ送信フォーム -->
    <SendingForm 
      v-model="newMessage" 
      @sendMessage="sendMessage"
      :disabled="showCompletionModal"
    />

    <!-- 完了モーダル -->
    <CompletionModal 
      v-if="showCompletionModal" 
      @closeModal="closeModal" />
  </Layout>
</template>

<style scoped>
/* スクロールバーのスタイリング */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background-color: #2d3748; /* bg-gray-800*/
}

::-webkit-scrollbar-thumb {
  background-color: #4a5568; /* bg-gray-600 */
  border-radius: 9999px;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #718096; /* bg-gray-500 */
}
</style>
