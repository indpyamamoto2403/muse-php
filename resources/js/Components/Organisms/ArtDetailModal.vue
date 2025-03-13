<script setup lang="ts">
import { Art } from '@/Types/Art';
import BoardSendForm from '@/Components/Molecules/BoardSendForm.vue';

import { ref } from 'vue';
import axios from 'axios';

interface Props {
    art: Art
}

const props = defineProps<Props>();
const comments = ref(props.art?.comments || []);
const isLoading = ref(false);
const errorMessage = ref('');

const submit = async (commentText: string) => {
  if (!commentText.trim()) {
    errorMessage.value = 'コメントを入力してください。';
    return;
  }

  isLoading.value = true;
  errorMessage.value = '';

  try {
    const response = await axios.post(route("comment"), {
      comment: commentText,
      artId: props.art.id
    });

    //add posted comment to the top of the comments list
    

    // Assuming the response contains the new comment
    if (response.data.comment) {
      comments.value.unshift(response.data.comment);
    }

    // Clear the form and reset loading state
    errorMessage.value = '';
  } catch (error) {
    errorMessage.value = 'コメントの投稿に失敗しました。もう一度お試しください。';
    console.error(error);
  } finally {
    isLoading.value = false;
  }
};

// Function to format date
const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  return date.toLocaleString('ja-JP', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>

<template>
  <div class="modal-wrapper">
    <div class="modal-content">
      <span 
        class="close-button text-3xl absolute top-3 right-3 hover:bg-slate-100 hover:cursor-pointer rounded-full px-2" 
        @click="$emit('closeDetailModal')"
      >
        ×
      </span>
      
      <div class="detail-section">
        <h2 class="font-bold text-3xl my-2 underline">{{ art?.title }}</h2>
        <p class="font-semibold text-lg">{{ art?.description }}</p>
        <img 
          :src="art?.image_url" 
          alt="Art Image" 
          class="mt-8 max-h-[400px] object-contain w-full"
        />
      </div>
      
      <div class="dashboard-section">
        <div class="comment-container w-full">
          <h2 class="font-bold text-2xl mb-4">
            ギャラリーにコメントを投稿する
          </h2>
          
          <board-send-form 
            @submit="submit"
          />
          
          <div v-if="errorMessage" class="text-red-500 mt-2">
            {{ errorMessage }}
          </div>
          
          <div class="comments-list mt-6">
            <h3 class="font-semibold text-lg mb-4">コメント一覧 ({{ comments.length }})</h3>
            
            <div 
              v-if="comments.length === 0" 
              class="text-gray-500 text-center py-4"
            >
              まだコメントはありません。最初のコメントを投稿しましょう！
            </div>
            
            <transition-group 
              name="comment-list" 
              tag="ul" 
              class="flex flex-col gap-4"
            >
              <li 
                v-for="comment in comments" 
                :key="comment.id" 
                class="bg-slate-50 p-4 rounded-lg shadow-sm"
              >
                <div class="flex items-center mb-2">
                  <img 
                    :src="comment.user.icon_url" 
                    alt="User Avatar" 
                    class="w-8 h-8 rounded-full mr-3 object-cover"
                  />
                  <div>
                    <p class="font-semibold">{{ comment.user.name }}</p>
                    <p class="text-gray-500 text-xs">
                      {{ formatDate(comment.created_at) }}
                    </p>
                  </div>
                </div>
                <p class="text-gray-800">{{ comment.comment }}</p>
              </li>
            </transition-group>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-wrapper {
  @apply fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50;
}

.modal-content {
  @apply bg-white rounded-lg p-6 max-w-7xl w-full max-h-[700px] h-full relative grid grid-cols-1 md:grid-cols-2 overflow-hidden;
}

.detail-section {
  @apply col-span-1 overflow-y-auto pr-4;
  @apply md:border-r md:border-gray-300;
}

.dashboard-section {
  @apply col-span-1 flex flex-col justify-start items-center my-4 overflow-y-auto px-6;
}

.comment-list-enter-active,
.comment-list-leave-active {
  transition: all 0.5s ease;
}

.comment-list-enter-from,
.comment-list-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>