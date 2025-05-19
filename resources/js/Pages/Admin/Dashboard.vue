<template>
    <AdminLayout>
        <Head title="Tournament Teams"/>

        <div class="max-w-xl mx-auto mt-16">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Tournament Teams</h2>
            <table class="w-full border rounded-xl shadow">
                <thead>
                <tr class="bg-gray-700 text-white">
                    <th class="py-2 px-4 text-left">Team Name</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="team in teams" :key="team.id" class="border-b last:border-b-0">
                    <td class="py-2 px-4">{{ team.name }}</td>
                </tr>
                </tbody>
            </table>
            <div class="mt-6 text-center">
                <button
                    class="bg-teal-500 hover:bg-teal-600 text-white font-semibold px-6 py-2 rounded transition"
                    @click="generateFixtures"
                >
                    Generate Fixtures
                </button>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {Head, router} from "@inertiajs/vue3";

const props = defineProps({teams: Array})

const generateFixtures = () => {
    router.post('/admin/fixtures/generate')
}
</script>
