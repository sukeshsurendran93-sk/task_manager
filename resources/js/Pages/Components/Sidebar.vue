<template>
    <div :class="variant === 'detail' ? 'space-y-4' : 'space-y-6'">
        <div class="bg-white text-gray-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="flex items-center gap-3 p-4 border-b border-gray-100">
                <img
                    class="w-10 h-10 rounded-full bg-gray-200 object-cover"
                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&h=100&q=80"
                    alt="Admin User">
                <span class="font-semibold text-gray-900">Admin User</span>
            </div>

            <div class="text-sm">
                <template v-if="variant === 'detail'">
                    <div class="flex justify-between items-center px-4 py-3 bg-[#e2e8f0]/30 text-gray-700 font-medium border-l-4 border-blue-500">
                        <span>Tasks</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </div>
                    <a href="#" class="flex items-center px-4 py-3 bg-[#3b82f6] text-white font-medium">Tasks</a>
                </template>
                <template v-else>
                    <a href="#" class="flex items-center px-4 py-3 bg-[#3b82f6] text-white font-medium">Tasks</a>
                    <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 transition">Tasks</a>
                </template>

                <div class="flex items-center justify-between px-4 py-3 text-gray-400">
                    <span>Users</span>
                    <span class="text-[11px] bg-gray-100 text-gray-400 px-2 py-0.5 rounded">Only visible to Admin</span>
                </div>
                <a href="#" class="flex items-center px-4 py-3 text-red-500 hover:bg-red-50 transition border-b border-gray-100">Logout</a>
            </div>

            <div class="p-4 bg-gray-50/50">
                <div class="grid grid-cols-3 gap-2 text-center mb-4">
                    <StatCircle label="Total Tasks" :value="150" color="blue" :percentage="75" />
                    <StatCircle label="Completed" :value="90" color="teal" :percentage="60" />
                    <StatCircle label="In Progress" :value="90" color="indigo" :percentage="45" />
                </div>

                <div class="border-t border-gray-100 pt-3">
                    <div class="text-xs font-semibold text-center text-gray-700 mb-3">Monthly Task Completion</div>
                    <div class="flex items-end justify-between h-16 px-4 text-[10px] text-gray-400">
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t h-4"></div>Jan
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t h-10"></div>Feb
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t h-8"></div>Mar
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t h-12"></div>Apr
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-3 bg-blue-500 rounded-t h-2"></div>May
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button
            v-if="variant === 'detail'"
            type="button"
            class="w-full border border-gray-700 bg-transparent text-blue-400 hover:bg-gray-800 font-medium py-2.5 px-4 rounded-xl text-sm flex items-center justify-between transition">
            <span>Refresh AI Summary</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.253 8H18" />
            </svg>
        </button>

        <div class="bg-[#141922] border border-gray-800 rounded-2xl p-5 shadow-xl text-white">
            <div class="text-sm font-semibold mb-4 tracking-wide">
                Monthly Task Completion
            </div>
            <div class="flex h-36 items-end justify-between px-2 relative">
                <div class="absolute inset-x-0 top-0 bottom-6 flex flex-col justify-between text-[10px] text-gray-600 pointer-events-none pr-2">
                    <div class="border-b border-gray-800/60 w-full text-left">180</div>
                    <div class="border-b border-gray-800/60 w-full text-left">15</div>
                    <div class="border-b border-gray-800/60 w-full text-left">5</div>
                    <div class="w-full text-left">0</div>
                </div>

                <div class="flex flex-col items-center gap-1.5 z-10 w-full">
                    <div class="w-5 bg-blue-500 rounded-t h-16"></div>
                    <span class="text-[10px] text-gray-500">Jan</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 z-10 w-full">
                    <div class="w-5 bg-blue-500 rounded-t h-24"></div>
                    <span class="text-[10px] text-gray-500">Feb</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 z-10 w-full">
                    <div class="w-5 bg-blue-500 rounded-t h-10"></div>
                    <span class="text-[10px] text-gray-500">Apr</span>
                </div>
                <div class="flex flex-col items-center gap-1.5 z-10 w-full">
                    <div class="w-5 bg-blue-500 rounded-t h-20"></div>
                    <span class="text-[10px] text-gray-500">May</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import StatCircle from './StatCircle.vue'

defineProps({
    variant: {
        type: String,
        default: 'index',
    },
})
</script>
