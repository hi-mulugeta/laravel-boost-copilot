<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const level = ref('beginner');
function startExam() {
    router.get('/exam', { level: level.value });
}
</script>

<template>
    <div class="mx-auto mt-16 max-w-md rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-8 text-center shadow-2xl">
        <h1 class="mb-8 text-3xl font-black text-blue-800">Choose Your Level</h1>
        <div class="mb-8 grid gap-4">
            <label class="flex cursor-pointer items-center justify-center gap-3">
                <input type="radio" value="beginner" v-model="level" class="accent-blue-600" />
                <span class="text-lg font-semibold text-blue-700">Beginner</span>
            </label>
            <label class="flex cursor-pointer items-center justify-center gap-3">
                <input type="radio" value="intermediate" v-model="level" class="accent-blue-600" />
                <span class="text-lg font-semibold text-blue-700">Intermediate</span>
            </label>
            <label class="flex cursor-pointer items-center justify-center gap-3">
                <input type="radio" value="advanced" v-model="level" class="accent-blue-600" />
                <span class="text-lg font-semibold text-blue-700">Advanced</span>
            </label>
        </div>
        <button
            @click="startExam"
            class="mt-6 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-3 font-bold text-white shadow-lg transition hover:from-blue-700 hover:to-blue-500"
        >
            Start Exam
        </button>
    </div>
</template>
