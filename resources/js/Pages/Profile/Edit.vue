<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateIconForm from './Partials/UpdateIconForm.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },

});


</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            Profile
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>



                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateIconForm class="max-w-xl" />
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>
