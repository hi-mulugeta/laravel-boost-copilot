<script setup lang="ts">
defineProps<{ score: number; total: number; percent: number; message: string }>();
</script>

<template>
    <div class="mx-auto mt-5 max-w-xl rounded-2xl border border-green-100 bg-gradient-to-br from-green-50 to-white p-8 text-center shadow-2xl">
        <h1 class="mb-6 text-4xl font-black tracking-tight text-green-700 drop-shadow">Exam Result</h1>
        <div class="mt-12 mb-4 text-2xl font-bold text-gray-800">
            You scored <span class="text-green-600">{{ score }}/{{ total }}</span> <span class="text-lg">({{ percent }}%)</span>
        </div>
        <div class="mb-6 text-xl font-semibold text-green-700">{{ message }}</div>
        <div class="mt-8 flex justify-center gap-4">
            <a
                href="/exam/select"
                class="rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-3 font-bold text-white shadow-lg transition hover:from-blue-700 hover:to-blue-500"
                >Try another exam</a
            >
        </div>
    </div>
</template>
