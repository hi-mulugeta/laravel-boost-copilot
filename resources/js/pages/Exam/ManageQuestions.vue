<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const props = defineProps({
    levels: Array,
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

function submit() {
    if (editing.value) {
        router.post(`/questions/${editId.value}/update`, form, { preserveScroll: true });
    } else {
        router.post('/questions/store', form, { preserveScroll: true });
    }
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
        <h2 class="mb-4 text-xl font-bold">Add/Edit Question</h2>
        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="mb-1 block font-medium">Level</label>
                <select v-model="form.exam_id" class="w-full rounded border px-2 py-1">
                    <option value="" disabled>Select Level</option>
                    <option v-for="(level, idx) in props.levels" :key="idx" :value="level">
                        {{ level }}
                    </option>
                </select>
            </div>
            <div>
                <label class="mb-1 block font-medium">Title</label>
                <input v-model="form.title" class="w-full rounded border px-2 py-1" />
            </div>
            <div>
                <label class="mb-1 block font-medium">Description</label>
                <textarea v-model="form.description" class="w-full rounded border px-2 py-1" />
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="mb-1 block font-medium">Choice A</label>
                    <input v-model="form.choice_a" class="w-full rounded border px-2 py-1" />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice B</label>
                    <input v-model="form.choice_b" class="w-full rounded border px-2 py-1" />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice C</label>
                    <input v-model="form.choice_c" class="w-full rounded border px-2 py-1" />
                </div>
                <div>
                    <label class="mb-1 block font-medium">Choice D</label>
                    <input v-model="form.choice_d" class="w-full rounded border px-2 py-1" />
                </div>
            </div>
            <div>
                <label class="mb-1 block font-medium">Correct Choice</label>
                <select v-model="form.correct_choice" class="w-full rounded border px-2 py-1">
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    {{ editing ? 'Update' : 'Add' }} Question
                </button>
                <button type="button" @click="resetForm" class="rounded bg-gray-200 px-4 py-2">Reset</button>
            </div>
        </form>
        <!-- List of questions for editing (to be implemented) -->
        <div class="mt-8">
            <h3 class="mb-2 font-bold">Questions List (Edit below)</h3>
            <!-- TODO: Fetch and display questions for selected level -->
            <div class="text-gray-500">Questions list will appear here.</div>
        </div>
    </div>
</template>
