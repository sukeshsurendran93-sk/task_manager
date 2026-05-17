<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <Header title="Edit Task" />

            <TaskFilters />

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                <div class="lg:col-span-3 bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl relative">
                    <form class="space-y-5" @submit.prevent="submit">
                        <button
                            type="button"
                            class="absolute top-6 right-8 text-gray-400 hover:text-gray-600 text-xl font-bold tracking-widest">
                            •••
                        </button>

                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1 pr-10">
                            {{ form.title }}
                        </h2>

                        <div class="relative bg-white border border-gray-200 rounded-lg shadow-sm">
                            <input
                                v-model="form.title_placeholder"
                                type="text"
                                class="w-full bg-transparent px-4 py-3 text-gray-600 text-sm focus:outline-none font-medium pr-12">
                            <div class="absolute right-3 top-2.5 w-6 h-6 rounded-full overflow-hidden bg-gray-300">
                                <img
                                    :src="form.avatar_url"
                                    class="object-cover w-full h-full"
                                    alt="User">
                            </div>
                        </div>

                        <div class="bg-[#f7fafc] border border-gray-100 rounded-xl p-4 text-xs text-gray-500 leading-relaxed">
                            {{ form.notes }}
                        </div>

                        <div class="space-y-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <label class="text-sm font-bold text-gray-900 min-w-[60px]">Priority</label>

                                <div class="inline-flex items-center rounded-lg border border-blue-600 bg-white overflow-hidden h-8 text-xs font-medium">
                                    <button
                                        type="button"
                                        class="px-3 h-full transition"
                                        :class="form.priority === 'low' ? 'bg-[#3b82f6] text-white font-semibold' : 'text-gray-500 hover:bg-gray-50'"
                                        @click="form.priority = 'low'">
                                        Low
                                    </button>
                                    <button
                                        type="button"
                                        class="px-3 h-full transition"
                                        :class="form.priority === 'low' ? 'bg-[#3b82f6] text-white font-semibold' : 'text-gray-500 hover:bg-gray-50'"
                                        @click="form.priority = 'low'">
                                        Low
                                    </button>
                                    <div class="h-full w-px bg-gray-200"></div>
                                    <button
                                        type="button"
                                        class="px-4 h-full transition"
                                        :class="form.priority === 'medium' ? 'bg-[#3b82f6] text-white font-semibold' : 'text-gray-400 hover:bg-gray-50'"
                                        @click="form.priority = 'medium'">
                                        Medium
                                    </button>
                                </div>

                                <div
                                    class="relative inline-flex items-center bg-white border rounded-lg h-8 px-3 text-xs font-medium cursor-pointer transition"
                                    :class="form.priority === 'high' ? 'border-blue-600 text-blue-600' : 'border-gray-200 text-gray-500 hover:border-gray-300'"
                                    @click="form.priority = 'high'">
                                    <span class="mr-3">High</span>
                                    <span class="text-[9px] text-gray-400">▼</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 pl-0 sm:pl-[72px]">
                                <button
                                    type="button"
                                    class="px-4 py-1.5 text-xs font-medium rounded-full transition"
                                    :class="form.priority === 'low' ? 'bg-gray-100 text-gray-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                    @click="form.priority = 'low'">
                                    Low
                                </button>
                                <button
                                    type="button"
                                    class="px-4 py-1.5 text-xs font-medium rounded-full transition"
                                    :class="form.priority === 'medium' ? 'bg-red-100 text-red-600 border border-red-100/50' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                    @click="form.priority = 'medium'">
                                    {{ form.priority === 'medium' ? '+ Medium' : 'Medium' }}
                                </button>
                                <button
                                    type="button"
                                    class="px-4 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full hover:bg-gray-200 transition"
                                    @click="form.priority = 'high'">
                                    + High
                                </button>
                            </div>
                        </div>

                        <div class="relative bg-[#f7fafc] border border-gray-200 rounded-lg">
                            <input
                                v-model="form.due_date"
                                type="text"
                                class="w-full bg-transparent px-4 py-2.5 text-xs font-medium text-gray-500 focus:outline-none pr-10">
                            <span class="absolute right-3 top-2.5 text-sm opacity-40 pointer-events-none">📅</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">Assign To</label>
                            <div class="relative bg-[#f7fafc] border border-gray-200 rounded-lg">
                                <input
                                    v-model="form.assignee"
                                    type="text"
                                    class="w-full bg-transparent px-4 py-2.5 text-xs font-medium text-gray-700 focus:outline-none pr-10">
                                <span class="absolute right-3 top-2.5 text-xs opacity-30 pointer-events-none">📂</span>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-center">
                            <button
                                type="submit"
                                class="bg-[#3b82f6] hover:bg-blue-600 text-white font-medium px-8 py-2.5 rounded-xl text-sm transition shadow-md shadow-blue-500/20">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <Sidebar variant="detail" />
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
    task: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    title: props.task.title,
    title_placeholder: props.task.title_placeholder,
    notes: props.task.notes,
    priority: props.task.priority,
    due_date: props.task.due_date,
    assignee: props.task.assignee,
    avatar_url: props.task.avatar_url,
})

const submit = () => {
    form.put(route('tasks.update', props.task.id), {
        preserveScroll: true,
    })
}
</script>
