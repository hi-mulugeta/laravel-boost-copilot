<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, reactive, ref } from 'vue';

interface Question {
    id: number;
    title: string;
    description: string;
    choice_a: string;
    choice_b: string;
    choice_c: string;
    choice_d: string;
    correct_choice: string;
}

interface Exam {
    id: number;
    name: string;
    questions: Question[];
}

const props = defineProps<{ exam: Exam }>();
const answers = reactive<Record<number, string>>({});

const current = ref(0);
const total = props.exam.questions.length;

// Timer logic
const timer = ref(180); // 3 minutes in seconds
const timerActive = ref(true);
let interval: number | undefined;

function formatTime(s: number) {
    const m = Math.floor(s / 60)
        .toString()
        .padStart(2, '0');
    const sec = (s % 60).toString().padStart(2, '0');
    return `${m}:${sec}`;
}

function autoSubmit() {
    if (timerActive.value) {
        timerActive.value = false;
        submit();
    }
}

onMounted(() => {
    interval = window.setInterval(() => {
        if (timer.value > 0) {
            timer.value--;
        } else {
            autoSubmit();
        }
    }, 1000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});

function next() {
    if (current.value < total - 1) current.value++;
}

function prev() {
    if (current.value > 0) current.value--;
}

function submit() {
    timerActive.value = false;
    if (interval) clearInterval(interval);
    router.post('/exam/submit', {
        exam_id: props.exam.id,
        answers,
    });
}
</script>

<template>
    <div class="mx-auto mt-5 max-w-xl rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-8 shadow-2xl">
        <h1 class="mb-8 text-center text-4xl font-black tracking-tight text-blue-800 drop-shadow">Laravel Beginner Exam</h1>
        <div class="mb-6 flex justify-center">
            <div class="flex animate-pulse items-center gap-3 rounded-full border border-blue-300 bg-blue-100 px-6 py-2 shadow">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                </svg>
                <span class="text-xl font-bold tracking-widest text-blue-700">{{ formatTime(timer) }}</span>
            </div>
        </div>
        <form @submit.prevent="submit" class="mt-12 flex flex-col items-center">
            <div class="w-full">
                <div class="mb-10">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-base font-medium text-blue-600 shadow"
                            >Question {{ current + 1 }} of {{ total }}</span
                        >
                        <div class="flex gap-2">
                            <button
                                type="button"
                                @click="prev"
                                :disabled="current === 0"
                                class="rounded-full bg-gray-100 px-4 py-2 font-semibold text-gray-700 shadow transition hover:bg-gray-200 disabled:opacity-40"
                            >
                                Prev
                            </button>
                            <button
                                type="button"
                                @click="next"
                                :disabled="current === total - 1"
                                class="rounded-full bg-gray-100 px-4 py-2 font-semibold text-gray-700 shadow transition hover:bg-gray-200 disabled:opacity-40"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                    <div class="rounded-xl border border-blue-200 bg-white p-8 shadow-lg">
                        <h2 class="mb-3 text-2xl font-bold text-blue-700">{{ props.exam.questions[current].title }}</h2>
                        <p class="mb-6 text-lg text-gray-700">{{ props.exam.questions[current].description }}</p>
                        <div class="grid gap-5">
                            <label
                                v-for="choice in ['a', 'b', 'c', 'd']"
                                :key="choice"
                                class="flex cursor-pointer items-center gap-4 rounded-xl border border-blue-100 bg-blue-50 p-3 shadow-sm transition hover:bg-blue-200"
                            >
                                <input
                                    type="radio"
                                    :name="`q${props.exam.questions[current].id}`"
                                    v-model="answers[props.exam.questions[current].id]"
                                    :value="choice"
                                    class="h-5 w-5 accent-blue-600"
                                />
                                <span class="text-lg font-medium text-gray-900">{{
                                    (props.exam.questions[current] as any)[`choice_${choice}`]
                                }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex items-center justify-between">
                    <div class="flex-1">
                        <div class="h-3 rounded-full bg-gray-200">
                            <div
                                class="h-3 rounded-full bg-blue-500 transition-all duration-300"
                                :style="{ width: ((current + 1) / total) * 100 + '%' }"
                            ></div>
                        </div>
                    </div>
                    <button
                        v-if="current === total - 1"
                        type="submit"
                        class="ml-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-3 font-bold text-white shadow-lg transition hover:from-blue-700 hover:to-blue-500"
                    >
                        Submit Exam
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
