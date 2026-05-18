<template>
    <div class="bg-[#1e2530] text-white min-h-screen p-6 md:p-10">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <Link :href="route('users.index')" class="text-blue-400 hover:text-blue-300 text-sm font-medium flex items-center gap-2 mb-4">
                    &larr; Back to Users
                </Link>
                <h1 class="text-3xl font-bold tracking-tight">Edit User</h1>
            </div>

            <div class="bg-white text-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl">
                <form @submit.prevent="submit" class="space-y-6">
                    
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-bold text-gray-900">Name</label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="w-full bg-[#f8fafc] border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition shadow-sm"
                            required
                        >
                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-gray-900">Email Address</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="w-full bg-[#f8fafc] border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition shadow-sm"
                            required
                        >
                        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div class="space-y-2">
                        <label for="role" class="block text-sm font-bold text-gray-900">Role</label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="w-full bg-[#f8fafc] border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition shadow-sm"
                            required
                        >
                            <option value="">Select a role</option>
                            <option v-for="role in roles" :key="role" :value="role">
                                {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                            </option>
                        </select>
                        <div v-if="form.errors.role" class="text-red-500 text-xs mt-1">{{ form.errors.role }}</div>
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-bold text-gray-900">New Password (leave blank to keep current)</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            class="w-full bg-[#f8fafc] border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition shadow-sm"
                        >
                        <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-4 border-t border-gray-100">
                        <Link :href="route('users.index')" class="text-gray-500 hover:text-gray-700 font-medium text-sm transition">
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="bg-[#3b82f6] hover:bg-blue-600 disabled:opacity-50 text-white px-8 py-2.5 rounded-xl text-sm font-medium transition shadow-lg shadow-blue-500/20"
                        >
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    password: '',
})

const submit = () => {
    form.put(route('users.update', props.user.id))
}
</script>
