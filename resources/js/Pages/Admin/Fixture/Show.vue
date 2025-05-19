<template>
    <AdminLayout>
        <Head title="Team Matches"/>

        <div class="min-h-screen bg-gray-100 flex flex-col items-center py-14 px-4">
            <h2 class="text-3xl font-bold mb-12 text-center text-gray-800 tracking-tight">Generated Fixtures</h2>
            <div class="w-full max-w-6xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <div
                    v-for="(matches, week) in weeks"
                    :key="week"
                    class="bg-white rounded-3xl shadow-xl border border-gray-200 flex flex-col"
                    style="min-width:250px;"
                >
                    <div class="bg-gray-700 text-white px-6 py-3 font-bold text-xl rounded-t-3xl text-left">
                        Week {{ week }}
                    </div>
                    <ul class="flex-1 px-6 py-5">
                        <li
                            v-for="m in matches"
                            :key="m.id"
                            class="flex items-center justify-between py-3 text-gray-700 text-lg"
                        >
                            <span class="flex-1 text-left truncate font-medium">{{ m.home_team.name }}</span>
                            <span v-if="m.result" class="ml-4 font-mono text-green-700">
                                {{ m.result.home_score }} - {{ m.result.away_score }}
                            </span>
                            <span class="flex-1 text-right truncate font-medium">{{ m.away_team.name }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <button
                class="bg-teal-500 hover:bg-teal-600 text-white font-bold px-8 py-3 rounded-xl text-lg shadow-md transition"
                @click="allPlayed ? goToStart() : startSimulation()"
            >
                {{ allPlayed ? 'Go To Generate Fixture' : 'Start Simulation' }}
            </button>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {Head, router} from "@inertiajs/vue3";

const props = defineProps({
    weeks: Object,
    allPlayed: Boolean,
})

const startSimulation = () => {
    router.get('/admin/simulation/start')
}

const goToStart = () => {
    router.get('/admin');
}
</script>
