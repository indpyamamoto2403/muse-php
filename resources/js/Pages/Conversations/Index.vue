<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ConversationList from '@/Components/ConversationList.vue';

const props = defineProps({
  conversations: Array,
});
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Conversations
    </template>
    <ConversationList :conversations="conversations" />
  </AuthenticatedLayout>
</template>
