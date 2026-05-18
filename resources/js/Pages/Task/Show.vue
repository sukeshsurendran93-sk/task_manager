<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <Header title="Task Detail + AI Summary" />

            <TaskFilters />

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                <div class="lg:col-span-3 bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl relative">
                    <button type="button"
                        class="absolute top-6 right-8 text-gray-400 hover:text-gray-600 text-xl font-bold tracking-widest">
                        •••
                    </button>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 pr-10">
                        {{ task.title }}
                    </h2>

                    <div class="flex flex-wrap items-center gap-6 mb-6 text-sm">
                        <div class="flex items-center gap-2">
                            <span
                                class="bg-gray-100 text-gray-500 text-xs px-2.5 py-1 rounded-md font-medium">Status</span>
                            <span class="text-gray-600 font-medium">{{ task.status_label }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="bg-gray-100 text-gray-500 text-xs px-2.5 py-1 rounded-md font-medium">Priority</span>
                            <span class="text-gray-600 font-medium">{{ task.priority_display }}</span>
                        </div>
                    </div>

                    <div class="bg-[#f7fafc] rounded-xl p-5 md:p-6 border border-gray-100 space-y-5 mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Description</h3>

                        <div v-if="task.assignee" class="text-sm text-gray-600 space-y-1">
                            <div>
                                <span class="font-medium text-gray-800">Assigned to:</span>
                                {{ task.assignee }}
                            </div>
                        </div>

                        <div v-if="task.due_date"
                            class="relative max-w-md bg-white border border-gray-200 rounded-lg px-4 py-2.5 flex justify-between items-center shadow-sm">
                            <div class="text-sm">
                                <span class="text-gray-400 mr-2">Due Date:</span>
                                <span class="text-gray-700 font-medium">{{ task.due_date }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <p v-if="task.body || task.description" class="text-sm text-gray-500 leading-relaxed pt-2">
                            {{ task.body || task.description }}
                        </p>

                        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                            <h4 class="text-sm font-bold text-gray-900 mb-2">AI-Generated Summary</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                {{ task.ai_summary ?? 'AI summary will appear after processing.' }}
                            </p>
                        </div>

                        <div
                            class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm text-xs text-gray-500 space-y-1">
                            <p>
                                <span class="font-bold text-gray-800">AI Summary:</span>
                                {{ task.ai_summary_short ?? task.ai_summary }}
                            </p>
                            <p>
                                <span class="font-bold text-gray-800">Priority:</span>
                                {{ task.ai_priority }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-center gap-3">
                        <Link :href="route('tasks.edit', task.id)"
                            class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Edit
                        </Link>
                        <button type="button"
                            class="bg-[#3b82f6] hover:bg-blue-600 text-white font-medium px-8 py-2.5 rounded-xl text-sm transition shadow-md shadow-blue-500/20">
                            Save Changes
                        </button>
                    </div>
                </div>

                <Sidebar variant="detail" :stats="stats" :task-id="task.id" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Header from '../Components/Header.vue'
import TaskFilters from '../Components/TaskFilters.vue'
import Sidebar from '../Components/Sidebar.vue'

defineProps({
    task: {
        type: Object,
        required: true,
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
})
</script>
