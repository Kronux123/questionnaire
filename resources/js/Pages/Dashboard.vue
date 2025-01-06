<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    questionnaires: Object
})
const deleteQuestionnaire = (id) => {
    router.delete(route('questionnaires.destroy', id));
}
const viewDetails = (id) => {
    router.get(route('questionnaires.view', id));
}


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 bg-gray-200 text-gray-900">
                        <!-- <Link>questionnaires</Link> -->
                       <Link :href="route('questionnaires.create')" class="bg-gray-500 p-1 rounded font-semibold text-white">new questionnaire +</Link>
                    </div>

                    <div class="p-6 mt-3 h-screen bg-gray-300 text-gray-900 overflow-y-auto">
                        <div :key="q.id" v-for="q in props.questionnaires" class="bg-orange-600 p-3 mt-3 shadow-md rounded flex justify-between text-white">
                            <div>
                                {{ q.name }}
                            </div>
                            <div class="flex gap-2">
                                <button @click="viewDetails(q.id)" class="bg-white rounded p-1 text-black">view</button>
                                <button @click="deleteQuestionnaire(q.id)" class="bg-red-400 rounded p-1 text-black">delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
