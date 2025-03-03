<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

// Inertia 経由で渡される会話一覧データ
const props = defineProps({
  conversations: Array,
});

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

<style scoped>
.avatar {
  object-fit: cover;
}
</style>

<template>
  <AuthenticatedLayout>
    <div class="conversations-index p-6 bg-gray-100 min-h-screen">
      <h1 class="text-3xl font-bold text-gray-800 mb-8">My Conversations</h1>
      <ul class="space-y-6">
        <li v-for="conversation in filteredConversations" :key="conversation.id">
          <Link :href="route('conversations.show', conversation.recepter_id)" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <!-- 相手のみの参加者情報を表示 -->
                <div class="participants flex space-x-4 w-[120px] justify-center items-center">
                  <div
                    v-for="participant in conversation.filteredParticipants"
                    :key="participant.user.id"
                    class="flex flex-col items-center"
                  >
                    <img
                      :src="participant.user.icon_url"
                      :alt="participant.user.name"
                      class="avatar h-12 w-12 rounded-full border-2 border-white"
                    />
                    <div class="mt-2 text-center">
                      <p class="text-sm font-medium text-gray-700">ID: {{ participant.user.id }}</p>
                      <p class="text-xs text-gray-500">{{ participant.user.name }}</p>
                    </div>
                  </div>
                </div>
                <div>
                  <p class="text-lg text-gray-700">
                    {{ conversation.messages[0]?.content || 'No messages yet' }}
                  </p>
                  <div class="mt-1 text-sm text-gray-500">
                    <span class="font-semibold">Participants:</span>
                    <span v-for="(participant, index) in conversation.filteredParticipants" :key="participant.user.id">
                      {{ participant.user.name }}<span v-if="index < conversation.filteredParticipants.length - 1">, </span>
                    </span>
                  </div>
                </div>
              </div>
              <div class="text-right">
                <span class="text-xs text-gray-400">
                  {{ new Date(conversation.updated_at).toLocaleString() }}
                </span>
              </div>
            </div>
          </Link>
        </li>
      </ul>
    </div>
  </AuthenticatedLayout>
</template>
