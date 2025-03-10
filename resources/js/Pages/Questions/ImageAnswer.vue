<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

interface ImageRecord {
  id: string;
  image_url1: string;
  image_url2: string;
  description: string;
  created_at?: string;
  updated_at?: string;
  image_path1?: string;
  image_path2?: string;
}

interface Props {
  images: ImageRecord[];
  submitUrl: string;
}

const props = defineProps<Props>();

const currentIndex = ref(0);
const form = useForm({
  selections: [] as { recordId: string, selectedImage: 1 | 2 }[]
});
const currentRecord = ref<ImageRecord | null>(null);
const image1Loading = ref(true);
const image2Loading = ref(true);
const isCompleted = ref(false);

const updateCurrentRecord = () => {
  if (props.images && props.images.length > currentIndex.value) {
    currentRecord.value = props.images[currentIndex.value];
    image1Loading.value = true;
    image2Loading.value = true;
  } else {
    currentRecord.value = null;
  }
};

const selectImage = (imageNumber: 1 | 2) => {
  if (!currentRecord.value) return;

  // コンソールに選択結果を出力
  console.log({
    question_id: currentRecord.value.id,
    selected_image: imageNumber
});

  form.selections.push({
    recordId: currentRecord.value.id,
    selectedImage: imageNumber
  });

  goToNextRecord();
};

const goToNextRecord = () => {
  if (props.images && currentIndex.value < props.images.length - 1) {
    currentIndex.value++;
    updateCurrentRecord();
  } else {
    submitSelections();
  }
};

const submitSelections = () => {
  // これまでの選択結果をコンソールに出力
  console.log("Selections:", form.selections);

  form.post(props.submitUrl, {
    onSuccess: () => {
      isCompleted.value = true;
    }
  });
};

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  target.src = '/images/placeholder.png';
};

const imageLoaded = (imageNum: 1 | 2) => {
  if (imageNum === 1) {
    image1Loading.value = false;
  } else {
    image2Loading.value = false;
  }
};

// 削除: progressPercentage関数

onMounted(() => {
  updateCurrentRecord();
});
</script>

<template>
  <authenticated-layout>
    <template #header>
      画像選択アンケート
    </template>
    <div class="image-preference-container max-w-4xl mx-auto p-4">
-      <!-- 削除: 進捗バー関連のコード -->
-      <div class="progress-container mb-4">

-        <div class="text-sm text-gray-500 mt-1 text-right">
-          {{ currentIndex + 1 }} / {{ props.images ? props.images.length : 0 }}
-        </div>
-      </div>

      <div v-if="isCompleted" class="completed-message text-center py-10">
        <div class="text-green-500 text-4xl mb-4">✓</div>
        <h2 class="text-xl font-bold mb-2">選択完了!</h2>
        <p class="text-gray-600">すべての画像の選択が完了しました。ご協力ありがとうございます。</p>
      </div>

      <div v-else-if="currentRecord" class="selection-container">
        <div class="description-container mb-6 p-4 bg-gray-50 rounded border border-gray-200">
          <h3 class="text-lg font-medium mb-2">説明</h3>
          <p class="text-gray-700">{{ currentRecord.description }}</p>
          <div class="instruction mt-4 font-medium text-center text-blue-600">
            下の2枚の画像から、あなたが好きな方を選んでください
          </div>
        </div>

        <div class="image-selection-area grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="image-option relative">
            <div class="image-container h-64 md:h-80 lg:h-96 relative overflow-hidden bg-gray-100 rounded border border-gray-200">
              <div v-if="image1Loading" class="absolute inset-0 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
              </div>
              <img 
                :src="currentRecord.image_url1" 
                class="w-full h-full object-contain" 
                alt="画像1"
                @error="handleImageError"
                @load="imageLoaded(1)"
              >
            </div>
            <button 
              @click="selectImage(1)" 
              class="select-button mt-3 w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
            >
              この画像を選ぶ
            </button>
          </div>

          <div class="image-option relative">
            <div class="image-container h-64 md:h-80 lg:h-96 relative overflow-hidden bg-gray-100 rounded border border-gray-200">
              <div v-if="image2Loading" class="absolute inset-0 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900"></div>
              </div>
              <img 
                :src="currentRecord.image_url2" 
                class="w-full h-full object-contain" 
                alt="画像2"
                @error="handleImageError"
                @load="imageLoaded(2)"
              >
            </div>
            <button 
              @click="selectImage(2)" 
              class="select-button mt-3 w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
            >
              この画像を選ぶ
            </button>
          </div>
        </div>
      </div>

      <div v-else class="no-records text-center py-10">
        <p class="text-gray-600">表示する画像がありません。</p>
      </div>
    </div>
  </authenticated-layout>
</template>