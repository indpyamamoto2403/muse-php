<template>
  <div>
    <!-- モーダルを開くためのトリガー -->
    <div @click="openModal" class="flex items-center mb-4 hover:underline hover:cursor-pointer">
      <img :src="user.icon_url" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
      <span class="text-lg font-semibold text-gray-700">{{ user.name }}</span>
      <span class="text-lg text-red-400 ml-3">{{ user.id }}</span>
    </div>

    <!-- Teleportを利用してモーダルをbody直下にレンダリング -->
    <teleport to="body">
      <transition name="modal">
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
          <!-- 背景のオーバーレイ。クリックでモーダルを閉じる -->
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="closeModal"></div>
          <!-- モーダルコンテンツ -->
          <div class="relative bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full mx-4">
            <!-- 右上の×ボタン -->
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">
              &times;
            </button>
            <div class="p-6">
              <!-- ユーザーのプロフィール情報 -->
              <div class="flex flex-col items-center">
                <img :src="user.icon_url" alt="ユーザーアイコン" class="w-20 h-20 rounded-full mb-4">
                <h3 class="text-2xl font-semibold text-gray-900">{{ user.name }}</h3>
                <p class="text-sm text-gray-500 mb-2">ユーザーID: {{ user.id }}</p>
                <p class="text-sm text-gray-600 mb-1"><strong>職業:</strong> {{ user.occupation }}</p>
                <p class="text-sm text-gray-600 text-center"><strong>自己紹介:</strong> {{ user.self_introduction }}</p>
              </div>
              <!-- メッセージ送信ボタン -->
              <div class="mt-6">
                <Link :href="route('conversations.show', { recepterId: user.id })" class="block w-full text-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-white font-medium hover:bg-blue-700">
                  メッセージを送る
                </Link>
              </div>
            </div>
            <!-- 閉じるボタン（必要に応じて） -->
            <div class="p-4 border-t">
              <button @click="closeModal" class="w-full text-gray-700 text-center py-2 hover:bg-gray-100 rounded-md">
                閉じる
              </button>
            </div>
          </div>
        </div>
      </transition>
    </teleport>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  user: { 
    name: string;
    icon_url: string;
    id: number;
    occupation: string;
    self_introduction: string;
  };
}>();

const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};
</script>
