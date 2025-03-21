<script setup lang="ts">
import { Art } from '@/Types/Art';
import BoardSendForm from '@/Components/Molecules/BoardSendForm.vue';
import GalleryComment from '@/Components/Molecules/GalleryComment.vue';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

interface Props {
    art: Art
}

const userId = usePage().props.auth.user.id;
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

    if (response.status === 200) {

      comments.value.unshift(response.data.message);
    }

    errorMessage.value = '';
  } catch (error) {
    errorMessage.value = 'コメントの投稿に失敗しました。もう一度お試しください。';
    console.error(error);
  } finally {
    isLoading.value = false;
  }
};

const deleteComment = (commentId: number) => {
  comments.value = comments.value.filter((comment) => comment.id !== commentId);
  console.log('Comment deleted about', commentId);
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
          <p v-if="art?.user.id === userId" class="text-gray-500 text-sm bg-yellow-100 p-2 rounded-md">
            ※この作品の投稿者はユーザー様です。
          </p>
          <p v-else class="text-gray-500 text-sm bg-blue-200 p-2 rounded-md">
            作成者: {{ art?.user?.name }}
          </p>
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
              <!-- コメント欄 -->
              <li 
                v-for="comment in comments" 
                :key="comment.id" 
              >
                <gallery-comment 
                :comment="comment" 
                :userId="userId"
                @delete-comment="deleteComment" 
                />
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