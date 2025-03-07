<template>
  <button
    @click="onClick"
    :class="[
      'w-3 h-3 rounded-full',
      isActive ? 'bg-blue-500' : 'bg-gray-300',
      isAnswered ? 'ring-2 ring-blue-300' : ''
    ]"
  ></button>
</template>

<script setup lang="ts">
export default {
  name: 'QuestionNavigationButton'
};
const props = defineProps<{
  isActive: boolean;
  isAnswered: boolean;
}>();

const emit = defineEmits(['click']);

function onClick() {
  emit('click');
}
</script>
