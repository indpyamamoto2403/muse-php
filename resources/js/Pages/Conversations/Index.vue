  <script setup lang="ts">
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  import { Link } from '@inertiajs/vue3'
  
  // props は Inertia 経由で渡される会話一覧データ
  defineProps({
    conversations: Array,
  })
  </script>
  
  <style scoped>
  .avatar {
    object-fit: cover;
  }
</style>
<template>
    <AuthenticatedLayout>
      <div class="conversations-index p-6">
        <h1 class="text-2xl font-bold mb-4">My Conversations</h1>
        <ul class="space-y-4">
          <li v-for="conversation in conversations" :key="conversation.id">
            <Link :href="route('conversations.show', conversation.id)" class="block p-4 bg-white rounded shadow hover:bg-gray-100 transition">
              <div class="flex items-center space-x-3">
                <div class="participants flex -space-x-2">
                  <img
                    v-for="participant in conversation.conversationParticipants"
                    :key="participant.user.id"
                    :src="participant.user.icon_url"
                    :alt="participant.user.name"
                    class="avatar h-10 w-10 rounded-full border-2 border-white"
                  />
                </div>
                <div class="flex-1">
                  <p class="text-gray-800">
                    {{ conversation.messages[0]?.content || 'No messages yet' }}
                  </p>
                </div>
              </div>
            </Link>
          </li>
        </ul>
      </div>
    </AuthenticatedLayout>
  </template>

  