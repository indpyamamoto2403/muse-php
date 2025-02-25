<script setup lang="ts">
import { ref, computed, nextTick, watch, onMounted } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { fetchAIResponse, fetchScore } from '@/Pages/Chat/generativeAIResponder';
import { Message } from '@/Types/Chat';
import { getMessages, speak } from '@/Pages/Chat/ChatMessages';
import { getToLocaleTimeString } from '@/Functions/TimeStamp';
import SendingForm from '@/Components/Organisms/Chat/SendingForm.vue';
import ConversationView from '@/Components/Organisms/Chat/ConversationView.vue';
import CompletionModal from '@/Components/Organisms/Chat/CompletionModal.vue';
import ExtractionModal from '@/Components/Organisms/Chat/ExtractionModal.vue';

const messages = ref<Message[]>([
  { id: 1, 
    text: 'こんにちは！あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？', 
    sender: 'system', 
    timestamp: getToLocaleTimeString() 
  },
]);

const newMessage = ref('');
const maxCount:number = 2; // トライアル回数
const showScoreExtractionModal = ref(false);
const showCompletionModal = ref(false);

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
  
  // やり取り回数チェック
  const reachedLimit:boolean = checkInteractionLimit();

  // AI応答取得
  if(!reachedLimit) {
    const aiResponseText = await fetchAIResponse(prompt, JSON.stringify(messages.value));
    const aiMessage: Message = getMessages(messages.value.length + 1, 'system', aiResponseText);

    speak(aiResponseText);
    messages.value.push(aiMessage);
  }
};

// モーダル閉じ処理
const agree = () => {
  showCompletionModal.value = false;
  showScoreExtractionModal.value = true;
  fetchScore(JSON.stringify(messages.value));
};

const disagree = () => {
  showCompletionModal.value = false;
};


// コンポーネントマウント時に読み上げる
onMounted(() => {
  const message = "あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？";
  speak(message);
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

    <!-- スコアリング実行中モーダル-->
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
