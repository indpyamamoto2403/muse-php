<template>
  <li class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
    <!-- ユーザー情報の表示 -->
    <div class="flex items-center mb-4">
      <img :src="user.icon_url" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
      <span class="text-lg font-semibold text-gray-700">{{ user.name }}</span>
    </div>
    <h2 class="text-2xl font-semibold mb-2 text-gray-700">{{ title }}</h2>
    <p class="text-gray-500 mb-4">{{ description }}</p>
    <ArtImage :src="imageUrl" :alt="title" />
  </li>
</template>

<script setup lang="ts">
import ArtImage from '@/Components/Atoms/ArtImage.vue';

const props = defineProps<{
  title: string;
  description: string;
  imageUrl: string;
  user: { 
    name: string;
    icon_url: string;
  };
}>();
</script>
