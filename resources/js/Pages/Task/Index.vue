<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Task List</h1>
                <Link
                    :href="route('tasks.create')"
                    class="bg-[#3b82f6] hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-500/10">
                    <span>+</span> New Task
                </Link>
            </div>

            <TaskFilters :filters="filters" />

            <div v-if="$page.props.flash?.success" class="mb-4 text-sm text-green-400">
                {{ $page.props.flash.success }}
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <TaskCard v-for="task in tasks.data" :key="task.id" :task="task" />
                    <p v-if="!tasks.data?.length" class="text-gray-400 text-sm col-span-full">No tasks found.</p>
                </div>

                <Sidebar :stats="stats" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import TaskCard from '../Components/TaskCard.vue'
import Sidebar from '../Components/Sidebar.vue'
import TaskFilters from '../Components/TaskFilters.vue'

defineProps({
    tasks: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
})
</script>
