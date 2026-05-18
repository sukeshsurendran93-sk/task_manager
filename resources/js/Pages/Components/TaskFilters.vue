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
                <input v-model="form.search" type="text" placeholder="Search Filter Task"
                    class="w-full bg-[#2d3748] border border-gray-700/50 rounded-lg pl-9 pr-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition"
                    @input="submit" />
            </div>

            <select v-model="form.status"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500"
                @change="submit">
                <option value="">Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <select v-model="form.ai_priority"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500"
                @change="submit">
                <option value="">AI Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>

            <select v-model="form.priority"
                class="bg-[#2d3748] border border-gray-700/50 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:border-blue-500"
                @change="submit">
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
import { router } from '@inertiajs/vue3'
import { reactive, watch } from 'vue'

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const form = reactive({
    search: props.filters.search ?? '',
    status: props.filters.status ?? '',
    priority: props.filters.priority ?? '',
    ai_priority: props.filters.ai_priority ?? '',
})

let timeout = null

const submit = () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        router.get(route('tasks.index'), { ...form }, {
            preserveState: true,
            replace: true,
        })
    }, 300)
}

watch(() => props.filters, (value) => {
    form.search = value.search ?? ''
    form.status = value.status ?? ''
    form.priority = value.priority ?? ''
    form.ai_priority = value.ai_priority ?? ''
}, { deep: true })
</script>
