<template>
  <div class="image-container h-64 md:h-80 lg:h-96 relative overflow-hidden bg-gray-100 rounded border border-gray-200">
    <LoadingSpinner v-if="loading" />
    <img 
      :src="src" 
      class="w-full h-full object-contain" 
      alt="画像"
      @error="handleError"
    >
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import LoadingSpinner from './LoadingSpinner.vue';

const props = defineProps<{ src: string }>();
const loading = ref(true);

const handleError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  target.src = '/images/placeholder.png';
};
</script>

<style scoped>
/* Add any specific styles here */
</style>
