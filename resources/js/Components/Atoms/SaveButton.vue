<template>
  <button 
    @click.stop="handleSave"
    class="p-2 hover:bg-gray-100 rounded-full transition-colors"
    :class="isSaved ? 'text-blue-500' : 'text-gray-500'"
    aria-label="保存"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
    </svg>
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

const handleSave = () => {
  isSaved.value = !isSaved.value;
  axios.post(route('save', {
    artId: props.artId,
    isSaved: isSaved.value,
  }));
};
</script>
