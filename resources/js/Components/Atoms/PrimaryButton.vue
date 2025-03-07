<template>
  <button
    :type="type"
    @click="onClick"
    :class="[
      'px-4 py-2 rounded',
      isDisabled ? 'bg-gray-200 text-gray-700 disabled:opacity-50' : 'bg-blue-500 text-white hover:bg-blue-600'
    ]"
    :disabled="isDisabled"
  >
    <slot></slot>
  </button>
</template>

<script setup lang="ts">
export default {
  name: 'PrimaryButton'
};
const props = defineProps<{
  type: string;
  isDisabled: boolean;
}>();

const emit = defineEmits(['click']);

function onClick() {
  emit('click');
}
</script>
