<template>
    <AuthenticatedLayout>
      <div class="conversation-show p-6">
        <header class="mb-6">
          <h1 class="text-2xl font-bold">
            Conversation with {{ otherParticipant.name }}
          </h1>
        </header>
  
        <div class="messages space-y-4 overflow-y-auto mb-6" ref="messagesContainer">
          <div
            v-for="message in conversation.messages"
            :key="message.id"
            class="message p-3 rounded shadow"
            :class="{'bg-blue-100 self-end': message.sender.id === user.id, 'bg-gray-100 self-start': message.sender.id !== user.id}"
          >
            <p class="text-gray-800">{{ message.content }}</p>
            <small class="text-gray-500 block mt-1">{{ message.created_at }}</small>
          </div>
        </div>
  
        <form @submit.prevent="sendMessage" class="flex space-x-2">
          <input
            v-model="newMessage"
            placeholder="Type your message"
            class="flex-1 p-3 border rounded"
          />
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
            Send
          </button>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup lang="ts">
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  import { ref, computed } from 'vue'
  
  // Inertia から渡される props
  const props = defineProps({
    conversation: Object,
    user: Object,
  })
  
  // 1対1のチャットの場合、ログインユーザー以外の参加者を算出
  const otherParticipant = computed(() => {
    return props.conversation.conversationParticipants.find(
      (participant: any) => participant.user.id !== props.user.id
    ).user
  })
  
  const newMessage = ref('')
  
  function sendMessage() {
    // ここに Inertia.post や axios を使った送信処理を実装します。
    console.log('Send message:', newMessage.value)
    newMessage.value = ''
  }
  </script>
  
  <style scoped>
  .messages {
    max-height: 60vh;
  }
  .message {
    max-width: 75%;
  }
  </style>
  