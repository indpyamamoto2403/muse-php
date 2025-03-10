<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ImageQuestionsTitle from '@/Components/Organisms/Questions/ImageQuestionsTitle.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NoImagesForQuestion from '@/Components/Organisms/Questions/NoImagesForQuestion.vue';
import ImageSelectionOption from '@/Components/Organisms/Questions/ImageSelectionOption.vue';
import CompleteImageSelection from '@/Components/Organisms/Questions/CompleteImageSelection.vue';
import { ImageQuestionRecord } from '@/Types/ImageQuestionRecord';


interface Props {
  images: ImageQuestionRecord[];
  submitUrl: string;
}

const props = defineProps<Props>();

const currentIndex = ref(0);
const form = useForm({
  selections: [] as { image_question_id: string, is_former_selected: boolean }[]
});
const currentRecord = ref<ImageQuestionRecord | null>(null);
const image1Loading = ref(true);
const image2Loading = ref(true);
const isCompleted = ref(false);

const updateCurrentRecord = () => {
  if (props.images && props.images.length > currentIndex.value) {
    currentRecord.value = props.images[currentIndex.value];
    image1Loading.value = true;
    image2Loading.value = true;
  } else {
    currentRecord.value = null;
  }
};

const selectImage = (isFormerSelected:boolean) => {
  if (!currentRecord.value) return;

  form.selections.push({
    image_question_id: currentRecord.value.id,
    is_former_selected: isFormerSelected
  });

  goToNextRecord();
};

const goToNextRecord = () => {
  if (props.images && currentIndex.value < props.images.length - 1) {
    currentIndex.value++;
    updateCurrentRecord();
  } else {
    submitSelections();
  }
};

const submitSelections = () => {
  console.log("Selections:", form.selections);

  form.post(route('questions.image.answerStore'), {
    onSuccess: () => {
      isCompleted.value = true;
    }
  });
};

onMounted(() => {
  updateCurrentRecord();
});
</script>

<template>
  <authenticated-layout>
    <template #header>
      画像選択アンケート
    </template>
    <div class="image-preference-container max-w-4xl mx-auto p-4 mt-12">
      <ImageQuestionsTitle :currentRecord="currentRecord" />

      <div v-if="isCompleted">
        <CompleteImageSelection />
      </div>
      <div v-else-if="currentRecord" class="selection-container">
        <div class="image-selection-area grid grid-cols-1 md:grid-cols-2 gap-6">
            <ImageSelectionOption 
              :imageUrl="currentRecord.image_url1"
              altText="画像1"
              :selectionValue="true"
              @select="selectImage"
            />
            <ImageSelectionOption 
              :imageUrl="currentRecord.image_url2"
              altText="画像2"
              :selectionValue="false"
              @select="selectImage"
            />
      </div>
    </div>
    <div v-else>
      <NoImagesForQuestion />
    </div>
  </div>
  </authenticated-layout>
</template>