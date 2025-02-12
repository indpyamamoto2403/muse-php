<template>
  <img :src="src" :alt="alt" class="mt-2 w-full h-64 object-cover rounded-lg shadow-md transition duration-300 hover:opacity-90">
</template>

<script setup lang="ts">
const props = defineProps<{
  src: string;
  alt: string;
}>();
</script>
