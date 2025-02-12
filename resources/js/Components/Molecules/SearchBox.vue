<template>
    <div>
      <input 
        type="text" 
        placeholder="Search" 
        class="w-full p-2 border border-gray-300 rounded-lg my-3" 
        v-model="searchQuery"
      />
      <div class="space-x-4 mb-4">
        <button 
          @click="handleSearch" 
          class="bg-gray-200 rounded-lg p-2 shadow-lg"
        >
          Search🔍
        </button>
        <button 
          @click="handleClear" 
          class="bg-gray-200 rounded-lg p-2 shadow-lg"
        >
          Clear🔄
        </button>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue';
  //tes
  const searchQuery = ref('');
  
  const emit = defineEmits(['search', 'clear']);
  
  const handleSearch = () => {
    emit('search', searchQuery.value);
  };

const handleClear = () => {
    searchQuery.value = '';
    emit('clear');
  };

  </script>