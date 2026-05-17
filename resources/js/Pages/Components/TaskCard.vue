<template>
    <div class="bg-white text-gray-800 rounded-2xl p-5 shadow-xl flex flex-col justify-between min-h-[220px]">
        <div>
            <div class="flex justify-between items-center mb-3">
                <span
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    {{ task.status_label }}
                </span>
                <button
                    type="button"
                    class="text-gray-400 hover:text-gray-600 text-xl font-bold tracking-widest leading-none">
                    •••
                </button>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ task.title }}</h3>

            <div class="flex gap-2 mb-3">
                <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded">Status</span>
                <span :class="priorityBadgeClass" class="text-[10px] font-semibold px-2 py-0.5 rounded">
                    {{ task.priority_label }}
                </span>
            </div>

            <p v-if="task.description" class="text-xs text-gray-500 line-clamp-3 mb-4">
                {{ task.description }}
            </p>

            <div v-else class="text-xs text-gray-500 space-y-0.5 mb-4">
                <div v-if="task.assignee">
                    <span class="font-medium">Assignee:</span> {{ task.assignee }}
                </div>
                <div v-if="task.due_date">
                    <span class="font-medium">Due:</span> {{ task.due_date }}
                </div>
                <div v-if="task.meta_label">
                    <span class="font-medium">{{ task.meta_label }}</span>
                </div>
                <div v-if="task.meta_value" class="text-blue-600 font-medium">
                    {{ task.meta_value }}
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
            <Link
                :href="route('tasks.edit', task.id)"
                class="px-3 py-1 text-xs font-medium border border-gray-200 rounded-md hover:bg-gray-50 transition">
                Edit
            </Link>
            <Link
                :href="route('tasks.show', task.id)"
                class="px-3 py-1 text-xs font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                View
            </Link>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
})

const priorityBadgeClass = computed(() => {
    if (props.task.priority === 'high') {
        return 'bg-red-100 text-red-600'
    }

    if (props.task.priority === 'low') {
        return 'bg-orange-100 text-orange-600'
    }

    return 'bg-orange-100 text-orange-600'
})
</script>
