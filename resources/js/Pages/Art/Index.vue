<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ArtGallery from '@/Components/Organisms/ArtGallery.vue';
import { Art } from '@/Types/Art';
import SearchBox from '@/Components/Molecules/SearchBox.vue';
import { ref, computed } from 'vue';

// 親から渡されるプロップス
const props = defineProps<{
  arts: Art[];
}>();

const searchQuery = ref('');

const filteredArts = computed(() => {
  if (!searchQuery.value) {
    return props.arts; // 検索クエリが空の場合は全てのアートを返す
  }
  return props.arts.filter(art => {
    const title = art.title?.toLowerCase() || ''; // nullやundefinedを空文字列にフォールバック

    return title.includes(searchQuery.value.toLowerCase());
  });
});

/**
 * 検索ボックスをクリアするハンドラー
 */
const handleClear = () => {
  searchQuery.value = '';
};

/**
 * 検索ボックスから検索クエリを受け取るハンドラー
 */
const handleSearch = (query: string) => {
  searchQuery.value = query;
};

console.log(props.arts);

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
