<script setup lang="ts">
import { ref, Ref } from 'vue';
import axios from 'axios';

const props = defineProps<{
  artId: number;
  isLiked: boolean;
}>();

const isLiked: Ref<boolean> = ref(props.isLiked);
const handleLike = () => {
  isLiked.value = !isLiked.value;
  axios.post(route('like', {
    artId: props.artId,
    isLiked: isLiked.value,
  }));
};
</script>

<template>
  <button 
    @click.stop="handleLike"
    class="p-2 hover:bg-gray-100 rounded-full transition-colors"
    :class="isLiked ? 'text-red-500' : 'text-gray-500'"
    aria-label="いいね"
  >
    <svg 
      xmlns="http://www.w3.org/2000/svg" 
      class="h-5 w-5" 
      :fill="isLiked ? 'currentColor' : 'none'" 
      viewBox="0 0 24 24" 
      :stroke="isLiked ? 'none' : 'currentColor'"
      stroke-width="2"
      stroke-linecap="round" 
      stroke-linejoin="round"
    >
      <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
  </button>
</template>

