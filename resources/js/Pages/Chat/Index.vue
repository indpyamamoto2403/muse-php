<script setup lang="ts">
import { ref, computed, nextTick, watch } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { getAIResponse } from '@/Pages/Chat/generativeAIResponder';
import { Message } from '@/Types/Chat';
import { getToLocaleTimeString } from '@/Functions/TimeStamp';

const messages = ref<Message[]>([
  { id: 1, text: 'こんにちは！あなたの芸術作品の趣味嗜好について教えてください！最近、どんな映画を見た？', sender: 'other', timestamp: getToLocaleTimeString() },
]);

const newMessage = ref('');
const messageContainer = ref<HTMLElement | null>(null);

// メッセージ送信処理
const sendMessage = async () => {
  const prompt = newMessage.value.trim();
  if (prompt) {
    // ユーザーのメッセージを追加
    const userMessage: Message = {
      id: messages.value.length + 1,
      text: prompt,
      sender: 'user',
      timestamp: getToLocaleTimeString(),
    };
    messages.value.push(userMessage);

    // 入力欄をクリア
    newMessage.value = '';

    // 生成AIからの応答を取得（prompt はすでに変数に格納済み）
    const aiResponseText = await getAIResponse(prompt);
    const aiMessage: Message = {
      id: messages.value.length + 1,
      text: aiResponseText,
      sender: 'other',
      timestamp: getToLocaleTimeString(),
    };
    messages.value.push(aiMessage);

    console.log(messages.value);
  }
};
// 最新メッセージに自動スクロール
watch(
  () => messages.value.length,
  async () => {
    await nextTick();
    if (messageContainer.value) {
      messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
    }
  }
);

</script>

<template>
  <Layout>
    <!-- メインチャットコンテナ -->
    <div class="container mx-auto h-screen flex flex-col relative">
      <h1 class="text-2xl font-bold p-4 border-b border-gray-700 text-white">Chat INDP</h1>
      
      <!-- メッセージ表示エリア -->
      <div
        ref="messageContainer"
        class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-800 mb-28 rounded-2xl shadow-lg"
      >
        <div
          v-for="message in messages"
          :key="message.id"
          :class="[
            'flex',
            message.sender === 'user' ? 'justify-end' : 'justify-start'
          ]"
        >
          <div
            :class="[
              'max-w-xs lg:max-w-md px-4 py-2 rounded-lg',
              message.sender === 'user'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-700 text-white'
            ]"
          >
            <div class="text-sm">{{ message.text }}</div>
            <div class="text-xs mt-1 opacity-70 text-right">{{ message.timestamp }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- 固定されたメッセージ入力エリア -->
    <div class="fixed bottom-0 w-full left-0 right-0 p-4 bg-gray-900 border-t border-gray-700 z-50">
      <div class="container mx-auto">
        <div class="flex space-x-4">
          <input
            v-model="newMessage"
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
        </div>
      </div>
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
