<template>
  <form @submit.prevent="handleLogin" class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-2">
        Email Address
      </label>
      <input
        v-model="form.email"
        type="email"
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
        placeholder="you@example.com"
        required
      />
    </div>

    <div>
      <div class="flex items-center justify-between mb-2">
        <label class="block text-sm font-medium text-slate-700">
          Password
        </label>

        <button
          type="button"
          class="text-xs text-sky-500 hover:underline"
        >
          Forgot password?
        </button>
      </div>

      <input
        v-model="form.password"
        type="password"
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
        placeholder="Enter your password"
        required
      />
    </div>

    <p v-if="errorMessage" class="text-sm text-red-600">
      {{ errorMessage }}
    </p>

    <button
      type="submit"
      class="w-full bg-sky-500 text-white py-3 rounded-lg font-medium hover:bg-sky-600"
    >
      Log In
    </button>

    <p class="text-sm text-center text-slate-500 pt-2">
      Don’t have an account?
      <router-link to="/register" class="text-sky-500 font-medium hover:underline">
        Sign up for free
      </router-link>
    </p>
  </form>
</template>






<script setup>
import { reactive, ref } from 'vue'

const form = reactive({
  email: '',
  password: '',
})

const errorMessage = ref('')

const handleLogin = async () => {
  errorMessage.value = ''

  try {
    const response = await fetch('/api/v1/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(form),
    })

    const data = await response.json()

    if (!response.ok) {
      errorMessage.value = data.message || 'Login failed.'
      return
    }

    localStorage.setItem('token', data.token || '')
    localStorage.setItem('user_id', data.user?.id || '')
    localStorage.setItem('user_name', data.user?.name || 'User')
    localStorage.setItem('user_photo', data.user?.photo || '')

    window.location.href = '/explore'
  } catch (error) {
    errorMessage.value = 'Error!'
  }
}
</script>