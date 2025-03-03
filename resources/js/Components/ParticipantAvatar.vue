<template>
  <div class="flex flex-col items-center">
    <img
      :src="participant.user.icon_url"
      :alt="participant.user.name"
      class="avatar h-12 w-12 rounded-full border-2 border-white"
    />
    <div class="mt-2 text-center">
      <p class="text-sm font-medium text-gray-700">ID: {{ participant.user.id }}</p>
      <p class="text-xs text-gray-500">{{ participant.user.name }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

interface Participant {
  user: {
    id: number;
    name: string;
    icon_url: string;
  };
}

const props = defineProps<{
  participant: Participant;
}>();


</script>

<style scoped>
.avatar {
  @apply object-cover;
}
</style>
