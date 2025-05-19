<template>
    <div class="space-y-1">
        <Link :href="route('admin.dashboard')" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md"
              :class="[
                route().current('admin.dashboard')
                    ? 'bg-indigo-50 text-indigo-600'
                    : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
            ]">
            <svg class="mr-3 h-5 w-5" :class="[
            route().current('admin.dashboard')
                ? 'text-indigo-500'
                : 'text-gray-400 group-hover:text-gray-500'
        ]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
