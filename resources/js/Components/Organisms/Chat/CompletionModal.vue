<script setup lang="ts">
const emit = defineEmits<{
    (e: 'closeModal'): void,
}>();
</script>
<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full">
        <h2 class="text-xl font-bold text-white mb-4">情報収集のご協力、ありがとうございます！</h2>
        <p class="text-gray-300 mb-4">
            あなたの情報を十分に取得しました。これより<br>
            嗜好情報の付与を行います。
        </p>
        <div class="flex justify-end space-x-4">
          <button
            @click="emit('closeModal')"
            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded-lg text-white transition-colors"
          >
            承諾する
          </button>
        </div>
      </div>
    </div>
</template>