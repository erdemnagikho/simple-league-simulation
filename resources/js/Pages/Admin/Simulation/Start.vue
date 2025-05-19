<template>
    <AdminLayout>
        <Head title="Simulation Start"/>

        <div class="min-h-screen bg-gray-100 py-14 px-4 flex flex-col items-center">
            <h2 class="text-3xl font-bold mb-10 text-center text-gray-800">Simulation</h2>

            <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-0">
                    <table class="w-full text-center rounded-2xl overflow-hidden">
                        <thead>
                        <tr class="bg-gray-800 text-white text-base">
                            <th class="py-2 px-2">Team Name</th>
                            <th class="py-2 px-2">P</th>
                            <th class="py-2 px-2">W</th>
                            <th class="py-2 px-2">D</th>
                            <th class="py-2 px-2">L</th>
                            <th class="py-2 px-2">GD</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in standings" :key="row.team" class="border-b last:border-b-0">
                            <td class="py-2 px-2 font-medium">{{ row.team }}</td>
                            <td class="py-2 px-2">{{ row.P }}</td>
                            <td class="py-2 px-2">{{ row.W }}</td>
                            <td class="py-2 px-2">{{ row.D }}</td>
                            <td class="py-2 px-2">{{ row.L }}</td>
                            <td class="py-2 px-2">{{ row.GD }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col">
                    <div class="bg-gray-800 text-white px-6 py-3 font-bold text-xl rounded-t-2xl text-left">
                        Week {{ currentWeek }}
                    </div>
                    <ul class="flex-1 px-6 py-5">
                        <li v-for="match in currentWeekMatches" :key="match.id"
                            class="flex items-center justify-between py-3">
                            <span class="flex-1 text-left font-medium">{{ match.home_team.name }}</span>
                            <span class="mx-2 font-bold text-lg">-</span>
                            <span class="flex-1 text-right font-medium">{{ match.away_team.name }}</span>
                            <span v-if="match.result" class="ml-4 font-mono text-green-700">
    {{ match.result.home_score }} - {{ match.result.away_score }}
  </span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-0">
                    <table class="w-full text-center rounded-2xl overflow-hidden">
                        <thead>
                        <tr class="bg-gray-800 text-white text-base">
                            <th class="py-2 px-3">Championship Predictions</th>
                            <th class="py-2 px-3">%</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in standings" :key="row.team" class="border-b last:border-b-0">
                            <td class="py-2 px-3 font-medium">{{ row.team }}</td>
                            <td class="py-2 px-3">{{ row.prediction ?? 0 }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-wrap justify-center items-center gap-6">
                <button
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold px-8 py-3 rounded-xl text-lg shadow-md transition"
                    @click="playAllWeeks"
                    :disabled="props.allPlayed"
                >
                    Play All Weeks
                </button>
                <button
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold px-8 py-3 rounded-xl text-lg shadow-md transition"
                    @click="allPlayed ? goToResults() : playNextWeek()"
                >
                    {{ allPlayed ? 'Go to All Results' : 'Play Next Week' }}
                </button>
                <button
                    class="bg-red-500 hover:bg-red-600 text-white font-bold px-8 py-3 rounded-xl text-lg shadow-md transition"
                    @click="resetData"
                >
                    Reset Data
                </button>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {Head, router} from "@inertiajs/vue3";

const props = defineProps({
    standings: Array,
    currentWeek: Number,
    currentWeekMatches: Array,
    allPlayed: Boolean,
})

const playNextWeek = () => {
    router.post('/admin/simulation/play-next-week')
}

const goToResults = () => {
    router.get('/admin/fixtures');
}

const resetData = () => {
    router.post('/admin/reset');
}

const playAllWeeks = () => {
    router.post('/admin/simulation/play-all-weeks');
}

</script>
