<template>
  <div class="text-sm">進捗: {{ progress }}%</div>
</template>

<script setup lang="ts">
const props = defineProps<{
  progress: number;
}>();
</script>
