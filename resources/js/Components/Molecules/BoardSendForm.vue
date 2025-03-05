<script setup lang="ts">
import { ref } from 'vue';  

const content = ref('');
const emit = defineEmits(['submit']);
function submit() {

    emit('submit', content.value);
    content.value = '';
}

</script>

<template>
    <form @submit.prevent="submit" class="w-full px-3">
        <div class="flex gap-4">
        <input
            type="text"
            v-model="content"
            class="w-full border border-gray-300 rounded-lg p-2"
            placeholder="メッセージを入力"
        />
        <button
            type="submit"
            class="bg-blue-500 text-white rounded-lg px-4 py-2 w-[80px]"
        >
            送信
        </button>
        </div>
    </form>
</template>