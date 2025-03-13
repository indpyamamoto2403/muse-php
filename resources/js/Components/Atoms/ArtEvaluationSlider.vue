<script setup lang="ts">

const props = defineProps({
  label: {
    type: String,
    required: true
  },
  value: {
    type: Number,
    required: true
  },
  min: {
    type: Number,
    default: 1
  },
  max: {
    type: Number,
    default: 5
  }
});

const emit = defineEmits(['update:value']);

const handleInput = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:value', Number(target.value));
};
</script>

<template>
  <div class="mb-4">
    <label 
      :for="label.toLowerCase().replace(/\s+/g, '-')" 
      class="block font-semibold mb-1"
    >
      {{ label }}: {{ value }}
    </label>
    <input
      type="range"
      :id="label.toLowerCase().replace(/\s+/g, '-')"
      :value="value"
      @input="handleInput"
      :min="min"
      :max="max"
      step="1"
      class="w-full h-2 rounded-lg cursor-pointer appearance-none"
    />
  </div>
</template>