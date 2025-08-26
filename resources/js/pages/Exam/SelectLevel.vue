<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const level = ref('beginner');
function startExam() {
    router.get('/exam', { level: level.value });
}
</script>

<template>
    <div class="mx-auto mt-20 max-w-lg rounded-3xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white p-10 text-center shadow-2xl">
        <h1 class="animate-fade-in mb-10 text-4xl font-black tracking-tight text-blue-800 drop-shadow-lg">🚀 Ready to Test Your Laravel Skills?</h1>
        <div class="mb-10 grid gap-6">
            <label
                v-for="opt in [
                    { value: 'beginner', label: 'Beginner', desc: 'Start here if you are new to Laravel.' },
                    { value: 'intermediate', label: 'Intermediate', desc: 'For those comfortable with the basics.' },
                    { value: 'advanced', label: 'Advanced', desc: 'Challenge yourself with expert-level questions.' },
                ]"
                :key="opt.value"
                class="group flex cursor-pointer items-center gap-5 rounded-2xl border-2 border-blue-100 bg-white p-5 shadow-md transition hover:border-blue-400 hover:bg-blue-50"
                :class="level === opt.value ? 'scale-105 border-blue-500 bg-blue-100 shadow-lg' : ''"
            >
                <input type="radio" :value="opt.value" v-model="level" class="h-6 w-6 accent-blue-600 transition duration-200" />
                <div class="text-left">
                    <span class="block text-2xl font-bold text-blue-700 group-hover:text-blue-800">{{ opt.label }}</span>
                    <span class="mt-1 block text-base text-gray-500">{{ opt.desc }}</span>
                </div>
            </label>
        </div>
        <button
            @click="startExam"
            class="mt-8 animate-bounce rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-10 py-4 text-2xl font-extrabold text-white shadow-xl transition hover:from-blue-700 hover:to-blue-500 focus:ring-4 focus:ring-blue-300 focus:outline-none"
        >
            Start Exam
        </button>
        <div class="animate-fade-in mt-8 text-sm text-gray-400">No signup required. Just pick your level and go!</div>
    </div>
</template>
