<script setup lang="ts">
import ImageComponent from '../Atoms/ImageComponent.vue';
import SelectButton from '../Atoms/SelectButton.vue';

const props = defineProps<{ src: string, onSelect: () => void }>();
</script>
<template>
  <div class="image-option relative">
    <ImageComponent :src="src" />
    <SelectButton :onClick="onSelect">
      <slot></slot>
    </SelectButton>
  </div>
</template>
