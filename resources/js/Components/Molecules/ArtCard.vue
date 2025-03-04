<script setup lang="ts">
import ArtImage from '@/Components/Atoms/ArtImage.vue';
import LikeButton from '@/Components/Atoms/LikeButton.vue';
import SaveButton from '@/Components/Atoms/SaveButton.vue';
import UserLink from '@/Components/Atoms/UserLink.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const props = defineProps<{
  title: string;
  description: string;
  imageUrl: string;
  artId: number; // 追加
  user: { 
    name: string;
    icon_url: string;
    id: number;
  };
  likes:any;
  saves:any;
}>();

const authUser = usePage().props.auth.user;

const isLiked = computed(() => {
  return props.likes.some((like:any) => {
    return like.user_id === authUser.id;
  });
});

const isSaved = computed(() => {
  return props.saves.some((save:any) => {
    return save.user_id === authUser.id;
  });
});
console.log(props.saves);
console.log(props.likes);
</script>

<template>
  <li class="bg-white rounded-lg shadow-lg p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl relative">
    <!-- イイネ＆保存ボタン -->
    <div class="absolute top-2 right-2 flex gap-2">
      <LikeButton :artId="artId" :isLiked="isLiked" />
      <SaveButton :artId="artId" :isSaved="isSaved" />
    </div>

    <UserLink :user="user" />

    <h2 class="text-2xl font-semibold mb-2 text-gray-700">{{ title }}</h2>
    <p class="text-gray-500 mb-4">{{ description }}</p>
    <ArtImage :src="imageUrl" :alt="title" />
  </li>
</template>
