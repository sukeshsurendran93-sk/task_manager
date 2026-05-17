<template>
    <div>
        <div class="flex flex-wrap items-center gap-3 mb-4 text-xs md:text-sm text-gray-400">
            <div class="relative w-full max-w-xs">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>

                <input v-model="search" type="text" placeholder="Search Filter Task"
                    class="w-full bg-[#2d3748] border border-gray-700/50 rounded-lg pl-9 pr-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition" />
            </div>

            <select v-model="status"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500">
                <option value="">Status</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
            </select>

            <select v-model="module"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500">
                <option value="">All Modules</option>
            </select>

            <select v-model="priority"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500">
                <option value="">Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>

        <div class="text-xs text-gray-500 mb-6 pl-1">Filter User Task</div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const search = ref('')
const status = ref('')
const module = ref('')
const priority = ref('')

// Example: use this computed value to filter your task list
const filteredTasks = computed(() => {
    return []
})
</script>