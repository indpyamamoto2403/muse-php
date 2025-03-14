<script setup lang="ts">
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Score } from '@/Types/Evaluation';

const props = defineProps<{
  score: Score;
}>();

const showEmailModal = ref(false);
const { props: pageProps } = usePage();

const emailForm = useForm({
  email: pageProps.auth.user.email || '',
  subject: 'スコア評価レポート',
});

const emailSent = ref(false);
const errorMessage = ref('');

const openEmailModal = () => {
  showEmailModal.value = true;
};

const closeEmailModal = () => {
  showEmailModal.value = false;
  emailSent.value = false;
  errorMessage.value = '';
  emailForm.reset();
};



const sendEmail = () => {
  emailForm.post(route('send.email'), {
    preserveScroll: true,
    onSuccess: () => {
      emailSent.value = true;
      setTimeout(() => {
        closeEmailModal();
      }, 3000);
    },
    onError: (errors) => {
      errorMessage.value = Object.values(errors).join(', ');
    },
  });
};
</script>

<template>
  <div>
    <!-- メール送信ボタン -->
    <button
      @click="openEmailModal"
      class="px-4 py-2 mr-4 text-white bg-green-500 rounded hover:cursor-pointer hover:bg-green-600"
    >
      メールで送信
    </button>

    <!-- メール送信モーダル -->
    <div v-if="showEmailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">スコアレポートをメールで送信</h3>
        
        <div v-if="emailSent" class="p-4 mb-4 text-green-700 bg-green-100 rounded">
          メールが正常に送信されました。
        </div>
        
        <div v-if="errorMessage" class="p-4 mb-4 text-red-700 bg-red-100 rounded">
          {{ errorMessage }}
        </div>
        
        <form @submit.prevent="sendEmail">
          
          <p class="mb-4 text-sm text-gray-600">
            スコアリング結果をメールに送信いたします。<br>
          </p>
          
          <div class="flex justify-end mt-6 space-x-3">
            <button
              type="button"
              @click="closeEmailModal"
              class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
            >
              キャンセル
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
              :disabled="emailForm.processing"
            >
              {{ emailForm.processing ? '送信中...' : '送信' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
