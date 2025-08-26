<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const level = ref('beginner');
function startExam() {
    router.get('/exam', { level: level.value });
}
</script>

<template>
    <div
        class="mx-auto mt-10 w-full max-w-md rounded-3xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white p-4 text-center shadow-2xl md:p-6 lg:p-8"
    >
        <h1 class="animate-fade-in mb-6 text-2xl font-black tracking-tight text-blue-800 drop-shadow-lg md:text-4xl">
            🚀 Ready to Test Your Laravel Skills?
        </h1>
        <div class="mb-6 grid gap-4 md:gap-6">
            <label
                v-for="opt in [
                    { value: 'beginner', label: 'Beginner', desc: 'Start here if you are new to Laravel.' },
                    { value: 'intermediate', label: 'Intermediate', desc: 'For those comfortable with the basics.' },
                    { value: 'advanced', label: 'Advanced', desc: 'Challenge yourself with expert-level questions.' },
                ]"
                :key="opt.value"
                class="group flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-blue-100 bg-white p-3 shadow-md transition hover:border-blue-400 hover:bg-blue-50 md:gap-5 md:p-5"
                :class="level === opt.value ? 'scale-105 border-blue-500 bg-blue-100 shadow-lg' : ''"
            >
                <input type="radio" :value="opt.value" v-model="level" class="h-5 w-5 accent-blue-600 transition duration-200 md:h-6 md:w-6" />
                <div class="text-left">
                    <span class="block text-lg font-bold text-blue-700 group-hover:text-blue-800 md:text-2xl">{{ opt.label }}</span>
                    <span class="mt-1 block text-xs text-gray-500 md:text-base">{{ opt.desc }}</span>
                </div>
            </label>
        </div>
        <button
            @click="startExam"
            class="mt-6 animate-bounce rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-2 text-lg font-extrabold text-white shadow-xl transition hover:from-blue-700 hover:to-blue-500 focus:ring-4 focus:ring-blue-300 focus:outline-none md:px-10 md:py-4 md:text-2xl"
        >
            Start Exam
        </button>
        <div class="animate-fade-in mt-6 text-xs text-gray-400 md:text-sm">No signup required. Just pick your level and go!</div>
        <div class="mt-4">
            <a href="/questions/manage" class="text-blue-600 hover:underline">Manage Questions</a>
        </div>
    </div>
</template>
