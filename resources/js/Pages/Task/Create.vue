<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <Header title="New Task" />

            <TaskFilters />

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                <div class="lg:col-span-3 bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl">
                    <form class="space-y-5" @submit.prevent="submit">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Create Task</h2>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500"
                                required />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                            <textarea
                                v-model="form.description"
                                rows="4"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Status</label>
                                <select v-model="form.status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Priority</label>
                                <select v-model="form.priority" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Due Date</label>
                                <input v-model="form.due_date" type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Assign To</label>
                            <select v-model="form.assigned_to" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm" required>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                            </select>
                        </div>

                        <div class="pt-2 flex justify-center">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="bg-[#3b82f6] hover:bg-blue-600 text-white font-medium px-8 py-2.5 rounded-xl text-sm transition shadow-md shadow-blue-500/20 disabled:opacity-50">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>

                <Sidebar :stats="{ total: 0, completed: 0, in_progress: 0, total_percentage: 0, completed_percentage: 0, in_progress_percentage: 0, monthly: [] }" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Header from '../Components/Header.vue'
import TaskFilters from '../Components/TaskFilters.vue'
import Sidebar from '../Components/Sidebar.vue'

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    title: '',
    description: '',
    status: 'pending',
    priority: 'medium',
    due_date: '',
    assigned_to: props.users[0]?.id ?? null,
})

const submit = () => {
    form.post(route('tasks.store'))
}
</script>
