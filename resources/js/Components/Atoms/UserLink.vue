<template>
  <Link :href="route('conversations.show', { recepterId: user.id })" class="flex items-center mb-4 hover:underline hover:cursor-pointer">
    <img :src="user.icon_url" alt="ユーザーアイコン" class="w-8 h-8 rounded-full mr-2">
    <span class="text-lg font-semibold text-gray-700">{{ user.name }}</span>
    <span class="text-lg text-red-400 ml-3">{{ user.id }}</span>
  </Link>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
  user: { 
    name: string;
    icon_url: string;
    id: number;
  };
}>();
</script>
