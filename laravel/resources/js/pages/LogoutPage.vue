<template>
  <div class="max-w-4xl mx-auto px-4 py-12 text-center">
    <p class="text-slate-600">Logging you out...</p>
  </div>
</template>





<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const handleLogout = async () => {
  const token = localStorage.getItem('token')

  try {
    if (token) {
      await fetch('/api/v1/auth/logout', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${token}`,
        },
      })
    }
  } catch (error) {
    console.log('Logout request failed:', error)
  }

  localStorage.removeItem('token')
  localStorage.removeItem('user_id')
  localStorage.removeItem('user_name')
  localStorage.removeItem('user_photo')

  window.location.href = '/login'
}

onMounted(() => {
  handleLogout()
})
</script>