<template>
  <AuthenticatedLayout>
    <div class="conversation-show p-6 bg-gradient-to-b from-blue-50 to-white rounded-lg shadow-lg">
      <header class="mb-6 flex items-center justify-between border-b pb-4">
        <div class="flex items-center">
          <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold mr-4">
            <img :src="otherParticipant.icon_url" alt="プロフィール画像" class="w-10 h-10 rounded-full" />
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-800">
              {{ otherParticipant.name }}
            </h1>
            <p class="text-sm text-gray-500">
              <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
              オンライン
            </p>
          </div>
        </div>
        <div class="flex space-x-2">
          <button class="p-2 rounded-full hover:bg-gray-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </button>
          <button class="p-2 rounded-full hover:bg-gray-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
            </svg>
          </button>
        </div>
      </header>
  
      <div class="messages space-y-4 overflow-y-auto mb-6 p-4 bg-white rounded-lg shadow-inner" ref="messagesContainer">
        <div v-if="conversation.messages.length === 0" class="flex flex-col items-center justify-center h-64 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
          <p>メッセージはまだありません</p>
        </div>
        
        <div
          v-for="message in conversation.messages"
          :key="message.id"
          class="message-wrapper flex"
          :class="{ 'justify-end': message.sender_id === userProps.id }"
        >
      <!-- 自分のメッセージ -->
      <div
        v-if="message.user_id === userProps.id"
        class="message p-3 rounded-2xl shadow-sm bg-gradient-to-r from-blue-500 to-indigo-600 text-white"
      >
      <p>{{ message.content }}</p>
        <div class="flex justify-end items-center mt-1">
        <small class="text-xs text-blue-200">
          {{ formatDate(message.created_at) }}
        </small>
            <span class="ml-2 text-xs">✓</span>
          </div>
      </div>
  
          <!-- 相手のメッセージ -->
          <div
            v-else
            class="message p-3 rounded-2xl shadow-sm bg-gray-100 text-gray-800"
          >
            <p>{{ message.content }}</p>
            <small class="block mt-1 text-xs text-gray-500">
              {{ formatDate(message.created_at) }}
            </small>
          </div>
        </div>
      </div>
  
      <form @submit.prevent="sendMessage" class="flex space-x-2 bg-white p-3 rounded-lg shadow">
        <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </button>
        <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
          </svg>
        </button>
        <input
          v-model="form.content"
          placeholder="メッセージを入力"
          class="flex-1 p-3 border border-gray-200 rounded-full focus:ring-2 focus:ring-blue-200 focus:border-blue-400 focus:outline-none transition-all"
        />
        <button
          type="submit"
          class="p-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full shadow hover:shadow-md transition-all transform hover:scale-105 focus:outline-none"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
          </svg>
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, computed } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3'

const userProps = usePage().props.auth.user

// Inertia から渡される props
const props = defineProps({
  conversation: Object,
  user: Object,
})

// 1対1のチャットの場合、ログインユーザー以外の参加者を算出
const otherParticipant = computed(() => {
  const participants = props.conversation.conversation_participants || [];
  return participants.find(
    (participant: any) => participant.user.id !== userProps.id
  )?.user;
});
console.log(otherParticipant.value);
const form = useForm({
  content: '',
  recepter_id: otherParticipant.value.id, // 初期値として設定
});

console.log(props.conversation);

function sendMessage() {
  form.post('/conversations/send', {
    onFinish: () => form.content = '',
  });
}

// ユーザー名からイニシャルを取得
function getInitials(name) {
  return name
    .split(' ')
    .map(part => part.charAt(0))
    .join('')
    .toUpperCase();
}

// 日付フォーマット
function formatDate(dateString) {
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('ja-JP', {
    hour: '2-digit',
    minute: '2-digit',
  }).format(date);
}
</script>

<style scoped>
.messages {
  height: 70vh;
  scroll-behavior: smooth;
}

.message {
  max-width: 75%;
  position: relative;
}

.message-wrapper {
  margin-bottom: 12px;
}

/* メッセージの吹き出し風デザイン */
.message-wrapper:not(.justify-end) .message {
  border-top-left-radius: 4px;
}

.message-wrapper.justify-end .message {
  border-top-right-radius: 4px;
}


</style>