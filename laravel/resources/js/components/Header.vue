<template>
  <header class="bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center gap-8">
        <router-link to="/" class="text-sky-600 font-bold text-lg">
          UniGigs
        </router-link>

        <nav class="hidden md:flex items-center gap-6 text-sm">
          <router-link to="/" class="hover:text-sky-600">Home</router-link>
          <router-link to="/explore" class="hover:text-sky-600">Explore</router-link>

          <template v-if="isLoggedIn">
            <router-link :to="`/users/${userId}`" class="hover:text-sky-600">
              My Profile
            </router-link>
            <router-link to="/services/new" class="hover:text-sky-600">
              Add Service
            </router-link>
          </template>
        </nav>
      </div>

      <div class="flex items-center gap-3">
        <template v-if="!isLoggedIn">
          <router-link
            to="/login"
            class="px-4 py-2 text-sm border border-sky-500 text-sky-600 rounded-md hover:bg-sky-50"
          >
            Login
          </router-link>

          <router-link
            to="/register"
            class="px-4 py-2 text-sm bg-sky-500 text-white rounded-md hover:bg-sky-600"
          >
            Sign Up
          </router-link>
        </template>

        <template v-else>
          <div class="flex items-center gap-3">
            <img
              v-if="photoUrl"
              :src="photoUrl"
              alt="User photo"
              class="w-9 h-9 rounded-full object-cover border border-slate-200"
            />

            <div
              v-else
              class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-sm font-medium text-slate-600"
            >
              {{ userInitial }}
            </div>

            <span class="text-sm font-medium text-slate-700">
              Hi, {{ userName }}
            </span>

            <router-link
              to="/logout"
              class="px-4 py-2 text-sm border border-sky-500 text-sky-600 rounded-md hover:bg-sky-50"
            >
              Logout
            </router-link>
          </div>
        </template>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const token = ref('')
const userId = ref('')
const userName = ref('User')
const userPhoto = ref('')

const loadUserData = () => {
  token.value = localStorage.getItem('token') || ''
  userId.value = localStorage.getItem('user_id') || ''
  userName.value = localStorage.getItem('user_name') || 'User'
  userPhoto.value = localStorage.getItem('user_photo') || ''
}

onMounted(() => {
  loadUserData()
})

const isLoggedIn = computed(() => {
  return token.value !== ''
})

const userInitial = computed(() => {
  return userName.value ? userName.value.charAt(0).toUpperCase() : 'U'
})

const photoUrl = computed(() => {
  if (!userPhoto.value) return ''

  if (userPhoto.value.startsWith('http')) {
    return userPhoto.value
  }

  if (userPhoto.value.startsWith('demo/')) {
    return `/${userPhoto.value}`
  }

  return `/storage/${userPhoto.value}`
})
</script>