<template>
  <button 
    @click="onClick" 
    class="select-button mt-3 w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition"
  >
    <slot></slot>
  </button>
</template>

<script setup lang="ts">
const props = defineProps<{ onClick: () => void }>();
</script>

<style scoped>
.select-button {
  /* Add any specific styles here */
}
</style>
