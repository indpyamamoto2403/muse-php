<script setup lang="ts">
import ArtCard from '@/Components/Molecules/ArtCard.vue';
import { Art } from '@/Types/Art';
import axios from 'axios';
import { ref, defineProps, computed } from 'vue';
import ArtDetailModal from '@/Components/Organisms/ArtDetailModal.vue';
const props = defineProps<{
  arts: Art[];
}>();

const activeArt = ref<Art | null>(null);

function handleOpenBoardModal(artId: number) {
  activeArt.value = props.arts.find((art) => art.id === artId) || null;
}

const selectedArt = computed(() => {
  return activeArt.value ? props.arts.find((art) => art.id === activeArt.value.id) : null;
});

function handleCloseDetailModal() {
  activeArt.value = null;
}

  
</script>

<template>
  <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <ArtCard
      v-for="art in arts"
      :key="art.id"
      :artId="art.id"
      :title="art.title"
      :description="art.description"
      :imageUrl="art.image_url"
      :user="art.user"
      :likes="art.likes"
      :saves="art.saves"
      @openBoardModal="handleOpenBoardModal"
    />
  </ul>
  <ArtDetailModal 
  :art="selectedArt" 
  v-if="selectedArt"
  @closeDetailModal="handleCloseDetailModal"
  />
</template>

