<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    role: user.role,
    occupation: user.occupation || '',
    self_introduction: user.self_introduction || '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                プロフィール情報
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                アカウントのプロフィール情報とメールアドレスを更新してください。
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="メールアドレス" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="role" value="役割" />

                <select
                    id="role"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                    v-model="form.role"
                    required
                >
                    <option value="company">企業</option>
                    <option value="artist">芸術家</option>
                </select>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div>
                <InputLabel for="occupation" value="職業" />

                <TextInput
                    id="occupation"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.occupation"
                    required
                    autocomplete="occupation"
                />

                <InputError class="mt-2" :message="form.errors.occupation" />
            </div>

            <div>
                <InputLabel for="self_introduction" value="自己紹介" />

                <textarea
                    id="self_introduction"
                    class="mt-1 block w-full min-h-[200px] rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="form.self_introduction"
                    required
                    autocomplete="self_introduction"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.self_introduction" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    メールアドレスが未確認です。
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        確認メールを再送信するにはここをクリックしてください。
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    新しい確認リンクがメールアドレスに送信されました。
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">保存</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        保存しました。
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
