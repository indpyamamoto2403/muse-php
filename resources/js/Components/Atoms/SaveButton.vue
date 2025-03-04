<template>
  <button 
    @click.stop="handleSave"
    class="p-2 rounded-full transition-all duration-300 relative group"
    :class="isSaved ? 'text-blue-500 hover:bg-blue-100' : 'text-gray-500 hover:bg-gray-100'"
    aria-label="保存"
  >
    <!-- Background hover effect -->
    <span 
      v-if="isSaved" 
      class="absolute inset-0 bg-blue-100 opacity-0 group-hover:opacity-30 rounded-full"
    ></span>
    
    <svg 
      xmlns="http://www.w3.org/2000/svg" 
      class="h-6 w-6 transition-transform duration-300 transform"
      :class="[
        isAnimating ? 'scale-125' : 'scale-100',
        isSaved ? 'fill-current' : 'fill-none'
      ]"
      viewBox="0 0 24 24" 
      stroke="currentColor"
    >
      <path 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        :stroke-width="isSaved ? 1.5 : 2" 
        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" 
      />
    </svg>
    
    <!-- Animation effect when saving -->
    <span 
      v-if="isAnimating && isSaved" 
      class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-8 h-8 pointer-events-none"
    >
      <span 
        class="absolute inset-0 rounded-full bg-blue-500 opacity-20 animate-ping"
        style="animation-duration: 0.8s; animation-iteration-count: 1;"
      ></span>
    </span>
  </button>
</template>

<script setup lang="ts">
import { ref, Ref } from 'vue';
import axios from 'axios';

const props = defineProps<{
  artId: number;
  isSaved: boolean;
}>();

const isSaved: Ref<boolean> = ref(props.isSaved);
const isAnimating: Ref<boolean> = ref(false);

const handleSave = () => {
  isAnimating.value = true;
  isSaved.value = !isSaved.value;
  
  axios.post(route('save', {
    artId: props.artId,
    isSaved: isSaved.value,
  }));
  
  // Reset animation after completion
  setTimeout(() => {
    isAnimating.value = false;
  }, 800);
};
</script>