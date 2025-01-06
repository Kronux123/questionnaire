<template>
    <AuthenticatedLayout>
        <div class="p-6 bg-gray-200 h-screen overflow-y-auto">
            <form @submit.prevent="save" class="space-y-4">
                <div class="flex gap-4">
                    <label for="name" class="w-1/3">Name of questionnaire: </label>
                    <input type="text" id="name" v-model="form.name" class="flex-1 p-2 border border-gray-300 rounded">
                    <span class="text-red-500">{{ form.errors.name }}</span>
                </div>
                <span class="text-red-500">{{ form.errors.questions }}</span>
                <div v-for="(question, index) in form.questions" :key="index" class="border border-gray-300 p-4 rounded shadow-lg">
                    <div class="flex gap-4 mb-2">
                        <label :for="'question' + index" class="w-1/3">Question {{ index + 1 }}: </label>
                        <input type="text" :id="'question' + index" v-model="question.question" class="flex-1 p-2 border border-gray-300 rounded">
                        <span class="text-red-500">{{ form.errors.questions?.[index]?.question }}</span>                    </div>

               

                    <div class="flex gap-4 mb-2">
                        <label class="w-1/3">Correct: </label>
                        <div>
                            <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="flex items-center">
                                <input type="radio" :id="'correct' + index + choiceIndex" :value="choiceIndex" v-model="question.correctChoice">
                                <label :for="'correct' + index + choiceIndex" class="ml-2">Choice {{ choiceIndex + 1 }}: {{ choice }}</label>
                            </div>
                        </div>
                    </div>

                    <div v-for="(choice, choiceIndex) in question.choices" :key="choiceIndex" class="flex gap-2 mb-2">
                        <label :for="'choice' + index + choiceIndex" class="w-1/3">Choice {{ choiceIndex + 1 }}: </label>
                        <input type="text" :id="'choice' + index + choiceIndex" v-model="question.choices[choiceIndex]" class="flex-1 p-2 border border-gray-300 rounded">
                        <span class="text-red-500">{{ form.errors.questions?.[index]?.choices?.[choiceIndex] }}</span>
                    </div>

                </div>

                <div class="flex gap-3">
                    <button type="button" @click="addQuestion" :disabled="form.questions.length >= 10" class="mt-4 p-2 bg-orange-500 text-white rounded hover:bg-orange-600">Add Question</button>
                    <button type="submit" class="mt-4 p-2 bg-green-500 text-white rounded hover:bg-green-600">Save</button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    errors: Object
})
const form = useForm({
    name: null,
    questions: [
        {
            question: null,
           
            correctChoice: null, // Initialize to store the index of the correct choice
            choices: [null, null, null, null] // Initialize with 4 empty choices
        }
    ]
})

const save = async () => {
    form.post(route('questionnaires.save'), {
        onSuccess: () => form.reset()
    });
}

const addQuestion = () => {
    if (form.questions.length < 10) {
        form.questions.push({ question: null, answer: null, correctChoice: null, choices: [null, null, null, null] });
    }
}

const addChoice = (index) => {
    const question = form.questions[index];
    if (question.choices.length < 4) {
        question.choices.push(null);
    }
}
</script>