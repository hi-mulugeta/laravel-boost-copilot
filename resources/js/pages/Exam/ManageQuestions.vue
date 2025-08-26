<script setup lang="ts">
import { reactive, ref, watch } from 'vue';

const props = defineProps({
    levels: Array,
    exams: Array,
    questions: {
        type: Array,
        default: () => [],
    },
});

const form = reactive({
    exam_id: '',
    title: '',
    description: '',
    choice_a: '',
    choice_b: '',
    choice_c: '',
    choice_d: '',
    correct_choice: 'a',
});
const editing = ref(false);
const editId = ref(null);

const filteredQuestions = ref<Array<any>>([]);

function filterQuestions() {
    filteredQuestions.value = props.questions.filter((q: any) => q.exam_id === Number(form.exam_id));
}

function editQuestion(q: any) {
    editing.value = true;
    editId.value = q.id;
    form.exam_id = q.exam_id;
    form.title = q.title;
    form.description = q.description;
    form.choice_a = q.choice_a;
    form.choice_b = q.choice_b;
    form.choice_c = q.choice_c;
    form.choice_d = q.choice_d;
    form.correct_choice = q.correct_choice;
}

watch(() => form.exam_id, filterQuestions);

// Initialize filteredQuestions if exam_id is set
if (form.exam_id) filterQuestions();
function submit() {
    // This is a placeholder. You should implement backend POST logic here.
    // For now, just reset the form and editing state.
    resetForm();
}

function resetForm() {
    editing.value = false;
    editId.value = null;
    form.exam_id = '';
    form.title = '';
    form.description = '';
    form.choice_a = '';
    form.choice_b = '';
    form.choice_c = '';
    form.choice_d = '';
    form.correct_choice = 'a';
}
</script>

<template>
    <div class="mx-auto mt-8 max-w-2xl rounded-lg bg-white p-6 shadow">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold">Add/Edit Question</h2>
            <a href="/exam/select" class="text-blue-600 hover:underline">Go to Select Level</a>
        </div>
        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label class="mb-1 block font-medium">Exam</label>
                <select v-model="form.exam_id" class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="" disabled>Select Exam</option>
                    <option v-for="exam in props.exams as Array<any>" :key="exam.id" :value="exam.id">{{ exam.name }} ({{ exam.level }})</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block font-medium">Title</label>
                <input
                    v-model="form.title"
                    class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                    placeholder="Question title"
                />
            </div>
            <div>
                <label class="mb-1 block font-medium">Description</label>
                <textarea
                    v-model="form.description"
                    class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                    placeholder="Question description"
                />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-1 block font-medium">Choice A</label>
                    <input
                        v-model="form.choice_a"
                        class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                        placeholder="Choice A"
                    />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice B</label>
                    <input
                        v-model="form.choice_b"
                        class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                        placeholder="Choice B"
                    />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice C</label>
                    <input
                        v-model="form.choice_c"
                        class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                        placeholder="Choice C"
                    />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice D</label>
                    <input
                        v-model="form.choice_d"
                        class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                        placeholder="Choice D"
                    />
                </div>
            </div>
            <div>
                <label class="mb-1 block font-medium">Correct Choice</label>
                <select
                    v-model="form.correct_choice"
                    class="w-full rounded-lg border-2 border-blue-200 px-3 py-2 focus:border-blue-500 focus:outline-none"
                >
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>
            <div class="mt-2 flex gap-4">
                <button
                    type="submit"
                    class="rounded-full bg-gradient-to-r from-blue-600 to-blue-400 px-6 py-2 text-lg font-extrabold text-white shadow-xl transition hover:from-blue-700 hover:to-blue-500 focus:ring-4 focus:ring-blue-300 focus:outline-none"
                >
                    {{ editing ? 'Update' : 'Add' }} Question
                </button>
                <button type="button" @click="resetForm" class="rounded-full bg-gray-200 px-6 py-2 text-lg font-bold text-gray-700 hover:bg-gray-300">
                    Reset
                </button>
            </div>
        </form>
        <!-- Live list of questions for selected exam -->
        <div class="mt-8">
            <h3 class="mb-2 font-bold">Questions List</h3>
            <div v-if="filteredQuestions.length === 0" class="text-gray-500">No questions for this exam yet.</div>
            <ul v-else class="space-y-4">
                <li v-for="q in filteredQuestions" :key="q.id" class="flex flex-col gap-2 rounded-lg border bg-blue-50 p-4">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-blue-700">{{ q.title }}</span>
                        <button @click="editQuestion(q)" class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700">Edit</button>
                    </div>
                    <div class="text-sm text-gray-700">{{ q.description }}</div>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <div v-for="(choice, idx) in ['a', 'b', 'c', 'd']" :key="idx" class="text-xs">
                            <span :class="q.correct_choice === choice ? 'font-bold text-green-700' : ''">
                                {{ String.fromCharCode(65 + idx) }}: {{ q['choice_' + choice] }}
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
