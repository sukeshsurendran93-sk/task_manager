<template>
    <div :class="variant === 'detail' ? 'space-y-4' : 'space-y-6'">
        <div class="bg-white text-gray-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="flex items-center gap-3 p-4 border-b border-gray-100">
                <img
                    class="w-10 h-10 rounded-full bg-gray-200 object-cover"
                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&h=100&q=80"
                    alt="Admin User">
                <span class="font-semibold text-gray-900">{{ $page.props.auth?.user?.name ?? 'User' }}</span>
            </div>

            <div class="text-sm">
                <template v-if="variant === 'detail'">
                    <Link :href="route('tasks.index')" class="flex justify-between items-center px-4 py-3 hover:bg-gray-50 text-gray-700 transition">
                        <span>Tasks</span>
                    </Link>
                    <div class="flex items-center px-4 py-3 bg-[#3b82f6] text-white font-medium">Task Detail</div>
                </template>
                <template v-else>
                    <Link :href="route('tasks.index')" :class="route().current('tasks.*') && variant !== 'detail' ? 'flex items-center px-4 py-3 bg-[#3b82f6] text-white font-medium' : 'flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 transition'">Tasks</Link>
                </template>

                <Link
                    v-if="$page.props.auth?.user?.role === 'admin'"
                    :href="route('users.index')"
                    :class="route().current('users.*') ? 'flex items-center px-4 py-3 bg-[#3b82f6] text-white font-medium' : 'flex items-center justify-between px-4 py-3 hover:bg-gray-50 text-gray-700 transition'">
                    <span>Users</span>
                    <span v-if="!route().current('users.*')" class="text-[11px] bg-gray-100 text-gray-400 px-2 py-0.5 rounded">Admin Only</span>
                </Link>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full text-left flex items-center px-4 py-3 text-red-500 hover:bg-red-50 transition border-b border-gray-100">
                    Logout
                </Link>
            </div>

            <div class="p-4 bg-gray-50/50">
                <div class="grid grid-cols-3 gap-2 text-center mb-4">
                    <StatCircle label="Total Tasks" :value="stats.total ?? 0" color="blue" :percentage="stats.total_percentage ?? 0" />
                    <StatCircle label="Completed" :value="stats.completed ?? 0" color="teal" :percentage="stats.completed_percentage ?? 0" />
                    <StatCircle label="In Progress" :value="stats.in_progress ?? 0" color="indigo" :percentage="stats.in_progress_percentage ?? 0" />
                </div>

                <div class="border-t border-gray-100 pt-3">
                    <div class="text-xs font-semibold text-center text-gray-700 mb-3">Monthly Task Completion</div>
                    <div class="flex items-end justify-between h-16 px-4 text-[10px] text-gray-400">
                        <div
                            v-for="month in monthlyBars"
                            :key="month.label"
                            class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t" :style="{ height: month.height }"></div>
                            {{ month.label }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Link
            v-if="variant === 'detail' && taskId"
            :href="route('tasks.refresh-ai', taskId)"
            method="post"
            as="button"
            preserve-scroll
            class="w-full border border-gray-700 bg-transparent text-blue-400 hover:bg-gray-800 font-medium py-2.5 px-4 rounded-xl text-sm flex items-center justify-between transition">
            <span>Refresh AI Summary</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18" />
            </svg>
        </Link>

        <div class="bg-[#141922] border border-gray-800 rounded-2xl p-5 shadow-xl text-white">
            <div class="text-sm font-semibold mb-4 tracking-wide">Monthly Task Completion</div>
            <div class="flex h-36 items-end justify-between px-2 relative">
                <div class="absolute inset-x-0 top-0 bottom-6 flex flex-col justify-between text-[10px] text-gray-600 pointer-events-none pr-2">
                    <div class="border-b border-gray-800/60 w-full text-left">180</div>
                    <div class="border-b border-gray-800/60 w-full text-left">15</div>
                    <div class="border-b border-gray-800/60 w-full text-left">5</div>
                    <div class="w-full text-left">0</div>
                </div>
                <div
                    v-for="month in monthlyBars"
                    :key="'dark-' + month.label"
                    class="flex flex-col items-center gap-1.5 z-10 w-full">
                    <div class="w-5 bg-blue-500 rounded-t" :style="{ height: month.darkHeight }"></div>
                    <span class="text-[10px] text-gray-500">{{ month.label }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import StatCircle from './StatCircle.vue'

const props = defineProps({
    variant: {
        type: String,
        default: 'index',
    },
    stats: {
        type: Object,
        default: () => ({}),
    },
    taskId: {
        type: Number,
        default: null,
    },
})

const monthlyBars = computed(() => {
    const months = props.stats.monthly ?? []
    const max = Math.max(...months.map((m) => m.count), 1)

    return months.map((m) => ({
        label: m.label,
        height: `${Math.max(8, (m.count / max) * 48)}px`,
        darkHeight: `${Math.max(12, (m.count / max) * 96)}px`,
    }))
})
</script>
