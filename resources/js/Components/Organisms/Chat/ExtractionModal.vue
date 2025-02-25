<template>
    <transition name="fade">
      <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 w-80">
          <div class="flex justify-center">
            <!-- ローディングスピナー -->
            <svg class="animate-spin h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </div>
          <p class="mt-4 text-center text-xl font-medium text-gray-700">
            スコアリング実行中です...
          </p>
        </div>
      </div>
    </transition>
  </template>
  
  <script setup lang="ts">
  defineProps({
    show: Boolean,
  });
  </script>
  
  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>