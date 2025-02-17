<script setup lang="ts">
import { Message } from '@/Types/Chat';
import { ref, watch, nextTick } from 'vue';

const messageContainer = ref<HTMLElement | null>(null);

const props = defineProps<{
  messages: Message[];
}>();

// 最新メッセージに自動スクロール
watch(
  () => props.messages.length,
  async () => {
    await nextTick();
    if (messageContainer.value) {
      messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
    }
  }
);

</script>

<template>
<div
ref="messageContainer"
class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-800 mb-28 max-h-[700px] rounded-2xl shadow-lg"
>
<div
  v-for="message in props.messages"
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
</template>