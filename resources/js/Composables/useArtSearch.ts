// composables/useArtSearch.ts
import { Ref, computed, ref } from 'vue';
import { Art } from '@/Types/Art';

export function useArtSearch(arts: Ref<Art[]>) {
  const searchQuery = ref('');

  const filteredArts = computed(() => {
    if (!searchQuery.value) return arts.value;
    
    const query = searchQuery.value.toLowerCase();
    return arts.value.filter(art => {
      const title = art.title?.toLowerCase() || '';
      return title.includes(query);
    });
  });

  const handleSearch = (query: string) => {
    searchQuery.value = query;
  };

  const handleClear = () => {
    searchQuery.value = '';
  };

  return {
    filteredArts,
    handleSearch,
    handleClear
  };
}