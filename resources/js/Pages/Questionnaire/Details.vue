<template>
    <Head title="Questionnaire Details" />

    <AuthenticatedLayout>
        <h1 class="text-2xl font-semibold">Details: {{ props.questionnaire.name }}</h1>


        <div class="p-3">

            <div class="p-3 bg-gray-200 mt-2" v-for="question in props.questionnaire.questions">
                <p class="font-semibold">{{ question.question }}</p>
                <div class="p-3" v-for="choice in question.choices">
                    <span :class="choice.is_correct ? 'text-green-500' : 'text-red-500'">{{ choice.answer }}</span>
                    <span class="ml-2" v-if="choice.is_correct">✅</span>
                    <span class="ml-2" v-else>❌</span>
                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>


<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
const props = defineProps({
    questionnaire: Object
})

onMounted(() => {
    console.log(props.questionnaire)
})
</script>