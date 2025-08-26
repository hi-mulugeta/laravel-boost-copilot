<template>
    <div
        class="mx-auto mt-20 flex min-h-[60vh] w-full max-w-md flex-col items-center justify-center rounded-2xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white p-8 text-center shadow-2xl"
    >
        <svg class="mx-auto mb-6 h-16 w-16 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 17v-2a4 4 0 0 1 8 0v2m-4-6a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm6 2a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"
            />
        </svg>
        <h2 class="mb-4 text-2xl font-bold text-blue-700">No Exam Available</h2>
        <p class="mb-6 text-gray-600">
            Sorry, there are no questions for the <span class="font-semibold text-blue-600">{{ level }}</span> level right now.
        </p>
        <a
            href="/exam/select"
            class="rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-3 font-bold text-white shadow-lg transition hover:from-blue-700 hover:to-blue-500"
            >Choose Another Level</a
        >
    </div>
</template>
<script setup lang="ts">
defineProps<{ level: string }>();
</script>
