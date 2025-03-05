<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  art: Object,
});

const page = usePage();

const isLiked = ref(
  props.art.likes && props.art.likes.some(like => like.user_id === page.props.auth.user.id)
);

const isSaved = ref(
  props.art.saves && props.art.saves.some(save => save.user_id === page.props.auth.user.id)
);

// いいねの切替
const toggleLike = async () => {
  try {
    const response = await axios.post(route('like'), { artId: props.art.id });
    isLiked.value = !isLiked.value;
    console.log(response.data.message);  // "いいねを取り消しました" などのメッセージ
  } catch (error) {
    console.error(error);
  }
};

// 保存の切替
const toggleSave = async () => {
  try {
    const response = await axios.post(route('save'), { artId: props.art.id });
    isSaved.value = !isSaved.value;
    console.log(response.data.message);
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <img :src="`/storage/${art.image}`" :alt="art.title" class="w-full h-48 object-cover">
    <div class="p-4">
      <h3 class="text-lg font-semibold text-gray-800">{{ art.title }}</h3>
      <p class="text-sm text-gray-600 mt-1">{{ art.user.name }}</p>
      <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ art.description }}</p>
      <div class="flex justify-between mt-3">
        <button 
          @click="toggleLike" 
          class="flex items-center gap-1 text-sm"
          :class="isLiked ? 'text-red-500' : 'text-gray-500'"
        >
          <span v-if="isLiked">❤️</span>
          <span v-else>🤍</span>
          {{ art.likes ? art.likes.length : 0 }}
        </button>
        <button 
          @click="toggleSave" 
          class="flex items-center gap-1 text-sm"
          :class="isSaved ? 'text-blue-500' : 'text-gray-500'"
        >
          <span v-if="isSaved">🔖</span>
          <span v-else>🔖</span>
          {{ art.saves ? art.saves.length : 0 }}
        </button>
      </div>
    </div>
  </div>
</template>
