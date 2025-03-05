<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ArtGallery from '@/Components/Organisms/ArtGallery.vue';
import { Art } from '@/Types/Art';
import SearchBox from '@/Components/Molecules/SearchBox.vue';
import { ref, computed, toRef } from 'vue';
import { useArtSearch } from '@/Composables/useArtSearch';


const props = defineProps<{
  arts: Art[];
}>();

const artsRef = toRef(props, 'arts');
const { filteredArts, handleSearch, handleClear } = useArtSearch(artsRef);
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Art Gallery
    </template>
    <!-- コンテナでレイアウト内に収める -->
    <div class="container mx-auto p-4">
      <!-- 検索ボックス -->
      <SearchBox 
        @search="handleSearch"
        @clear="handleClear"
      />
      <!-- フィルタリングされたアートを表示 -->
      <ArtGallery :arts="filteredArts" />
    </div>
  </AuthenticatedLayout>
</template>
