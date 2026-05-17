<template>
    <div>
        <div class="text-sm font-semibold mb-4 tracking-wide text-gray-900">Monthly Task Completion</div>
        <div class="h-72">
            <Bar :data="chartData" :options="chartOptions" :plugins="plugins" />
        </div>
    </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend } from 'chart.js'
import { ref, onMounted } from 'vue'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

const chartData = ref({
    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
    datasets: [
        {
            label: 'Tasks Completed',
            data: [65, 89, 72, 95, 58, 78],
            backgroundColor: '#3b82f6',
            borderColor: '#2563eb',
            borderWidth: 1,
            borderRadius: 6,
        },
        {
            label: 'Tasks Created',
            data: [45, 60, 55, 70, 40, 65],
            backgroundColor: '#64748b',
            borderColor: '#475569',
            borderWidth: 1,
            borderRadius: 6,
        }
    ]
})

const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
            labels: {
                usePointStyle: true,
                padding: 20,
                font: { size: 12 }
            }
        },
        tooltip: {
            backgroundColor: '#1e2937',
            titleColor: '#e2e8f0',
            bodyColor: '#94a3b8',
            padding: 12,
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: '#e2e8f0',
            },
            ticks: {
                font: { size: 11 },
                color: '#64748b'
            }
        },
        x: {
            grid: {
                color: '#e2e8f0',
            },
            ticks: {
                font: { size: 11 },
                color: '#64748b'
            }
        }
    }
})

const plugins = ref([])
</script>