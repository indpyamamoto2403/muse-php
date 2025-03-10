<template>
  <div class="conversations-index p-6 bg-gray-100 min-h-screen rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">会話履歴</h1>
    <ul class="space-y-6">
      <ConversationItem
        v-for="conversation in filteredConversations"
        :key="conversation.id"
        :conversation="conversation"
        :current-user-id="currentUserId"
      />
    </ul>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import ConversationItem from '@/Components/ConversationItem.vue';

// Inertia 経由で渡される会話一覧データ
interface Participant {
  user: {
    id: number;
    name: string;
    icon_url: string;
  };
}

interface Conversation {
  id: number;
  recepter_id: number;
  messages: { content: string }[];
  updated_at: string;
  conversation_participants: Participant[];
}

const props = defineProps<{
  conversations: Conversation[];
}>();

// pageProps から現在のユーザー情報を取得（例: pageProps.currentUser）
const pageProps = usePage().props;
const currentUserId = pageProps.auth.user.id;

// 各会話の参加者情報から現在のユーザーを除外した新しいプロパティを付与
const filteredConversations = computed(() => {
  return props.conversations.map(conversation => {
    return {
      ...conversation,
      filteredParticipants: conversation.conversation_participants.filter(
        participant => participant.user.id !== currentUserId
      )
    };
  });
});
</script>
