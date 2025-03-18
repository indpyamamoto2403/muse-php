<script setup lang="ts">
import { ref } from 'vue';
import { formatDate } from '@/Functions/Date';
import { ArtComment } from '@/Types/ArtComment';
import axios from 'axios';

const props = defineProps<{
    comment: ArtComment,
    userId: number
}>();

const isEditing = ref(false);
const editedComment = ref(props.comment.comment);

const emit = defineEmits<{
    deleteComment: (commentId: number) => void
}>();

/**
 * コメントを編集する時に呼ばれる関数
 * 編集モードに切り替える
 */
const handleEditComment = () => {
    isEditing.value = true;
};

/**
 * 編集をキャンセルする時に呼ばれる関数
 * 編集中のコメントを元に戻す
 */
const handleCancelEdit = () => {
    isEditing.value = false;
    editedComment.value = props.comment.comment;
};

/**
 * 編集したコメントを保存する時に呼ばれる関数
 * APIにリクエストを送信してコメントを更新
 */
const handleSaveComment = async () => {
    try {
        // Axiosを使用してPUTリクエストを送信
        const response = await axios.put(`/api/comment/${props.comment.id}`, {
            comment: editedComment.value
        });

        if (response.status === 200) {
            isEditing.value = false;
        }
    } catch (error) {
        console.error('コメントの更新に失敗しました');
    }
};

/**
 * コメントを削除する時に呼ばれる関数
 * APIにリクエストを送信してコメントを削除
 */
const handleDeleteComment = async () => {
    if (confirm('本当にこのコメントを削除しますか？')) {
        try {
            // Axiosを使用してDELETEリクエストを送信
            const response = await axios.delete(`/api/comment/${props.comment.id}`);
            if(response.status === 200) {
                emit('deleteComment', props.comment.id);
            }
        } catch (error) {
            console.error('コメントの削除に失敗しました');
        }
    }
};
</script>
<template>
    <div 
    class="flex items-center mb-3 bg-slate-100 p-3 rounded-lg relative"
    >
        <img 
          :src="comment?.user?.icon_url"
          class="w-8 h-8 rounded-full mr-3 object-cover"
        />
        <div class="w-full">
          <p class="font-semibold">{{ comment?.user?.name }}</p>
          <p class="text-gray-500 text-xs absolute right-3 top-3">
            {{ formatDate(comment?.created_at) }}
          </p>
          
          <!-- 編集モードと表示モードの切り替え -->
          <div v-if="!isEditing" class="text-gray-800">{{ editedComment }}</div>
          
          <div v-else class="w-full mt-2">
            <input type="text" 
              v-model="editedComment" 
              class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300"
              rows="3"
            />
            <div class="flex justify-end mt-2 space-x-2">
              <button 
                class="px-3 py-1 text-xs bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300" 
                @click="handleCancelEdit"
              >
                キャンセル
              </button>
              <button 
                class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600" 
                @click="handleSaveComment"
              >
                保存
              </button>
            </div>
          </div>
        </div>

        <!-- 自分の投稿の場合は編集・削除ボタンを表示 -->
        <div v-if="comment?.user?.id === userId && !isEditing" class="absolute right-12 bottom-3">
          <button class="mybutton" @click="handleEditComment">
            編集
          </button>
        </div>
        <div v-if="comment?.user?.id === userId && !isEditing" class="absolute right-3 bottom-3">
          <button class="mybutton" @click="handleDeleteComment">
            削除
          </button>
        </div>
    </div>
</template>
<style scoped>
.mybutton {
    @apply text-xs text-gray-500 hover:text-gray-800 hover:underline hover:bg-slate-200;
}
</style>