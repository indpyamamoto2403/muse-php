<template>
  <div class="image-selection-area grid grid-cols-1 md:grid-cols-2 gap-6">
    <ImageOption 
      :src="currentRecord.image_url1" 
      :onSelect="() => selectImage(true)"
    >
      この画像を選ぶ
    </ImageOption>
    <ImageOption 
      :src="currentRecord.image_url2" 
      :onSelect="() => selectImage(false)"
    >
      この画像を選ぶ
    </ImageOption>
  </div>
</template>

<script setup lang="ts">
import ImageOption from '../Molecules/ImageOption.vue';

const props = defineProps<{ currentRecord: ImageRecord }>();
const selectImage = (isFormerSelected: boolean) => {
  // Logic for selecting image
};
</script>

<style scoped>
/* Add any specific styles here */
</style>
