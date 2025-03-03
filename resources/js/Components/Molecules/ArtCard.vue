<script setup lang="ts">
import ArtImage from '@/Components/Atoms/ArtImage.vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps<{
  title: string;
  description: string;
  imageUrl: string;
  user: { 
    name: string;
    icon_url: string;
    id: number;
  };
}>();
</script>

<template>
  <li class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">

    <Link :href="route('conversations.show', { recepterId: user.id })" class="flex items-center mb-4 hover:underline hover:cursor-pointer">
      <img :src="user.icon_url" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
      <span class="text-lg font-semibold text-gray-700">{{ user.name }}</span>
      <span class="text-lg text-red-400 ml-3">{{ user.id }}</span>
    </Link>

    <h2 class="text-2xl font-semibold mb-2 text-gray-700">{{ title }}</h2>
    <p class="text-gray-500 mb-4">{{ description }}</p>
    <ArtImage :src="imageUrl" :alt="title" />
  </li>
</template>
