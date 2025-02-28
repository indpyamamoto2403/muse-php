<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Art } from '@/Types/Art';
import { Evaluation } from '@/Types/Evaluation';

interface ArtEvaluation extends Art, Evaluation {}


/**
 * フォームデータとバリデーション用に useForm を初期化
 */
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

/**
 * 画像プレビューURL
 */
const imagePreview = ref<string | null>(null);

/**
 * ファイル入力イベントハンドラ
 */
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

/**
 * スライダー色 (1～5) に応じて青系グラデーションを返す（単色 or 段階的に変化）
 * ここでは 5 段階の離散値を簡易的に切り替え
 */
function getBlueShade(value: number) {
  switch (value) {
    case 1: return '#cce4ff'; // 一番淡い青
    case 2: return '#99c9ff';
    case 3: return '#66adff'; // 中間
    case 4: return '#3392ff';
    case 5: return '#0077ff'; // 一番濃い青
  }
  return '#66adff'; // 万が一のデフォルト
}

/**
 * スライダーの値 (1～5) に応じて、"塗られた部分" と "未塗の部分" を分ける線形グラデーションを生成
 */
function sliderStyle(value: number) {
  const percent = ((value - 1) / 4) * 100;
  const color = getBlueShade(value);

  return {
    background: `linear-gradient(to right, ${color} 0%, ${color} ${percent}%, #e2e8f0 ${percent}%, #e2e8f0 100%)`,
  };
}

/**
 * フォーム送信
 */
const registerArt = async () => {
  try {
    await form.post(route('art.create'), {
      onSuccess: () => {
        // 成功時:フォームリセット
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
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Register Art
    </template>
    <div class="w-9/12 p-4 bg-sky-950">
      <!-- フォーム本体 -->
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

        <!-- 9つのスライダー -->
        <!-- 1. 作風 (具象性〜抽象性) -->
        <div class="mb-4">
          <label for="style" class="block font-semibold mb-1">
            作風 (具象性 - 抽象性): {{ form.style }}
          </label>
          <input
            type="range"
            id="style"
            v-model="form.style"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.style)"
          />
        </div>

        <!-- 2. 伝統的 - 革新的 -->
        <div class="mb-4">
          <label for="traditionInnovation" class="block font-semibold mb-1">
            伝統的 - 革新的: {{ form.traditionInnovation }}
          </label>
          <input
            type="range"
            id="traditionInnovation"
            v-model="form.traditionInnovation"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.traditionInnovation)"
          />
        </div>

        <!-- 3. 内省的 - 感情的 -->
        <div class="mb-4">
          <label for="introspectiveEmotional" class="block font-semibold mb-1">
            内省的 - 感情的: {{ form.introspectiveEmotional }}
          </label>
          <input
            type="range"
            id="introspectiveEmotional"
            v-model="form.introspectiveEmotional"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.introspectiveEmotional)"
          />
        </div>

        <!-- 4. 色彩感覚 (落ち着き - 大胆) -->
        <div class="mb-4">
          <label for="colorSense" class="block font-semibold mb-1">
            色彩感覚 (落ち着き - 大胆): {{ form.colorSense }}
          </label>
          <input
            type="range"
            id="colorSense"
            v-model="form.colorSense"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.colorSense)"
          />
        </div>

        <!-- 5. 構図 (静的 - 動的) -->
        <div class="mb-4">
          <label for="composition" class="block font-semibold mb-1">
            構図 (静的 - 動的): {{ form.composition }}
          </label>
          <input
            type="range"
            id="composition"
            v-model="form.composition"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.composition)"
          />
        </div>

        <!-- 6. 技法 (伝統的 - 革新的) -->
        <div class="mb-4">
          <label for="technique" class="block font-semibold mb-1">
            技法 (伝統的 - 革新的): {{ form.technique }}
          </label>
          <input
            type="range"
            id="technique"
            v-model="form.technique"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.technique)"
          />
        </div>

        <!-- 7. テーマ性 (低い - 高い) -->
        <div class="mb-4">
          <label for="theme" class="block font-semibold mb-1">
            テーマ性 (低い - 高い): {{ form.theme }}
          </label>
          <input
            type="range"
            id="theme"
            v-model="form.theme"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.theme)"
          />
        </div>

        <!-- 8. エネルギー (静的 - 動的) -->
        <div class="mb-4">
          <label for="energy" class="block font-semibold mb-1">
            エネルギー (静的 - 動的): {{ form.energy }}
          </label>
          <input
            type="range"
            id="energy"
            v-model="form.energy"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.energy)"
          />
        </div>

        <!-- 9. 全体の独自性・創造性 (伝統的 - 独創的) -->
        <div class="mb-4">
          <label for="uniqueness" class="block font-semibold mb-1">
            全体の独自性・創造性 (伝統的 - 独創的): {{ form.uniqueness }}
          </label>
          <input
            type="range"
            id="uniqueness"
            v-model="form.uniqueness"
            min="1"
            max="5"
            step="1"
            class="w-full h-2 rounded-lg cursor-pointer appearance-none"
            :style="sliderStyle(form.uniqueness)"
          />
        </div>

        <!-- Submit ボタン -->
        <div class="mt-6 text-right">
          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold
                     py-2 px-6 rounded disabled:opacity-70"
          >
            登録
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
