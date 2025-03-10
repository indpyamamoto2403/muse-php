<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// 画像2枚をセットとして扱う新しいフォーム構造
const form = useForm({
  image1: null as File | null,
  image2: null as File | null,
  description: '' // 2枚の画像に対する共通の説明
});

// 画像ファイルアップロード処理
const handleFileUpload = (event: Event, imageField: 'image1' | 'image2') => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files.length > 0) {
    form[imageField] = target.files[0];
  }
};

const submitForm = () => {
  // デバッグ用にコンソール出力
  console.log(form);

  form.post(route('questions.image.upload'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <authenticated-layout>
    <template #header>
      質問画像登録フォーム
    </template>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4">画像登録</h1>
      <form @submit.prevent="submitForm">
        <div class="mb-6">
          <h2 class="font-medium mb-4">画像セット（2枚）</h2>
          
          <!-- 1枚目の画像アップロードフィールド -->
          <div class="mb-4 p-3 border border-gray-200 rounded">
            <label for="image_1" class="block text-sm font-medium text-gray-700 mb-1">
              1枚目の画像:
            </label>
            <input 
              type="file" 
              id="image1" 
              @change="(e) => handleFileUpload(e, 'image1')" 
              accept="image/*"
              class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100"
            />
            <!-- 選択された画像のプレビュー -->
            <div v-if="form.image1" class="mt-2">
              <p class="text-sm text-gray-500">選択された画像: {{ form.image1.name }}</p>
            </div>
            <!-- エラーメッセージ -->
            <div v-if="form.errors.image1" class="text-red-500 text-sm mt-1">
              {{ form.errors.image1 }}
            </div>
          </div>
          
          <!-- 2枚目の画像アップロードフィールド -->
          <div class="mb-4 p-3 border border-gray-200 rounded">
            <label for="image2" class="block text-sm font-medium text-gray-700 mb-1">
              2枚目の画像:
            </label>
            <input 
              type="file" 
              id="image2" 
              @change="(e) => handleFileUpload(e, 'image2')" 
              accept="image/*"
              class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100"
            />
            <!-- 選択された画像のプレビュー -->
            <div v-if="form.image2" class="mt-2">
              <p class="text-sm text-gray-500">選択された画像: {{ form.image2.name }}</p>
            </div>
            <!-- エラーメッセージ -->
            <div v-if="form.errors.image2" class="text-red-500 text-sm mt-1">
              {{ form.errors.image2 }}
            </div>
          </div>
          
          <!-- 共通の説明フィールド -->
          <div class="mb-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
              説明:
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              placeholder="画像セットの説明を入力してください"
            ></textarea>
            <!-- エラーメッセージ -->
            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
              {{ form.errors.description }}
            </div>
          </div>
        </div>
        
        <!-- 送信ボタン -->
        <button 
          type="submit" 
          class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-200 disabled:opacity-75"
          :disabled="form.processing"
        >
          {{ form.processing ? '送信中...' : '送信する' }}
        </button>
      </form>
    </div>
  </authenticated-layout>
</template>