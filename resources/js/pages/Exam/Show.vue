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

// Only 5 random questions
const shuffledQuestions = ref<Array<Question>>([]);
const current = ref<number>(0);
const total = ref<number>(5);
const transitioning = ref(false);

function shuffle(array: Question[]): Question[] {
    // Fisher-Yates shuffle
    const arr = array.slice();
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

onMounted(() => {
    shuffledQuestions.value = shuffle(props.exam.questions).slice(0, 5);
    total.value = shuffledQuestions.value.length;
    interval = window.setInterval(() => {
        if (timer.value > 0) {
            timer.value--;
        } else {
            autoSubmit();
        }
    }, 1000);
});

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
    if (current.value < total.value - 1) {
        transitioning.value = true;
        setTimeout(() => {
            // Defensive: only increment if next question exists
            if (shuffledQuestions.value[current.value + 1]) {
                current.value++;
            }
            transitioning.value = false;
        }, 400);
    }
}

function prev() {
    if (current.value > 0) {
        transitioning.value = true;
        setTimeout(() => {
            // Defensive: only decrement if previous question exists
            if (shuffledQuestions.value[current.value - 1]) {
                current.value--;
            }
            transitioning.value = false;
        }, 400);
    }
}

function submit() {
    timerActive.value = false;
    if (interval) clearInterval(interval);
    // Calculate score out of 5
    let score = 0;
    shuffledQuestions.value.forEach((q: Question) => {
        if (q && answers[q.id] === q.correct_choice) score++;
    });
    router.post('/exam/submit', {
        exam_id: props.exam.id,
        answers,
        score,
        total: shuffledQuestions.value.length,
        question_ids: shuffledQuestions.value.map((q) => q.id),
    });
}
</script>

<template>
    <div
        class="mx-auto mt-5 flex min-h-screen w-full max-w-lg flex-col justify-center rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-4 shadow-2xl md:p-6 lg:p-8"
    >
        <h1 class="mb-8 text-center text-4xl font-black tracking-tight text-blue-800 drop-shadow" aria-label="Exam Title">Laravel Beginner Exam</h1>
        <div class="mb-6 flex justify-center" aria-label="Timer">
            <div class="flex animate-pulse items-center gap-3 rounded-full border border-blue-300 bg-blue-100 px-6 py-2 shadow">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                </svg>
                <span class="text-xl font-bold tracking-widest text-blue-700" aria-live="polite">{{ formatTime(timer) }}</span>
            </div>
        </div>
        <form @submit.prevent="submit" class="mt-6 flex flex-col items-center" aria-label="Exam Form">
            <div class="mx-auto w-full max-w-md">
                <div class="mb-2 text-center text-sm font-medium text-gray-500" aria-label="Progress">
                    <span>Question {{ current + 1 }} of {{ total }}</span>
                </div>
                <Transition name="fade" mode="out-in" appear>
                    <div :key="current" v-if="shuffledQuestions[current]">
                        <div class="mb-4 flex items-center justify-between">
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-base font-medium text-blue-600 shadow"
                                >Question {{ current + 1 }} of {{ total }}</span
                            >
                            <div class="flex gap-2">
                                <button
                                    type="button"
                                    @click="prev"
                                    :disabled="current === 0"
                                    class="rounded-full bg-gray-100 px-4 py-2 font-semibold text-gray-700 shadow transition hover:bg-gray-200 focus:ring-2 focus:ring-blue-300 focus:outline-none disabled:opacity-40"
                                    aria-label="Previous Question"
                                >
                                    Prev
                                </button>
                                <button
                                    type="button"
                                    @click="next"
                                    :disabled="current === total - 1"
                                    class="rounded-full bg-gray-100 px-4 py-2 font-semibold text-gray-700 shadow transition hover:bg-gray-200 focus:ring-2 focus:ring-blue-300 focus:outline-none disabled:opacity-40"
                                    aria-label="Next Question"
                                >
                                    Next
                                </button>
                            </div>
                        </div>
                        <div class="rounded-xl border border-blue-200 bg-white p-4 shadow-lg md:p-6">
                            <h2 class="mb-2 text-xl font-bold text-blue-700 md:text-2xl" aria-label="Question Title">
                                {{ shuffledQuestions[current].title }}
                            </h2>
                            <p class="mb-4 text-base text-gray-700 md:text-lg" aria-label="Question Description">
                                {{ shuffledQuestions[current].description }}
                            </p>
                            <div class="grid gap-3 md:gap-4">
                                <label
                                    v-for="choice in ['a', 'b', 'c', 'd']"
                                    :key="choice"
                                    class="flex cursor-pointer items-center gap-3 rounded-xl border border-blue-100 bg-blue-50 p-2 shadow-sm transition hover:bg-blue-200 md:gap-4 md:p-3"
                                >
                                    <input
                                        type="radio"
                                        :name="`q${shuffledQuestions[current].id}`"
                                        v-model="answers[shuffledQuestions[current].id]"
                                        :value="choice"
                                        class="h-5 w-5 accent-blue-600 focus:ring-2 focus:ring-blue-300"
                                        aria-label="Answer Choice"
                                    />
                                    <span class="text-base font-medium text-gray-900 md:text-lg">{{
                                        (shuffledQuestions[current] as any)[`choice_${choice}`]
                                    }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div v-else class="rounded-xl border border-red-200 bg-red-50 p-6 text-center shadow-lg">
                        <h2 class="mb-2 text-xl font-bold text-red-700">No questions available for this exam.</h2>
                        <p class="mb-4 text-base text-gray-700">Please contact the administrator or try another exam level.</p>
                    </div>
                </Transition>
                <div class="mt-6 flex items-center justify-between">
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
                        class="ml-4 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-2 font-bold text-white shadow-lg transition hover:from-blue-700 hover:to-blue-500 focus:ring-2 focus:ring-blue-300 focus:outline-none md:ml-8 md:px-8 md:py-3"
                        aria-label="Submit Exam"
                    >
                        Submit Exam
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}
</style>
