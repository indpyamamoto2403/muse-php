<!-- resources/js/Pages/Profile/Partials/UpdateIconForm.vue -->
<script setup>
import { useForm,usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import VueCropper from 'vue-cropperjs';
import 'cropperjs/dist/cropper.css';

const props = defineProps({
    user: Object,
});

const form = useForm({
    icon: null,
});

const showCropper = ref(false);
const cropper = ref(null);
const imageSrc = ref('');
const page = usePage();
const previewSrc = ref(page.props.auth.user.icon_url ?? "");
console.log(props.user);
// ファイル選択時の処理
const onFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
        imageSrc.value = event.target.result;
        showCropper.value = true;
    };
    reader.readAsDataURL(file);
};

// 切り抜き処理
const cropImage = () => {
    cropper.value.getCroppedCanvas({
        width: 256,
        height: 256,
        fillColor: '#fff',
        imageSmoothingQuality: 'high',
    }).toBlob((blob) => {
        const file = new File([blob], 'icon.png', { type: 'image/png' });
        form.icon = file;
        previewSrc.value = URL.createObjectURL(blob);
        showCropper.value = false;
    });
};

const submit = () => {
    form.post(route('user-icon.set'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            previewSrc.value = props.user.icon_url;
        },
        onError: () => {
            if (form.errors.icon) {
                form.reset('icon');
                previewSrc.value = props.user.icon_url;
            }
        },
    });
};
</script>

<template>
    <div class="max-w-xl">
        <h2 class="text-lg font-medium text-gray-900">プロフィールアイコン</h2>

        <div class="mt-6 space-y-6">
            <!-- プレビュー表示 -->
            <div class="flex items-center gap-6">
                <div 
                    class="w-32 h-32 rounded-full bg-gray-100 border-2 border-gray-300 overflow-hidden"
                    :style="{ backgroundImage: `url(${previewSrc})` }"
                    :class="{ 'bg-cover': previewSrc }"
                >
                    <img 
                        v-if="previewSrc" 
                        :src="previewSrc" 
                        class="w-full h-full object-cover"
                        alt="Current icon"
                    />
                </div>
                
                <div class="flex flex-col gap-2">
                    <input
                        id="icon"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        @change="onFileChange"
                    />
                    <label 
                        for="icon"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer"
                    >
                        画像を選択
                    </label>
                    <button
                        v-if="previewSrc"
                        type="button"
                        @click="previewSrc = null; form.icon = null"
                        class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-500"
                    >
                        アイコンを削除
                    </button>
                </div>
            </div>

            <!-- 切り抜きモーダル -->
            <div v-if="showCropper" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg max-w-2xl">
                    <div class="max-h-[70vh] overflow-auto">
                        <vue-cropper
                            ref="cropper"
                            :src="imageSrc"
                            :aspect-ratio="1"
                            :view-mode="2"
                            :guides="true"
                            :background="false"
                            :auto-crop-area="0.8"
                            drag-mode="move"
                        ></vue-cropper>
                    </div>
                    
                    <div class="mt-4 flex justify-end gap-3">
                        <button
                            type="button"
                            @click="showCropper = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                        >
                            キャンセル
                        </button>
                        <button
                            type="button"
                            @click="cropImage"
                            class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                        >
                            適用
                        </button>
                    </div>
                </div>
            </div>

            <!-- 保存ボタン -->
            <div class="flex items-center gap-4">
                <PrimaryButton 
                    :disabled="form.processing || !form.icon"
                    @click="submit"
                >
                    保存
                </PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">保存しました</p>
                </Transition>
            </div>
            
            <InputError class="mt-2" :message="form.errors.icon" />
        </div>
    </div>
</template>