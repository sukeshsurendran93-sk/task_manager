<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Users</h1>
                <Link
                    :href="route('users.create')"
                    class="bg-[#3b82f6] hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition shadow-lg shadow-blue-500/10">
                    <span>+</span> New User
                </Link>
            </div>

            <div v-if="$page.props.flash?.success" class="mb-4 text-sm text-green-400">
                {{ $page.props.flash.success }}
            </div>
            
            <div v-if="$page.props.flash?.error" class="mb-4 text-sm text-red-400">
                {{ $page.props.flash.error }}
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                <div class="lg:col-span-3">
                    <div class="bg-white text-gray-800 rounded-2xl p-6 shadow-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="px-4 py-3 font-semibold text-sm text-gray-500">Name</th>
                                        <th class="px-4 py-3 font-semibold text-sm text-gray-500">Email</th>
                                        <th class="px-4 py-3 font-semibold text-sm text-gray-500">Role</th>
                                        <th class="px-4 py-3 font-semibold text-sm text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users.data" :key="user.id" class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                        <td class="px-4 py-4 font-medium">{{ user.name }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-500">{{ user.email }}</td>
                                        <td class="px-4 py-4">
                                            <span 
                                                class="text-xs px-2.5 py-1 rounded-md font-medium"
                                                :class="user.role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-gray-100 text-gray-600'">
                                                {{ user.role }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-sm">
                                            <div class="flex items-center gap-3">
                                                <Link :href="route('users.edit', user.id)" class="text-blue-500 hover:text-blue-700 font-medium">Edit</Link>
                                                <button 
                                                    v-if="user.id !== $page.props.auth.user.id"
                                                    @click="deleteUser(user.id)" 
                                                    class="text-red-500 hover:text-red-700 font-medium">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="!users.data?.length">
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No users found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <Sidebar />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import Sidebar from '../Components/Sidebar.vue'

defineProps({
    users: {
        type: Object,
        required: true,
    },
})

const deleteUser = (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('users.destroy', id))
    }
}
</script>
