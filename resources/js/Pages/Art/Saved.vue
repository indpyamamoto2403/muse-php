<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ArtCard from '@/Components/ArtCard.vue';
const props = defineProps({
  arts: Array,
});

const filteredArts = ref(props.arts);

// 必要に応じて絞り込み検索などの機能を実装可能
</script>

<template>
  <Head title="お気に入り作品" />
  
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl leading-tight">
        Saved
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div v-if="filteredArts.length === 0" class="text-center py-8">
              <p class="text-gray-500">お気に入りに追加した作品はまだありません</p>
            </div>
            
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <ArtCard 
                v-for="art in filteredArts" 
                :key="art.id" 
                :art="art" 
                class="h-full"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
