<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ArtEvaluationSlider from '@/Components/Atoms/ArtEvaluationSlider.vue';
import { Art } from '@/Types/Art';
import { Evaluation } from '@/Types/Evaluation';

interface ArtEvaluation extends Art, Evaluation {}

// Form initialization remains the same
const form = useForm({
  title: '',
  description: '',
  image: null as File | null,

  style: 3,                 // 作風 (具象性〜抽象性)
  traditionInnovation: 3,   // 伝統的〜革新的
  introspectiveEmotional: 3,// 内省的〜感情的
  colorSense: 3,            // 色彩感覚 (落ち着き〜大胆)
  composition: 3,           // 構図 (静的〜動的)
  technique: 3,             // 技法 (伝統的〜革新的)
  theme: 3,                 // テーマ性 (低い〜高い)
  energy: 3,                // エネルギー (静的〜動的)
  uniqueness: 3,            // 全体の独自性・創造性 (伝統的〜独創的)
});

// Image preview logic remains the same
const imagePreview = ref<string | null>(null);

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files.length > 0) {
    form.image = target.files[0];

    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target?.result as string;
    };
    reader.readAsDataURL(target.files[0]);
  } else {
    imagePreview.value = null;
  }
};

// Form submission logic remains the same
const registerArt = async () => {
  try {
    await form.post(route('art.create'), {
      onSuccess: () => {
        form.reset(
          'title',
          'description',
          'image',
          'style',
          'traditionInnovation',
          'introspectiveEmotional',
          'colorSense',
          'composition',
          'technique',
          'theme',
          'energy',
          'uniqueness'
        );
        imagePreview.value = null;
        alert('登録が完了しました');
      },
      onError: (errors) => {
        console.error('Validation errors:', errors);
      },
    });
  } catch (error) {
    console.error('An unexpected error occurred:', error);
  }
};

// Slider configurations
const sliderConfigs = [
  { 
    key: 'style', 
    label: '作風 (具象性 - 抽象性)' 
  },
  { 
    key: 'traditionInnovation', 
    label: '伝統的 - 革新的' 
  },
  { 
    key: 'introspectiveEmotional', 
    label: '内省的 - 感情的' 
  },
  { 
    key: 'colorSense', 
    label: '色彩感覚 (落ち着き - 大胆)' 
  },
  { 
    key: 'composition', 
    label: '構図 (静的 - 動的)' 
  },
  { 
    key: 'technique', 
    label: '技法 (伝統的 - 革新的)' 
  },
  { 
    key: 'theme', 
    label: 'テーマ性 (低い - 高い)' 
  },
  { 
    key: 'energy', 
    label: 'エネルギー (静的 - 動的)' 
  },
  { 
    key: 'uniqueness', 
    label: '全体の独自性・創造性 (伝統的 - 独創的)' 
  }
];
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Register Art
    </template>
    <div class="w-9/12 p-4 bg-sky-950">
      <form @submit.prevent="registerArt" class="bg-slate-300 p-6 rounded shadow w-4xl">
        <!-- Title -->
        <div class="mb-4">
          <label for="title" class="block mb-1 font-semibold">タイトル</label>
          <input
            type="text"
            id="title"
            v-model="form.title"
            class="border border-gray-300 rounded w-full p-2
                   focus:outline-none focus:ring focus:border-blue-300"
          />
          <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">
            {{ form.errors.title }}
          </div>
        </div>

        <!-- Description -->
        <div class="mb-4">
          <label for="description" class="block mb-1 font-semibold">説明</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            class="border border-gray-300 rounded w-full p-2
                   focus:outline-none focus:ring focus:border-blue-300"
          ></textarea>
          <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
            {{ form.errors.description }}
          </div>
        </div>

        <!-- Image -->
        <div class="mb-4">
          <label for="image" class="block mb-1 font-semibold">画像ファイル</label>
          <input
            type="file"
            id="image"
            @change="handleFileChange"
            class="block w-full text-sm text-gray-900
                   border border-gray-300 rounded cursor-pointer
                   focus:outline-none focus:ring focus:border-blue-300"
          />
          <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">
            {{ form.errors.image }}
          </div>

          <!-- プレビュー表示 -->
          <div class="mt-3">
            <img
              v-if="imagePreview"
              :src="imagePreview"
              alt="Preview"
              class="w-48 h-auto rounded-md shadow"
            />
          </div>
        </div>

        <!-- Slider Components -->
        <ArtEvaluationSlider
          v-for="config in sliderConfigs"
          :key="config.key"
          :label="config.label"
          :value="form[config.key as keyof typeof form]"
          @update:value="(newValue) => form[config.key as keyof typeof form] = newValue"
        />

        <!-- Submit ボタン -->
        <div class="mt-6 text-right">
          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded disabled:opacity-70"
          >
            登録
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>