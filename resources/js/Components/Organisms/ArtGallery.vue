<script setup lang="ts">
import ArtCard from '@/Components/Molecules/ArtCard.vue';
import { Art } from '@/Types/Art';
import axios from 'axios';

const props = defineProps<{
  arts: Art[];
}>();

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
    />
  </ul>
</template>

