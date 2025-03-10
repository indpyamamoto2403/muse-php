<!-- File: ImageSelectionOption.vue -->
<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps<{
  imageUrl: string,
  altText: string,
  selectionValue: boolean,
}>();

const emit = defineEmits<{
  (e: 'select', value: boolean): void;
}>();

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  target.src = '/images/placeholder.png';
};

const handleClick = () => {
  emit('select', props.selectionValue);
};
</script>

<template>
  <div class="image-option relative">
    <div class="image-container h-64 md:h-80 lg:h-96 relative overflow-hidden bg-gray-100 rounded border border-gray-200">
      <img 
        :src="imageUrl" 
        :alt="altText"
        class="w-full h-full object-contain" 
        @error="handleImageError"
      >
    </div>
    <button 
      @click="handleClick" 
      class="select-button mt-3 w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
    >
      この画像を選ぶ
    </button>
  </div>
</template>
