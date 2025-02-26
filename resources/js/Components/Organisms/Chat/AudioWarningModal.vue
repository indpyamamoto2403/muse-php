<template>
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded shadow-md w-80">
        <h2 class="text-xl font-bold mb-4">音声再生の注意</h2>
        <p class="mb-4">
          このページでは音声を再生するためにユーザーの操作が必要です。<br>
          再生を開始するには「OK」を押してください。
        </p>
        <div class="flex justify-end space-x-4">
          <button @click="handleDisagree" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">
            キャンセル
          </button>
          <button @click="handleAgree" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
            OK
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  const emit = defineEmits<{
    (e: 'agree'): void;
    (e: 'disagree'): void;
  }>();
  
  const handleAgree = () => {
    emit('agree');
  };
  
  const handleDisagree = () => {
    emit('disagree');
  };
  </script>
  
  <style scoped>
  /* 必要に応じて追加のスタイルを記述してください */
  </style>