<template>
    <div>
        <div
            class="relative mx-auto flex items-center justify-center"
            :class="size === 'sm' ? 'w-12 h-12' : 'w-12 h-12'">
            <Doughnut :data="chartData" :options="chartOptions" />
            <span
                class="absolute font-bold pointer-events-none"
                :class="size === 'sm' ? 'text-[9px] text-slate-800' : 'text-[10px] text-gray-800'">
                {{ value }}
            </span>
        </div>
        <div
            class="mt-1 text-center"
            :class="size === 'sm' ? 'text-[8px] text-slate-400 font-medium' : 'text-[9px] text-gray-400'">
            {{ label }}
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, ArcElement } from 'chart.js'

ChartJS.register(ArcElement)

const props = defineProps({
    label: String,
    value: [Number, String],
    color: { type: String, default: 'blue' },
    percentage: { type: Number, default: 0 },
    size: { type: String, default: 'md' },
})

const ringColor = computed(() => {
    const colors = {
        blue: props.size === 'sm' ? '#3b82f6' : '#2563eb',
        teal: '#14b8a6',
        indigo: '#6366f1',
    }

    return colors[props.color] ?? colors.blue
})

const trackColor = computed(() => (props.size === 'sm' ? '#f1f5f9' : '#e5e7eb'))

const chartData = computed(() => {
    const progress = Math.min(Math.max(props.percentage, 0), 100)

    return {
        datasets: [
            {
                data: [progress, 100 - progress],
                backgroundColor: [ringColor.value, trackColor.value],
                borderWidth: 0,
                borderRadius: 4,
            },
        ],
    }
})

const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    cutout: '72%',
    rotation: -90,
    circumference: 360,
    plugins: {
        legend: { display: false },
        tooltip: { enabled: false },
    },
    animation: {
        animateRotate: true,
        duration: 600,
    },
}))
</script>
