<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
            Settings
        </template>
        <div class="space-y-10">
            <div
                class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
            >
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div
                class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
            >
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>