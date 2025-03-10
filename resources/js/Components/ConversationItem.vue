
<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import ParticipantAvatar from './ParticipantAvatar.vue';

const props = defineProps({
  conversation: Object,
  currentUserId: Number,
});
</script>
<template>
  <li>
    <Link :href="route('conversations.show', conversation.recepter_id)" class="block p-6 bg-slate-100 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <!-- 相手のみの参加者情報を表示 -->
          <div class="participants flex space-x-4 w-[120px] justify-center items-center">
            <ParticipantAvatar
              v-for="participant in conversation.filteredParticipants"
              :key="participant.user.id"
              :participant="participant"
            />
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
</template>

