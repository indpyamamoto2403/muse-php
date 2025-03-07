<template>
  <label
    class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-blue-50"
    :class="isSelected ? 'bg-blue-100 border-blue-300' : ''"
  >
    <input
      type="radio"
      v-model="modelValue"
      :value="value"
      class="mr-2"
    />
    <slot></slot>
  </label>
</template>

<script setup lang="ts">
export default {
  name: 'RadioButton'
};
const props = defineProps<{
  modelValue: any;
  value: any;
  isSelected: boolean;
}>();

const emit = defineEmits(['update:modelValue']);

function updateValue(value: any) {
  emit('update:modelValue', value);
}
</script>
