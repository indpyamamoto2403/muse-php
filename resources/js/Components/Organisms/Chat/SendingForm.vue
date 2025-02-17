<script setup lang="ts">

const model = defineModel<string>();

const emit = defineEmits<{
    (e: 'sendMessage', message: string): void;
    }>();

const sendMessage = async () => {
        emit('sendMessage', model.value);
        model.value = '';
};

</script>
<template>
    <!-- 固定されたメッセージ入力エリア -->
    <div class="fixed bottom-0 w-full left-0 right-0 p-4 bg-gray-900 border-t border-gray-700 z-50">
      <div class="container mx-auto">
        <div class="flex space-x-4">
          <input
            v-model="model"
            @keyup.enter="sendMessage"
            placeholder="メッセージを入力...."
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
</template>