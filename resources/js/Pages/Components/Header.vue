<template>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight">{{ title }}</h1>
        <button
            type="button"
            class="bg-[#3b82f6] hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-500/10">
            <span class="text-lg leading-none">+</span> New Task
        </button>
    </div>
</template>

<script setup>
defineProps({
    title: String
});
</script>